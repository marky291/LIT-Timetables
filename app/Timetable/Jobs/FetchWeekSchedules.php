<?php

namespace App\Timetable\Jobs;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Module;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Type;
use App\Timetable\Converters\ConvertTimetableSource;
use App\Timetable\DateConverter;
use App\Timetable\Events\ScheduledDayHasChanged;
use App\Timetable\Events\ScheduledLecturerHasChanged;
use App\Timetable\Events\ScheduledModuleHasChanged;
use App\Timetable\Events\ScheduledRoomHasChanged;
use App\Timetable\Events\ScheduledTimeHasChanged;
use App\Timetable\Events\ScheduledTypeHasChanged;
use App\Timetable\Events\TimetableFetchFailed;
use App\Timetable\Events\TimetableFetchSuccesfully;
use App\Timetable\Events\TimetableWasChanged;
use App\Timetable\Exceptions\ReturnedBadResponseException;
use Carbon\Carbon;
use Exception;
use Goutte\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Regex\Regex;

class FetchWeekSchedules implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * @var Course
     */
    private $course;

    /**
     * @var string
     */
    private $timetableLink;

    /**
     * Create a new job instance.
     *
     * @param Course $course
     */
    public function __construct(Course $course, string $timetableLink)
    {
        $this->course = $course;

        $this->timetableLink = $timetableLink;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle(Client $http)
    {
        try {
            $beforeTime = microtime(1);
            $rawHtml = $http->request('GET', $this->timetableLink);
            $afterTime = microtime(1);
            $responseTime = $afterTime - $beforeTime;

            if ($http->getInternalResponse()->getStatusCode() !== 200) {
                throw new ReturnedBadResponseException('Response '.$http->getInternalResponse()->getStatusCode().' from '.$this->timetableLink);
            }

            $parsedHtml = ConvertTimetableSource::GetAvailableSchedulesFromCrawler($rawHtml);
            $mined = $parsedHtml->get('schedules')->toArray();
            $stored = optional($this->course->requests()->latest()->first())->mined;

            if (($stored && $mined) && ($stored != $mined)) {
                for ($i = 0; $i < count($mined); $i++) {
                    $difference = array_diff_assoc($mined[$i], $stored[$i]);
                    if ($difference) {
                        event(new TimetableWasChanged($this->course));
                        foreach (array_keys($difference) as $key) {
                            switch ($key) {
                                case 'lecturer': $event = ScheduledLecturerHasChanged::class; break;
                                case 'room': $event = ScheduledRoomHasChanged::class; break;
                                case 'module': $event = ScheduledModuleHasChanged::class; break;
                                case 'day_of_week':  $event = ScheduledDayHasChanged::class; break;
                                case 'type':  $event = ScheduledTypeHasChanged::class; break;
                                case 'ending_time': $event = ScheduledTimeHasChanged::class; break;
                                case 'starting_time': $event = ScheduledTimeHasChanged::class; break;
                            }
                            event(new $event($this->course, $stored, $mined));
                        }
                    }
                }
            }

            $course = $this->course;

            DB::transaction(function () use ($course, $parsedHtml, $http, $responseTime) {
                $course->requests()->create([
                    'response' => $http->getInternalResponse()->getStatusCode(),
                    'time' => round($responseTime, 3),
                    'link' => $this->timetableLink,
                    'meta' => $parsedHtml['meta'],
                    'mined' => $parsedHtml->get('schedules'),
                ]);

                /** @var Schedule $schedules */
                foreach ($parsedHtml->get('schedules') as $csv_schedule) {
                    $schedule = $course->schedules()->firstOrCreate([
                        'starting_date' => $this->dateExtract($csv_schedule, $parsedHtml['meta'])['start'],
                        'ending_date' => $this->dateExtract($csv_schedule, $parsedHtml['meta'])['end'],
                        'module_id' => Module::firstOrCreate(['name' => $csv_schedule['module']])->id,
                        'academic_week' => (int) Regex::match('/(?<=Weeks selected for output: )(.*)(?= \(\d)/', $parsedHtml['meta']['week'])->result(),
                        'room_id' => Room::firstOrCreate(['door' => $csv_schedule['room']])->id,
                        'type_id' => Type::firstOrCreate(['abbreviation' => $csv_schedule['type']])->id,
                    ]);

                    $schedule->lecturers()->sync(Str::of($csv_schedule['lecturer'])->explode(', ')->map(function ($value) {
                        return Lecturer::firstOrCreate([
                            'fullname' => $value,
                        ])->id;
                    })->collect()->toArray());
                }
            });
        } catch (Exception $e) {
            event(new TimetableFetchFailed($this->course));

            return;
        }

        event(new TimetableFetchSuccesfully($this->course));
    }

    /**
     * @param array $schedule
     * @param array $meta
     * @return array
     */
    private function dateExtract(array $schedule, array $meta)
    {
        $matches = [];

        preg_match_all("/\d{1,2} [a-zA-Z]{3} \d{4}/", $meta['week'], $matches);

        $carbonStart = Carbon::parse($matches[0][0])->addRealDays(DateConverter::convertShorthandDateToInt($schedule['day_of_week']))->setTimeFromTimeString($schedule['starting_time'])->toDateTimeString();
        $carbonEnd = Carbon::parse($matches[0][0])->addRealDays(DateConverter::convertShorthandDateToInt($schedule['day_of_week']))->setTimeFromTimeString($schedule['ending_time'])->toDateTimeString();

        return ['start' => $carbonStart, 'end' => $carbonEnd];
    }
}
