<?php

namespace App\Http\Livewire\Schedules;

use App\Timetable\Collections\ScheduleCollection;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Upcoming extends Component
{
    /** @var Collection */
    public $schedules;

    /** @var ScheduleCollection */
    public $upcoming;

    /**
     * Mount the component.
     */
    public function mount()
    {
        $this->upcoming = $this->schedules->today();
    }

    /**
     * Render the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.schedules.upcoming');
    }
}
