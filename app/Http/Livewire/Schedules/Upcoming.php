<?php

namespace App\Http\Livewire\Schedules;

use Livewire\Component;

class Upcoming extends Component
{
    /** @var Collection */
    public $schedules;

    public function render()
    {
        return view('livewire.schedules.upcoming', [
            'today' => $this->schedules->today()->upcoming(),
        ]);
    }
}
