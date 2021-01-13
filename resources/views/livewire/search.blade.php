<div x-data="{ open: false, selected: 0, total: 5 }"
x-on:keydown.arrow-down="selected >= total ? selected = total : selected = selected + 1; console.log(selected);"
x-on:keydown.arrow-up="selected <= 0 ? selected = 0 : selected = selected - 1; console.log(selected);"
x-on:keydown.escape="open = false;"
x-on:search.window="open = true; $nextTick(() => $refs.searchbar.focus())"
>

    <div x-cloak x-show="open" id="search-container" class="fixed top-0 left-0 z-10 w-full h-screen p-28" style="background: rgba(0,0,0,.25)">

        <div x-on:click.away="open = false" class="flex flex-col w-full max-w-3xl min-h-0 mx-auto bg-white rounded-2xl" style="box-shadow: 0 25px 50px -12px rgba(0,0,0,.25)">

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

            <section class="px-6 overflow-auto" style="max-height: 50vh">

                @if ($results->count())
                    @foreach($results as $title => $collection)
                        @if($collection->count())
                            <div class="mt-6 mb-4 font-bold leading-normal text-gray-700 capitalize">{{ $title }}</div>
                            <ul class="list-none">
                                @foreach ($collection as $i => $model)
                                    <li class="relative mt-2" id="item-{{$i+1}}">
                                        <div wire:click="clicked{{class_basename($model)}}({{ $model->id }})"  class="flex items-center p-4 rounded-lg cursor-pointer hover:bg-indigo-500 hover:text-white" :class="{ 'bg-indigo-500 text-white': selected === {{$i}} }">
                                            <div class="mr-2">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                            </div>
                                            <div class="flex items-center h-8">
                                                @if ($model instanceof \App\Interfaces\RoutableInterface)
                                                    <p class="font-semibold overflow-ellipsis whitespace-nowrap">{{ $model->routeTitle }}</p>
                                                @else
                                                    <p class="font-semibold overflow-ellipsis whitespace-nowrap">Missing linkable interface</p>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    @endforeach
                @else
                    @if ($recent->count())
                        <div class="mt-6 mb-4 font-bold leading-normal text-gray-700 capitalize">Recent</div>
                        <ul class="list-none">
                            @foreach ($recent as $i => $model)
                                <li class="relative mt-2" id="item-{{$i+1}}">
                                    <div wire:click="clicked{{class_basename($model->searchable)}}({{ $model->searchable->id }})"  class="flex items-center justify-between p-4 rounded-lg cursor-pointer hover:bg-indigo-500 hover:text-white" :class="{ 'bg-indigo-500 text-white': selected === {{$i}} }">
                                        <div class="flex items-center">
                                            <div class="mr-2">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                            </div>
                                            <div class="flex items-center h-8">
                                                <p class="font-semibold overflow-ellipsis whitespace-nowrap">{{ $model->searchable->routeTitle }}</p>
                                            </div>
                                        </div>
                                        <div class="">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
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

            <footer class="flex justify-end py-5 mx-6 border-t border-gray-200">
                <div class="flex items-center w-6 h-6 mr-1">
                    <img src="https://www.meilisearch.com/_nuxt/img/cf59975.svg" alt="">
                </div>
                MeiliSearch
            </footer>
        </div>

    </div>

</div>
