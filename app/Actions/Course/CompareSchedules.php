<?php

namespace App\Actions\Course;

use App\Events\ScheduleChanged;
use App\Models\Course;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class CompareSchedules
{
    use AsAction;

    public function handle(Course $course, Collection $oldSchedule, Collection $newSchedule)
    {
        /**
         * We do not need to check if the arrays are both empty.
         */
        if ($oldSchedule->isEmpty() && $newSchedule->isEmpty()) {
            return;
        }

        /**
         * We know its changed if they array counts do not match.
         */
        if ($oldSchedule->count() != $newSchedule->count()) {
            event(new ScheduleChanged($course));

            return;
        }

        /**s
         * Same count of schedules, lets check for inner individual changes.
         */
        if ($oldSchedule->count() == $newSchedule->count()) {
            foreach ($newSchedule as $key => $schedule) {
                if (count(array_diff_assoc($newSchedule[$key], $oldSchedule[$key]))) {
                    event(new ScheduleChanged($course));

                    return;
                }
            }
        }
    }
}
