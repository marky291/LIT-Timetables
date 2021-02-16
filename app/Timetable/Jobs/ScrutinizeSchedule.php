<?php

namespace App\Timetable\Jobs;

use App\Models\Course;
use App\Timetable\Events\TimetableWasChanged;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ScrutinizeSchedule implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var array */
    public $schedule;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Course $course, Collection $schedule)
    {
        $this->schedule = $schedule->toArray();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->stored = optional($this->course->requests()->latest()->first())->mined;

        if (($this->stored && $this->schedule) && ($this->stored != $this->schedule)) {
            for ($i = 0; $i < count($this->schedule); $i++) {
                $difference = array_diff_assoc($this->schedule[$i], $this->stored[$i]);
                if ($difference) {
                    event(new TimetableWasChanged($this->course));
                    foreach (array_keys($difference) as $key) {
                        $event = match ($key) {
                            'lecturer' => ScheduledLecturerHasChanged::class,
                            'room' => ScheduledRoomHasChanged::class,
                            'module' => ScheduledModuleHasChanged::class,
                            'day_of_week' => ScheduledDayHasChanged::class,
                            'type' => ScheduledTypeHasChanged::class,
                            'ending_time', 'starting_time' => ScheduledTimeHasChanged::class,
                        };
                        event(new $event($this->course, $this->stored, $this->schedule));
                    }
                }
            }
        }
    }
}
