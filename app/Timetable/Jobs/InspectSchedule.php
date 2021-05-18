<?php

namespace App\Timetable\Jobs;

use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Module;
use App\Models\Room;
use App\Models\Type;
use App\Timetable\DateConversion;
use App\Timetable\HttpTimetableRequests;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Spatie\Regex\Regex;

class InspectSchedule implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 6;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Course $course) {}

    /**
    * Calculate the number of seconds to wait before retrying the job.
    *
    * @return array
    */
    public function backoff(): array
    {
        return [300, 600, 1800, 3600, 21600, 43200];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /**
         * A custom request class that will track outgoing requests
         * to the timetable on the third party service.
         * This fires a http request to the third party service.
         */
        $data = (new HttpTimetableRequests)->crawl($this->course);

        /**
         * Check for changes between the previously snapchat of the html
         * to the current snapshot of the html, we can differentiate
         * the changes to determine the changes in key and value
         * and fire an event to let the subscribed users know.
         */
        $newSchedules = $data->get('schedules')->toArray();
        $oldSchedules =  optional($this->course->requests()->latest()->first())->mined;

        if ($oldSchedules != null && $newSchedules != null)
            CompareSchedule::dispatch($this->course, collect($oldSchedules), collect($newSchedules));

        /**
         * Get the academic week of the incoming request data.
         */
        $academic_week = (int) Regex::match('/(?<=Weeks selected for output: )(.*)(?= \(\d)/', $data['meta']['week'])->result();

        /**
         * Delete the schedules for this week so we can recreate the indexing of the schedules.
         * in the next code block.
         */
        $this->course->schedules()->where('academic_week', $academic_week)->delete();

        /**
         * Lastly we should storage store the schedules belongs to the
         * course in selected by the loop.
         */
        $data->get('schedules')->each(function ($schedule) use ($data, $academic_week)
        {
            $this->modelThreadLock(Module::class, ['name' => $schedule['module']]);
            $this->modelThreadLock(Room::class,   ['door' => $schedule['room']]);
            $this->modelThreadLock(Type::class,   ['abbreviation' => $schedule['type']]);

            Str::of($schedule['lecturer'])->explode(', ')->each(function($name) {
                $this->modelThreadLock(Lecturer::class, ['fullname' => $name]);
            });

            /**
             * Convert the meta dates to carbon formats for model calenders.
             */
            $date = DateConversion::timetableScheduleToCarbon($schedule, $data['meta']);

            /**
             * Store the schedule after looking up the relational ids.
             */
            $model = $this->course->schedules()->firstOrCreate([
                'starting_date' => $date['start'],
                'ending_date' => $date['end'],
                'module_id' => Module::firstWhere('name', $schedule['module'])->getKey(),
                'academic_week' => $academic_week,
                'room_id' => Room::firstWhere('door', $schedule['room'])->getKey(),
                'type_id' => Type::firstWhere('abbreviation', $schedule['type'])->getKey(),
            ]);

            /**
             * Remove previous lecturers associated with the schedule.
             * and re-sync the collected from the new dataset.
             */
            $model->lecturers()->sync(Lecturer::whereIn('fullname', explode(", ", $schedule['lecturer']))->get());
        });
    }

    /**
     * Lock a model thread so we dont duplicate creation.
     */
    public function modelThreadLock(string $model, array $attributes)
    {
        if (Cache::lock("create_{$attributes[array_key_first($attributes)]}_lock",300)->get()) {
            $model::firstOrCreate($attributes);
        }
    }
}
