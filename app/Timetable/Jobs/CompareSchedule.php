<?php

namespace App\Timetable\Jobs;

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

        if ($this->oldSchedule->isEmpty() || $this->newSchedule->isEmpty()) {
            return;
        }

        foreach ($this->newSchedule as $key => $schedule) {
            if (count(array_keys($schedule)) != 7) {
                throw new \Exception("Array value does not have 7 keys for comparison");
            }

            if (count(array_diff_assoc($this->oldSchedule[$key], $this->newSchedule[$key]))) {
                event(new TimetableScheduleChanged($this->course));
                return;
            }
        }
    }
}
