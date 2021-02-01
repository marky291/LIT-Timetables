<?php

namespace App\Timetable\Commands;

use App\Models\Campus;
use App\Models\Course;
use App\Models\Department;
use App\Models\Lecturer;
use App\Models\Module;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Type;
use App\Timetable\DateConversion;
use App\Timetable\Parsers\ParseFilters;
use App\Timetable\Events\ScheduledDayHasChanged;
use App\Timetable\Events\ScheduledLecturerHasChanged;
use App\Timetable\Events\ScheduledModuleHasChanged;
use App\Timetable\Events\ScheduledRoomHasChanged;
use App\Timetable\Events\ScheduledTimeHasChanged;
use App\Timetable\Events\ScheduledTypeHasChanged;
use App\Timetable\Events\TimetableFetchFailed;
use App\Timetable\Events\TimetableWasChanged;
use App\Timetable\Exceptions\ReturnedBadResponseException;
use App\Timetable\Exceptions\UnknownCourseLocationException;
use App\Timetable\Parsers\ParseCourseName;
use App\Timetable\TimetableLinkCreator;
use App\Timetable\HttpTimetableRequests;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\Regex\Regex;

/**
 * @property HttpTimetableRequests $http
 */
class SyncTimetableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize the data of the application with the LIT Timetable Domain.';

    /**
     * SyncTimetableCommand constructor.
     *
     * @param HttpTimetableRequests $request
     */
    public function __construct(HttpTimetableRequests $request)
    {
        parent::__construct();

        $this->http = $request;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() : int
    {
        /**
         * Let the application know how many departments were
         * processed.
         */
        $this->info("Build started for timetable data.");

        /**
         * The LIT web domain that stores the data we can harvest
         * to create the departments and course lookup data.
         */
        $filter = new ParseFilters(Http::get(config('timetable.url.filter'))->body());

        /**
         * Get all the departments in the filter, map to an array
         * and save into database if it does not exist.
         */
        $output = $this->output;
        $output->progressStart($filter->departments()->count());
        $filter->departments()->map(fn($data) => get_object_vars($data))->each(function($attributes) use ($output) {
            Department::firstOrCreate($attributes);
            $output->progressAdvance();
        });
        $output->progressFinish();

        /**
         * Let the application know how many departments were
         * processed.
         */
        $this->comment("Stored " . Department::count() . " out of " . $filter->departments()->count() . " departments.");
        $this->info("Collecting course data and their associated campuses.");

        /**
         * Get all the courses in the filter, map to an array
         * associate with a campus and save into database
         * if it does not exist.
         */
        $output = $this->output;
        $output->progressStart($filter->courses()->unique('slug')->count());
        $filter->courses()->unique('slug')->each(function($value) use (&$output) {
            $data = (new ParseCourseName($value->name));
            try {
                $dept = Department::firstWhere('filter', $value->filter);
                $camp = Campus::firstOrCreate(['location' => $data->getLocation()]);

                Course::firstOrCreate(['identifier' => $data->getIdentifier()], array_merge($data->toArray(), [
                    'campus_id' => $camp->id,
                    'department_id' => $dept->id,
                ]));
             } catch (UnknownCourseLocationException $e) {
                Log::error("Missing course data in course title {$value->name}.");
            } finally {
                $output->progressAdvance();
            }
        });
        $output->progressFinish();

        /**
         * Let the application know how many departments were
         * processed.
         */
        $this->comment("Stored " . Course::count() . " out of " . $filter->courses()->count() . " courses belonging to " . Campus::count() . " campuses.");
        $this->info("Collecting course schedules.");

        /**
         * Get all the courses in the filter, map to an array
         * associate with a campus and save into database
         * if it does not exist.
         */
        $output = $this->output;
        $course = Course::all();
        $output->progressStart($course->count());
        $course->each(function(Course $course) use ($output) {
            try
            {
                /**
                 * A custom request class that will track outgoing requests
                 * to the timetable on the third party service.
                 * This fires a http request to the third party service.
                 */
                $data = $this->http->crawl($course);

                /**
                 * Check for changes between the previously snapchat of the html
                 * to the current snapshot of the html, we can differentiate
                 * the changes to determine the changes in key and value
                 * and fire an event to let the subscribed users know.
                 */
                $mined = $data->get('schedules')->toArray();
                $stored = optional($course->requests()->latest()->first())->mined;
                if (($stored && $mined) && ($stored != $mined)) {
                    for ($i = 0; $i < count($mined); $i++) {
                        $difference = array_diff_assoc($mined[$i], $stored[$i]);
                        if ($difference) {
                            event(new TimetableWasChanged($course));
                            foreach (array_keys($difference) as $key) {
                                $event = match ($key) {
                                    'lecturer' => ScheduledLecturerHasChanged::class,
                                    'room' => ScheduledRoomHasChanged::class,
                                    'module' => ScheduledModuleHasChanged::class,
                                    'day_of_week' => ScheduledDayHasChanged::class,
                                    'type' => ScheduledTypeHasChanged::class,
                                    'ending_time', 'starting_time' => ScheduledTimeHasChanged::class,
                                };
                                event(new $event($course, $stored, $mined));
                            }
                        }
                    }
                }

                /**
                 * Get the academic week of the incoming request data.
                 */
                $academic_week = (int) Regex::match('/(?<=Weeks selected for output: )(.*)(?= \(\d)/', $data['meta']['week'])->result();

                /**
                 * Delete the schedules for this week so we can recreate the indexing of the schedules.
                 * in the next code block.
                 */
                $course->schedules()->where('academic_week', $academic_week)->delete();

                /**
                 * Lastly we should storage store the schedules belongs to the
                 * course in selected by the loop.
                 */
                $data->get('schedules')->each(function ($attribute) use ($course, $data, $academic_week)
                {
                    $carbon = DateConversion::timetableScheduleToCarbon($attribute, $data['meta']);
                    $module = Module::firstOrCreate(['name' => $attribute['module']]);
                    $room   = Room::firstOrCreate(['door' => $attribute['room']]);
                    $type   = Type::firstOrCreate(['abbreviation' => $attribute['type']]);

                    $schedule = $course->schedules()->firstOrCreate([
                        'starting_date' => $carbon['start'],
                        'ending_date' => $carbon['end'],
                        'module_id' => $module->id,
                        'academic_week' => $academic_week,
                        'room_id' => $room->id,
                        'type_id' => $type->id,
                    ]);

                    /**
                     * Remove previous lecturers associated with the schedule.
                     * and re-sync the collected from the new dataset.
                     */
                    $schedule->lecturers()->sync(collect(explode(', ', $attribute['lecturer']))
                        ->map(fn($name) => Lecturer::firstOrCreate(['fullname' => $name])->id)
                        ->toArray());
                });
            } catch (ReturnedBadResponseException $e) {
                Log::error($e->getMessage());
            } finally {
                $output->progressAdvance();
            }
        });

        /**
         * Let the command know it succeeded.
         */
        return true;
    }
}
