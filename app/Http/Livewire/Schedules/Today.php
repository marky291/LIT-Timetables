<?php

namespace App\Http\Livewire\Schedules;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Today extends Component
{
    /** @var Collection */
    public $schedules;

    public function render()
    {
        return view('livewire.schedules.today', [
            'today' => $this->schedules->today(),
        ]);
    }
}
