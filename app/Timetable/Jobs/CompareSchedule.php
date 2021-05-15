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
    public function __construct(public Course $course, public array $oldSchedule, public array $newSchedule){}

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        if (!$this->oldSchedule || !$this->newSchedule) {
            return;
        }

        if (count(array_keys($this->oldSchedule)) != count(array_keys($this->newSchedule))) {
            return;
        }

        if (array_diff_assoc($this->oldSchedule, $this->newSchedule)) {
            event(new TimetableScheduleChanged($this->course));
        }
    }
}
