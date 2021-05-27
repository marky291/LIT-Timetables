<?php

namespace App\Timetable\Jobs;

use App\Exceptions\ScheduleComparisonIncorrectSize;
use App\Models\Course;
use App\Timetable\Events\TimetableScheduleChanged;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class CompareSchedule implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Course $course, public Collection $oldSchedule, public Collection $newSchedule){}

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        /**
         * We do not need to check if the arrays are both empty.
         */
        if ($this->oldSchedule->isEmpty() && $this->newSchedule->isEmpty()) {
            return;
        }

        /**
         * We know its changed if they array counts do not match.
         */
        if ($this->oldSchedule->count() != $this->newSchedule->count()) {
            event(new TimetableScheduleChanged($this->course));
            return;
        }

        /**
         * Same count of schedules, lets check for inner individual changes.
         */
        if ($this->oldSchedule->count() == $this->newSchedule->count()) {
            foreach ($this->newSchedule as $key => $schedule) {
                if (count(array_diff_assoc($this->newSchedule[$key], $this->oldSchedule[$key]))) {
                    event(new TimetableScheduleChanged($this->course));
                    return;
                }
            }
        }
    }
}
