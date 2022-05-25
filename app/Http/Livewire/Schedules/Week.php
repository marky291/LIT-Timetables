<?php

namespace App\Http\Livewire\Schedules;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Schedule;
use App\Models\ScheduleCollection;
use App\Services\SemesterPeriodDateService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Week extends Component
{
    public Lecturer|Course $model;
    public int $current_week;
    public bool $readyToLoad = false;

    public function mount(int $viewing_week)
    {
        $this->current_week = $viewing_week;
        $this->available_weeks = [];
        $this->available_week_key = 0;
    }

    public function getAvailableWeeksProperty()
    {
        // @todo: Use the new schedule_year to get the available weeks....

        // hopefully this does take into account 1 = new academic year.
        //return Schedule::latestAcademicYear()->groupBy('academic_week')->orderBy('academic_week')->pluck('academic_week')->collect();
    }

    public function getSelectedWeekProperty()
    {
        return $this->available_weeks->get($this->available_week_key);
    }

    public function loadWeek()
    {
        $this->available_weeks = $this->availableWeeks;

        // get the key closest to the current viewing week.
        foreach ($this->available_weeks->sortKeysDesc() as $key => $week) {
            if ($week <= $this->current_week) {
                $this->available_week_key = $key;
                break;
            }
        }

        $this->readyToLoad = true;
    }

    public function incrementWeek()
    {
        if ($this->hasNextWeek) {
            $this->available_week_key++;
        }
    }

    public function decrementWeek()
    {
        if ($this->hasPreviousWeek) {
            $this->available_week_key--;
        }
    }

    public function getIsViewingThisWeekProperty()
    {
        return $this->selected_week == $this->current_week;
    }

    public function getHasPreviousWeekProperty()
    {
        return $this->available_weeks->has($this->available_week_key - 1);
    }

    public function getHasNextWeekProperty()
    {
        return $this->available_weeks->has($this->available_week_key + 1);
    }

    public function getDaysProperty()
    {
        return Cache::remember($this->model->getKey() . "_schedule_week_" . $this->selectedWeek, now()->addMinutes(30), function () {
            return $this->model->schedules()->whereWeek($this->selectedWeek)->with(['room', 'module', 'type', 'lecturers'])->get()->sortWeek();
        });
    }

    public function render()
    {
        return view('livewire.schedules.week');
    }
}
