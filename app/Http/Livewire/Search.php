<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Lecturer;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Search extends Component
{
    public $query = '';
    public $results = [];

    public function resetForm()
    {
        $this->query = '';
        $this->results = [];
    }

    public function render()
    {
        $this->results = [];

        if (strlen($this->query)) {
            $this->results = Cache::remember($this->query, now()->addMinutes(45), function () {
                $results['courses'] = Course::search($this->query)->get();
                $results['lecturers'] = Lecturer::search($this->query)->get();

                return $results;
            });
        }

        return view('livewire.search');
    }
}
