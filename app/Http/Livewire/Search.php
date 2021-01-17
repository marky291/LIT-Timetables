<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Favorite;
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
    public Collection $favorites;

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
     * @param int $search_id
     */
    public function favorite(int $search_id)
    {
        $model = SearchModel::find($search_id)->searchable;

        // store...
    }

    /**
     * When a item is deleted in the search bar.
     *
     * @param int $search_id
     */
    public function delete(int $search_id)
    {
        SearchModel::find($search_id)->delete();

        $this->recent = $this->latestSearchedByCookie($this->tracker);
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

    private function latestSearchedByCookie(string $cookie)
    {
        return SearchModel::where('cookie_id', $cookie)
            ->where('created_at', '>', now()->subHours(config('search.cache_hours')))
            ->with('searchable')
            ->latest('updated_at')
            ->limit(config('search.limits.recent'))
            ->get()
            ->unique('searchable_id', 'searchable_type');
    }

    private function latestFavoritableByCookie(string $cookie)
    {
        return Favorite::where('cookie_id', $cookie)
            ->where('created_at', '>', now()->subHours(config('search.cache_hours')))
            ->with('favorable')
            ->latest('updated_at')
            ->limit(config('search.limits.recent'))
            ->get()
            ->unique('favorable_id', 'favorable_type');
    }

    /**
     * We use cookie storage with identifier to database, for search clicks.
     */
    private function defineCookieStorage()
    {
        if (Cookie::has(config('search.cookie.name'))) {
            $this->tracker = (string) Cookie::get(config('search.cookie.name'));
            $this->recent = $this->latestSearchedByCookie($this->tracker);
            $this->favorites = $this->latestFavoritableByCookie($this->tracker);

            return;
        } else {
            $this->tracker = (string) Str::uuid();
            Cookie::queue(config('search.cookie.name'), $this->tracker, config('search.cookie.time'));
        }

        $this->recent = $this->favorites = collect();
    }
}
