<?php

namespace App\Observers;

use App\Models\Schedule;

class ScheduleObserver
{
    public function creating(Schedule $schedule)
    {
        if (app()->runningUnitTests()) {
            $schedule->academic_year = $schedule->starting_date->year;
        }
    }
}
