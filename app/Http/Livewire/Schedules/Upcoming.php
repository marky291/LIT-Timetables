<?php

namespace App\Http\Livewire\Schedules;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Schedule;
use App\Models\ScheduleCollection;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Upcoming extends Component
{
    public Lecturer|Course $model;

    public bool $readyToLoad = false;

    public int $viewing_week;

    public function loadUpcoming()
    {
        $this->readyToLoad = true;
    }

    public function getScheduleProperty()
    {
        return Cache::remember($this->model->getKey().'_upcoming_schedule_week_'.$this->viewing_week, now()->addMinutes(30), function () {
            return $this->model->schedules()->today()->with(['room', 'module', 'type', 'lecturers'])->get()->distinct();
        });
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
