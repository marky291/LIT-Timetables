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
use Illuminate\Support\Str;
use Livewire\Component;

class Search extends Component
{
    public string $error = '';
    public string $search = '';
    public string $tracker = '';
    public Collection $results;
    public Collection $searches;

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
     * @param string $classname
     * @param int $id
     * @param string $route
     */
    public function click(string $classname, int $id, string $route)
    {
        SearchModel::updateOrCreate(
            ['searchable_type' => $classname, 'searchable_id' => $id, 'cookie_id' => $this->tracker],
            ['updated_at' => now()]
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

        $this->searches = $this->latestSearchedByCookie($this->tracker);
    }

    /**
     * Favorite an item on the search list.
     * @param int $search_id
     */
    public function favorite(int $search_id)
    {
        SearchModel::find($search_id)->update(['favorite' => true]);

        $this->searches = $this->latestSearchedByCookie($this->tracker);
    }

    /**
     * Render the view of hte component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        $this->results = new Collection;

        try {
            if (strlen($this->search)) {
                $this->results = Cache::remember($this->search, now()->addHours(config('search.cache_hours')), function () {
                    return collect([
                        'courses' => Course::search($this->search)->get(),
                        'lecturers' => Lecturer::search($this->search)->get(),
                    ]);
                });
            }
        } catch (Exception $e) {
            $this->error = 'Search is currently unavailable.';
        }

        return view('livewire.search');
    }

    private function latestSearchedByCookie(string $cookie)
    {
        return SearchModel::where('cookie_id', $cookie)
            ->where('created_at', '>', now()->subHours(config('search.cache_hours')))
            ->with('searchable')
            ->latest('updated_at')
            ->limit(config('search.limits.recent'))
            ->get();
    }

    /**
     * We use cookie storage with identifier to database, for search clicks.
     */
    private function defineCookieStorage()
    {
        if (Cookie::has(config('search.cookie.name'))) {
            $this->tracker = (string) Cookie::get(config('search.cookie.name'));
            $this->searches = $this->latestSearchedByCookie($this->tracker);

            return;
        } else {
            $this->tracker = (string) Str::uuid();
            Cookie::queue(config('search.cookie.name'), $this->tracker, config('search.cookie.time'));
        }

        $this->searches = collect();
    }
}
