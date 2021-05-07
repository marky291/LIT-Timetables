<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Search as SearchModel;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

class Search extends Component
{
    public string $error = '';
    public string $search = '';  // input for the search query.
    public Collection $results;

    public function mount()
    {
        $this->results = new Collection;
    }

    public function updatedSearch()
    {
        if (!strlen($this->search)) {
            $this->results = new Collection;
            return;
        }

        try {
            $this->results = Cache::remember("search:$this->search", now()->addHours(config('search.cache_hours')), function ()
            {
                $collection = new Collection;

                $courses    = Course::search($this->search)->get();
                $lecturers  = Lecturer::search($this->search)->get();

                if ($courses->count())   $collection->put('courses', $courses);
                if ($lecturers->count()) $collection->put('lecturers', $lecturers);

                return $collection;
            });
        } catch (Exception $e) {
            $this->error = 'Unexpected error, Search is unavailable. ' . $e->getMessage();
            Log::error("Meilisearch: {$e->getMessage()}");
        }
    }

    public function getSearchesProperty()
    {
        return SearchModel::where('cookie_id', $this->tracker)
            ->where('created_at', '>', now()->subHours(config('search.cache_hours')))
            ->with('searchable')
            ->latest('updated_at')
            ->limit(config('search.limits.recent'))
            ->get();
    }

    public function getTrackerProperty()
    {
        if (!Cookie::has(config('search.cookie.name'))) {
            Cookie::queue(config('search.cookie.name'), (string) Str::uuid(), config('search.cookie.time'));
        }

        return (string) Cookie::get(config('search.cookie.name'));
    }

    /**
     * When a item is clicked in the search bar.
     *
     * @param string $classname
     * @param int $id
     * @param string $route
     */
    public function click(string $classname, int $id, string $route)
    {
        SearchModel::updateOrCreate(
            ['searchable_type' => $classname, 'searchable_id' => $id, 'cookie_id' => $this->tracker],
            ['updated_at' => now()],
        );

        $this->redirect($route);
    }

    /**
     * When a item is deleted in the search bar.
     *
     * @param int $search_id
     */
    public function delete(int $search_id)
    {
        SearchModel::find($search_id)->delete();
    }

    /**
     * Favorite an item on the search list.
     * @param string $classname
     * @param int $search_id
     */
    public function favorite(string $classname, int $search_id)
    {
        SearchModel::updateOrCreate(
            ['searchable_type' => $classname, 'searchable_id' => $search_id, 'cookie_id' => $this->tracker],
            ['updated_at' => now(), 'favorite' => true]
        );
    }

    /**
     * Render the view of hte component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.search');
    }
}
