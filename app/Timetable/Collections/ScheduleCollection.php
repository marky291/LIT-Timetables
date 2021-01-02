<?php

namespace App\Timetable\Collections;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;

class ScheduleCollection extends Collection
{
    /**
     * Get the latest week we have available
     * and get the one that matches todays day.
     *
     * @return ScheduleCollection
     */
    public function today()
    {
        return $this->filter(function (Schedule $schedule) {
            return $schedule->starting_date->dayOfWeek == now()->dayOfWeek;
        });
    }

    /**
     * @return ScheduleCollection
     */
    public function upcoming()
    {
        return $this->filter(function (Schedule $schedule) {
            return now() <= $schedule->ending_date;
        });
    }

    /**
     * @return ScheduleCollection
     */
    public function distinct()
    {
        return $this->unique('starting_date')->sortBy('starting_date');
    }
}
