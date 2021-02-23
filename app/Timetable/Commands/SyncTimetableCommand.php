<?php

namespace App\Timetable\Commands;

use App\Models\Campus;
use App\Models\Course;
use App\Models\Department;
use App\Timetable\Exceptions\UnknownCourseLocationException;
use App\Timetable\HttpTimetableRequests;
use App\Timetable\Jobs\InspectSchedule;
use App\Timetable\Parsers\ParseCourseName;
use App\Timetable\Parsers\ParseFilters;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
    public function handle(): int
    {
        /**
         * Let the application know how many departments were
         * processed.
         */
        $this->info('Build started for timetable data.');

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
        $filter->departments()->map(fn ($data) => get_object_vars($data))->each(function ($attributes) use ($output) {
            Department::firstOrCreate($attributes);
            $output->progressAdvance();
        });
        $output->progressFinish();

        /**
         * Let the application know how many departments were
         * processed.
         */
        $this->comment('Stored '.Department::count().' out of '.$filter->departments()->count().' departments.');
        $this->info('Collecting course data and their associated campuses.');

        /**
         * Get all the courses in the filter, map to an array
         * associate with a campus and save into database
         * if it does not exist.
         */
        $output = $this->output;
        $output->progressStart($filter->courses()->unique('slug')->count());
        $filter->courses()->unique('slug')->each(function ($value) use (&$output) {
            $data = (new ParseCourseName($value->name));
            try {
                Course::firstOrCreate(['identifier' => $data->getIdentifier()], array_merge($data->toArray(), [
                    'campus_id' => Campus::firstOrCreate(['location' => $data->getLocation()])->id,
                    'department_id' => Department::firstWhere('filter', $value->filter)->id,
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
        $this->comment('Stored '.Course::count().' out of '.$filter->courses()->count().' courses belonging to '.Campus::count().' campuses.');
        $this->info('Collecting course schedules.');

        /**
         * Get all the courses in the filter, map to an array
         * associate with a campus and save into database
         * if it does not exist.
         */
        $output = $this->output;
        $course = Course::all();
        $output->progressStart($course->count());
        $course->each(function (Course $course) use ($output) {
            InspectSchedule::dispatch($course);
            $output->progressAdvance(1);
        });

        $this->comment('Schedules have been dispatched successfully to threads.');
        $this->info('Done.');

        /**
         * Let the command know it succeeded.
         */
        return true;
    }
}
