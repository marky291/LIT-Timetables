<div x-data="{ open: false, selected: 0, total: 5 }"
x-on:keydown.arrow-down="selected >= total ? selected = total : selected = selected + 1; console.log(selected);"
x-on:keydown.arrow-up="selected <= 0 ? selected = 0 : selected = selected - 1; console.log(selected);"
x-on:keydown.escape="open = false;"
x-on:search.window="open = true; $nextTick(() => $refs.searchbar.focus())"
>

    <div x-cloak x-show="open" id="search-container" class="fixed top-0 left-0 z-10 w-full h-screen lg:h-full lg:p-28" style="background: rgba(0,0,0,.25)">

        <div x-on:click.away="open = false" class="flex flex-col w-full lg:max-w-3xl h-screen lg:h-auto lg:max-h-full mx-auto bg-white lg:rounded-2xl" style="box-shadow: 0 25px 50px -12px rgba(0,0,0,.25)">

            <header class="flex items-center justify-between mx-6 border-b border-gray-200">
                <div class="flex items-center">
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
                        class="h-20 text-lg border-none focus:ring-0"
                        placeholder="Search Courses">
                </div>
                <div class="">
                    <button @click="open = false">
                        <span class="hidden sm:block text-gray-400 text-sm leading-5 py-0.5 px-1.5 border border-gray-300 rounded-md">
                            <span class="sr-only">Press </span>
                            <kbd class="font-sans">esc</kbd>
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
                @elseif ($results->count())
                    @foreach($results as $title => $collection)
                        @if($collection->count())
                            <div class="mt-6 mb-4 font-bold leading-normal text-gray-700 capitalize">{{ $title }}</div>
                            <ul class="list-none">
                                @foreach ($collection as $i => $model)
                                    <li class="relative mt-2" id="item-{{$i+1}}">
                                        <div wire:key="result-{{ $loop->index }}" wire:click="click('{{ addslashes($model::class) }}', '{{ $model->id }}', '{{ $model->route }}')"  class="flex items-center p-4 rounded-lg cursor-pointer hover:bg-indigo-500 hover:text-white" :class="{ 'bg-indigo-500 text-white': selected === {{$i}} }">
                                            <div class="mr-2">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                            </div>
                                            <div class="flex items-center h-8">
                                                @if ($model instanceof \App\Interfaces\RoutableInterface)
                                                    <p class="font-semibold overflow-ellipsis px-2">{{ $model->routeTitle }}</p>
                                                @else
                                                    <p class="font-semibold overflow-ellipsis px-2">Missing linkable interface</p>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    @endforeach
                @else
                    @if ($searches->count())
                        @if ($this->searches->where('favorite', false)->count())
                            <div class="mt-6 mb-4 font-bold leading-normal text-gray-700 capitalize">Recent</div>
                            <ul class="list-none">
                                @foreach ($this->searches->where('favorite', false) as $i => $model)
                                    <li class="relative mt-2">
                                        <div wire:key="search-{{ $loop->index }}" class="flex items-center justify-between rounded-lg cursor-pointer hover:bg-indigo-500 hover:text-white" :class="{ 'bg-indigo-500 text-white': selected === {{$i}} }">
                                            <div class="flex items-center flex-1 py-4 pl-4" wire:click="click('{{ addslashes($model->searchable::class) }}', '{{ $model->searchable->id }}', '{{ $model->searchable->route }}')">
                                                <div class="mr-2">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                                <div class="flex items-center h-8">
                                                    <p class="font-semibold overflow-ellipsis px-2">{{ $model->searchable->routeTitle }}</p>
                                                </div>
                                            </div>
                                            <div class="py-4 pr-4 cursor-pointer" wire:loading.remove wire:click="favorite({{$model->id}})" >
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                            </div>
                                            <div class="py-4 pr-4 cursor-pointer" wire:loading.remove wire:click="delete({{$model->id}})" >
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                            @if ($this->searches->where('favorite', true)->count())
                                <div class="mt-6 mb-4 font-bold leading-normal text-gray-700 capitalize">Favorites</div>
                                <ul class="list-none">
                                    @foreach ($this->searches->where('favorite', true) as $i => $model)
                                        <li class="relative mt-2">
                                            <div wire:key="search-{{ $loop->index }}" class="flex items-center justify-between rounded-lg cursor-pointer hover:bg-indigo-500 hover:text-white" :class="{ 'bg-indigo-500 text-white': selected === {{$i}} }">
                                                <div class="flex items-center flex-1 py-4 pl-4" wire:click="click('{{ addslashes($model->searchable::class) }}', '{{ $model->searchable->id }}', '{{ $model->searchable->route }}')">
                                                    <div class="mr-2">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                                    </div>
                                                    <div class="flex items-center h-8">
                                                        <p class="font-semibold overflow-ellipsis px-2">{{ $model->searchable->routeTitle }}</p>
                                                    </div>
                                                </div>
                                                <div class="py-4 pr-4 cursor-pointer" wire:loading.remove wire:click="delete({{$model->id}})" >
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                    @else
                        <div class="py-12 text-lg text-gray-500">
                            No recent searches
                        </div>
                    @endif
                @endif



                {{-- @if (count($results))
                    <div class="mt-6 mb-4 font-bold leading-normal text-gray-700">Courses</div>

                    <ul class="list-none">
                        @foreach ($results as $item)
                        <li class="relative mt-2">
                            <a href="" class="flex items-center p-4 rounded-lg bg-gray-50 hover:bg-indigo-500 hover:text-white">
                                <div class="mr-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <div class="flex items-center h-8">
                                    <p class="font-semibold overflow-ellipsis whitespace-nowrap">{{ $item->name }}</p>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <div class="py-8 text-lg text-gray-500">
                        No recent searches
                    </div>
                @endif --}}

            </section>

            <footer class="flex mt-6 justify-end py-5 mx-6 border-t border-gray-200">
                <div class="flex items-center w-6 h-6 mr-1">
                    <img src="https://www.meilisearch.com/_nuxt/img/cf59975.svg" alt="">
                </div>
                MeiliSearch
            </footer>
        </div>

    </div>

</div>
