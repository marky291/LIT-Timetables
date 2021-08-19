<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Schedule;
use App\Models\Lecturer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Statistics extends Component
{
    public function getCourseCountProperty() : int
    {
        return Course::count();
    }

    public function getLecturerCountProperty() : int
    {
        return Lecturer::count();
    }

    public function getScheduleCountProperty() : int
    {
        return Schedule::count();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.statistics');
    }
}
