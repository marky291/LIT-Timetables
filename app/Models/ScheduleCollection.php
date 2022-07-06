<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;

class ScheduleCollection extends Collection
{
    public function today(): self
    {
        return $this->filter(fn ($schedule) =>  $schedule->starting_date->dayOfWeek == now()->dayOfWeek);
    }

    public function upcoming(): self
    {
        return $this->filter(fn ($schedule) => $schedule->ending_date->format('Hi') > now()->format('Hi'));
    }

    public function distinct(): self
    {
        return $this->unique('starting_date')->sortBy('starting_date');
    }

    public function sortWeek(): self
    {
        return $this->distinct()->groupBy(fn ($schedule) => $schedule->starting_date->format('d-m-Y'));
    }
}
