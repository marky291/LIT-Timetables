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
    public bool $loaded = false;

    public function incrementWeek()
    {
        $this->viewing_week++;
    }

    public function decrementWeek()
    {
        $this->viewing_week--;
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
