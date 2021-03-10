<?php

namespace App\Http\Livewire\Schedules;

use App\Timetable\Collections\ScheduleCollection;
use Livewire\Component;

class Week extends Component
{
    /** @var ScheduleCollection */
    public $schedules;

    public function render()
    {
        return view('livewire.schedules.week', [
            'days' => $this->schedules->sortweek(),
        ]);
    }
}
