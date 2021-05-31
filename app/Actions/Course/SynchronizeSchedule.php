<?php

namespace App\Actions\Course;

use App\Actions\Schedule\TransformDateToCarbon;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Module;
use App\Models\Room;
use App\Models\Type;
use App\Services\AsynchronousModelService;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\Regex\Regex;

class SynchronizeSchedule
{
    use AsAction;

    public function handle(Course $course)
    {
        /**
         * A custom request class that will track outgoing requests
         * to the timetable on the third party service.
         * This fires a http request to the third party service.
         */
        $timetable = FetchTimetable::run($course);

        /**
         * Get the academic week of the incoming request timetable.
         */
        $academic_week = (int) Regex::match('/(?<=Weeks selected for output: )(.*)(?= \(\d)/',
            $timetable['meta']['week']
        )->result();

        /**
         * Delete the schedules for this week so we can recreate the indexing of the schedules.
         * in the next code block.
         */
        $course->schedules()->where('academic_week', $academic_week)->delete();

        /**
         * Lastly we should storage store the schedules belongs to the
         * course in selected by the loop.
         */
        $timetable->get('schedules')->each(function ($schedule) use ($timetable, $course, $academic_week)
        {
            $async = new AsynchronousModelService();
            $async->create(Module::class, ['name' => $schedule['module']]);
            $async->create(Room::class,   ['door' => $schedule['room']]);
            $async->create(Type::class,   ['abbreviation' => $schedule['type']]);

            Str::of($schedule['lecturer'])->explode(', ')->each(function($name) use ($async) {
                $async->create(Lecturer::class, ['fullname' => $name]);
            });

            /**
             * Store the schedule after looking up the relational ids.
             *
             * @var Course $model
             */
            $model = $course->schedules()->firstOrCreate([
                'academic_week' => $academic_week,
                'starting_date' =>
                    TransformDateToCarbon::run($timetable['meta']['week'],
                        $schedule['day_of_week'],
                        $schedule['starting_time']
                    )->toDateTimeString(),
                'ending_date' =>
                    TransformDateToCarbon::run($timetable['meta']['week'],
                        $schedule['day_of_week'],
                        $schedule['ending_time']
                    )->toDateTimeString(),
                'module_id' => Module::firstWhere('name', $schedule['module'])->getKey(),
                'room_id' => Room::firstWhere('door', $schedule['room'])->getKey(),
                'type_id' => Type::firstWhere('abbreviation', $schedule['type'])->getKey(),
            ]);

            /**
             * Remove previous lecturers associated with the schedule.
             * and re-sync the collected from the new dataset.
             */
            $model->lecturers()->sync(
                Lecturer::whereIn('fullname', explode(", ", $schedule['lecturer'])
            )->pluck('id'));
        });

        /**
         * Check for changes between the previously snapchat of the html
         * to the current snapshot of the html, we can differentiate
         * the changes to determine the changes in key and value
         * and fire an event to let the subscribed users know.
         */
        $newSchedules = collect($timetable->get('schedules')->toArray());

        /**
         * Skip the latest because we just made a new request, we want the second first.
         */
        $oldSchedules = collect($course->requests()->latest()->skip(1)->first()?->mined);

        /**
         * Lets compare the schedules and determine if we need to send emails..s
         */
        CompareSchedules::dispatchIf($oldSchedules->count() && $newSchedules->count(),
            $course, $oldSchedules, $newSchedules
        );
    }
}
