<?php

namespace App\Http\Livewire\Schedules;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Week extends Component
{
    /** @var Collection */
    public $schedules;

    public function render()
    {
        return view('livewire.schedules.week', [
            'days' => $this->schedules->sortweek(),
        ]);
    }
}
