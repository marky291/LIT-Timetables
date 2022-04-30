<?php

namespace App\Http\Livewire\Schedules;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\ScheduleCollection;
use App\Services\SemesterPeriodDateService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Week extends Component
{
    public Lecturer|Course $model;
    public int $viewing_week;
    public int $this_week;
    public int $max_viewing_week;
    public bool $readyToLoad = false;

    public function mount(int $viewing_week)
    {
        $this->this_week = $viewing_week;
        $this->max_viewing_week = $viewing_week + config('services.lit.relay.weeks_to_fetch');
    }

    public function loadWeek()
    {
        $this->readyToLoad = true;
    }

    public function incrementWeek()
    {
        if ($this->hasNextWeek) {
            $this->viewing_week++;
        }
    }

    public function decrementWeek()
    {
        if ($this->hasPreviousWeek) {
            $this->viewing_week--;
        }
    }

    public function getIsViewingThisWeekProperty()
    {
        return $this->viewing_week == $this->this_week;
    }

    public function getHasPreviousWeekProperty()
    {
        return $this->viewing_week > 1;
    }

    public function getHasNextWeekProperty()
    {
        return $this->viewing_week < $this->max_viewing_week;
    }

    public function getDaysProperty()
    {
        return Cache::remember($this->model->getKey() . "_schedule_week_" . $this->viewing_week, now()->addMinutes(30), function () {
            return $this->model->schedules()->whereWeek($this->viewing_week)->with(['room', 'module', 'type', 'lecturers'])->get()->sortWeek();
        });
    }

    public function render()
    {
        return view('livewire.schedules.week');
    }
}
