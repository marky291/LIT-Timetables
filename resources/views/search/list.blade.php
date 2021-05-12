<div class="mt-6 mb-4 font-bold leading-normal text-gray-700 dark:text-dark-text capitalize">{{ $title }}</div>
<ul class="list-none">
    @foreach ($collection as $i => $model)
        <li wire:key="{{ strtolower($title) }}-{{ $loop->index }}" class="relative mt-2">
            <div class="search-result-item" :class="{ 'search-result-item-selected': selected === {{$i}} }">

                @php
                    if ($model instanceof \App\Interfaces\SearchableInterface) {
                        $identifier = $model->routeTitle;
                        $class = addslashes($model::class);
                        $id    = $model->id;
                        $route = $model->route;
                    } else {
                        $identifier = $model->searchable->routeTitle;
                        $class = addslashes($model->searchable::class);
                        $id    = $model->searchable->id;
                        $route = $model->searchable->route;
                    }
                @endphp

                <div class="flex-1 py-4" wire:click="click('{{ $class }}', '{{ $id }}', '{{ $route }}')">
                    <div class="flex items-center flex-1">
                        <div class="mr-2">
                            @if($title == 'Recent')
                                @include('search.icon', ['icon' => 'recent'])
                            @elseif($title == 'Favorites')
                                @include('search.icon', ['icon' => 'favorite'])
                            @elseif($model instanceof \App\Models\Lecturer)
                                @include('search.icon', ['icon' => 'lecturer'])
                            @elseif($model instanceof \App\Models\Course)
                                @include('search.icon', ['icon' => $model->iconCategory])
                            @endif
                        </div>
                        <div class="flex items-center h-8">
                            <p class="font-semibold overflow-ellipsis px-2">{{ $identifier }}</p>
                        </div>
                    </div>
                </div>
                @if (isset($favorable))
                    <div class="search-result-icon" wire:loading.remove wire:click="favorite('{{ $class }}', '{{ $id }}')" >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                @endif
                @if (isset($removable) && !$model instanceof \App\Interfaces\SearchableInterface)
                    <div class="search-result-icon" wire:loading.remove wire:click="delete({{$model->id}})" >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                @endif
            </div>
        </li>
    @endforeach
</ul>
