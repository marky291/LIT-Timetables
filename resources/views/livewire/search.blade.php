<div x-data="{ open: false, selected: 0, total: 5 }"
x-on:keydown.arrow-down="selected >= total ? selected = total : selected = selected + 1; console.log(selected);"
x-on:keydown.arrow-up="selected <= 0 ? selected = 0 : selected = selected - 1; console.log(selected);"
x-on:keydown.escape="open = false;"
x-on:search.window="open = true; $nextTick(() => $refs.searchbar.focus())"
>

    <div x-cloak x-show="open" id="search-container" class="fixed top-0 left-0 z-10 w-full h-screen lg:h-full lg:p-28" style="background: rgba(0,0,0,.25)">

        <div x-on:click.away="open = false" class="border border-transparent dark:border-gray-700 flex flex-col w-full lg:max-w-3xl h-screen lg:h-auto lg:max-h-full mx-auto bg-white dark:bg-dark-background dark:border dark:border-gray-200 lg:rounded-2xl" style="box-shadow: 0 25px 50px -12px rgba(0,0,0,.25)">

            <header class="flex items-center justify-between mx-6 border-b border-gray-200 dark:border-dark-border">
                <div class="flex items-center flex-1">
                    <div class="self-center text-indigo-700">
                        <svg wire:loading.remove class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <svg wire:loading class="w-7 h-7 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>
                    <input
                        x-ref="searchbar"
                        x-on:keydown.arrow-up.prevent
                        x-on:keydown.arrow-down.prevent
                        wire:model="search"
                        type="text"
                        class="h-20 flex-1 text-lg border-none focus:ring-0 dark:text-dark-text dark:bg-dark-background"
                        placeholder="Search Courses">
                </div>
                <div class="hidden lg:block">
                    <button @click="open = false">
                        <span class="text-gray-400 text-sm leading-5 py-0.5 px-1.5 border border-gray-300 rounded-md">
                            <span class="sr-only">Press </span>
                            <kbd class="font-sans">esc</kbd>
                            <span class="sr-only"> to quit search</span>
                        </span>
                    </button>
                </div>
                <div class="lg:hidden">
                    <button @click="open = false">
                        <span class="text-gray-400 text-sm leading-5 py-0.5 px-1.5 border border-gray-300 rounded-md">
                            <span class="sr-only">Press </span>
                            <kbd class="font-sans">close</kbd>
                            <span class="sr-only"> to quit search</span>
                        </span>
                    </button>
                </div>
            </header>

            <section class="px-6 overflow-auto">

                @if (empty($error) == false)
                    <div class="py-12 text-lg text-gray-500">
                        {{ $error }}
                    </div>
                @elseif ($search == '' && !$this->searches->count())
                    <div class="py-12 text-lg text-gray-500 dark:text-dark-icon">
                        No recent searches
                    </div>
                @elseif ($search != '' && !$this->results->count())
                    <div class="py-12 text-lg text-gray-500 dark:text-dark-icon">
                        No search results found
                    </div>
                @elseif ($this->results->count())
                    @foreach($this->results as $title => $collection)
                        @if($collection->count())
                            @include('search.list', [
                                'title' => $title,
                                'collection' => $collection,
                            ])
                        @endif
                    @endforeach
                @else
                    @if ($this->searches->count())
                        @if ($this->searches->where('favorite', false)->count())
                            @include('search.list', [
                                'title' => 'Recent',
                                'removable' => true,
                                'favorable' => true,
                                'collection' => $this->searches->where('favorite', false)
                            ])
                        @endif
                        @if ($this->searches->where('favorite', true)->count())
                            @include('search.list', [
                                'title' => 'Favorites',
                                'removable' => true,
                                'collection' => $this->searches->where('favorite', true)
                            ])
                        @endif
                    @endif
                @endif

            </section>

            <footer class="flex mt-6 justify-end py-5 mx-6 border-t border-gray-200 dark:border-dark-border dark:text-white">
                <div class="flex items-center w-6 h-6 mr-1">
                    <img src="{{ config('services.meilisearch.icon') }}" alt="">
                </div>
                MeiliSearch
            </footer>

        </div>

    </div>

</div>
