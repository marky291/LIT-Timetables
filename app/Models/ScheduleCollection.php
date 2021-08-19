<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;

class ScheduleCollection extends Collection
{
    public function today(): ScheduleCollection
    {
        return $this->filter(fn ($schedule) =>  $schedule->starting_date->dayOfWeek == now()->dayOfWeek);
    }

    public function upcoming(): ScheduleCollection
    {
        return $this->filter(fn ($schedule) => $schedule->ending_date->format('Hi') > now()->format('Hi'));
    }

    public function distinct(): ScheduleCollection
    {
        return $this->unique('starting_date')->sortBy('starting_date');
    }

    public function sortWeek(): ScheduleCollection
    {
        return $this->distinct()->groupBy(fn ($schedule) => $schedule->starting_date->format('d-m-Y'));
    }
}
