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
    public function today(): ScheduleCollection
    {
        return $this->filter(fn ($schedule) =>  $schedule->starting_date->dayOfWeek == now()->dayOfWeek);
    }

    /**
     * @return ScheduleCollection
     */
    public function upcoming(): ScheduleCollection
    {
        return $this->filter(fn ($schedule) => now() < $schedule->ending_date);
    }

    /**
     * @return ScheduleCollection
     */
    public function distinct(): ScheduleCollection
    {
        return $this->unique('starting_date')->sortBy('starting_date');
    }

    /**
     * @return ScheduleCollection
     */
    public function sortWeek(): ScheduleCollection
    {
        return $this->sortBy('starting_date')->groupBy(fn ($schedule) => $schedule->starting_date->format('d-m-Y'))->sortKeys();
    }
}
