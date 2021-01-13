<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Search as SearchModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Livewire\Component;

class Search extends Component
{
    public string $search = '';
    public string $tracker = '';
    public Collection $results;
    public Collection $recent;

    /**
     * Mount the component.
     */
    public function mount()
    {
        if (! $this->tracker) {
            $this->defineCookieStorage();
        }
    }

    /**
     * When a item is clicked in the search bar.
     *
     * @param int $course_id
     */
    public function clicked(string $classname, int $id)
    {
        $model = $classname::firstWhere('id', $id);
        $model->searches()->save(new SearchModel(['cookie_id' => $this->tracker]));
        $this->redirect($model->route);
    }

    /**
     * Render the view of hte component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        $this->results = new Collection;

        if (strlen($this->search)) {
            $this->results = Cache::remember($this->search, now()->addHours(config('search.cache_hours')), function () {
                return collect([
                    'courses' => Course::search($this->search)->get(),
                    'lecturers' => Lecturer::search($this->search)->get(),
                ]);
            });
        }

        return view('livewire.search');
    }

    /**
     * We use cookie storage with identifier to database, for search clicks.
     */
    private function defineCookieStorage()
    {
        if (Cookie::has(config('search.cookie.name'))) {
            $this->tracker = (string) Cookie::get(config('search.cookie.name'));
            $this->recent = SearchModel::where('cookie_id', $this->tracker)
                ->with('searchable')
                ->latest()
                ->limit(config('search.limits.recent'))
                ->get();

            return;
        } else {
            $this->tracker = (string) Str::uuid();
            Cookie::queue(config('search.cookie.name'), $this->tracker, config('search.cookie.time'));
        }

        $this->recent = collect();
    }
}
