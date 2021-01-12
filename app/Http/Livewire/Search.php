<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Lecturer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class Search extends Component
{
    public string $search = '';
    public Collection $results;
    public Collection $recent;

    public function resetForm()
    {
        $this->search = '';
        $this->results->dump();
    }

    public function clicked(mixed $model)
    {
        Cookie::queue('recent_searches', $this->recent->add($model), 3);
    }

    public function mount()
    {
        $this->recent = collect();

        $cookie = Cookie::get('recent_searches', collect());

//        dd(json_decode(($cookie))[0]);
    }

    public function render()
    {
        $this->results = new Collection;

        if (strlen($this->search)) {
            $this->results = Cache::remember($this->search, now()->addMinutes(45), function () {
                return collect([
                    'courses' => Course::search($this->search)->get(),
                    'lecturers' => Lecturer::search($this->search)->get(),
                ]);
            });
        }

        return view('livewire.search');
    }
}
