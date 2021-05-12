<?php

namespace App\Timetable\Collections;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;

class ScheduleCollection extends Collection
{
    /**
     * Get the latest week we have available
     * and get the one that matches today's day.
     *
     * @return ScheduleCollection
     */
    public function today(): ScheduleCollection
    {
        return $this->filter(fn ($schedule) =>  $schedule->starting_date->dayOfWeek == now()->dayOfWeek);
    }

    /**
     * Get the ones that are schedule for after current time.
     *
     * @return ScheduleCollection
     */
    public function upcoming(): ScheduleCollection
    {
        return $this->filter(fn ($schedule) => $schedule->ending_date->format('Hi') > now()->format('Hi'));
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
        return $this->distinct()->groupBy(fn ($schedule) => $schedule->starting_date->format('d-m-Y'))->sortKeys();
    }
}
