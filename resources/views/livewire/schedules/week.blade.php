<div wire:init="loadWeek">

    <div class="relative my-12">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-300 dark:border-dark-border"></div>
        </div>
        <div class="relative flex justify-around">
            <span class="px-10 text-lg font-medium text-gray-900 rounded dark:text-dark-icon bg-coolgray dark:bg-dark-background">
               @if ($this->readyToLoad == false)
               <b>Viewing Academic Week {{ $current_week }}</b>
               @else
                <b>Viewing Academic Week {{ $this->selectedWeek }}</b>
               @endif
            </span>
        </div>
    </div>

    @if ($this->readyToLoad == false)
    <div class="p-4 flex items-center justify-center bg-white dark:text-dark-icon dark:bg-dark-panel border dark:border-dark-border rounded-lg shadow px-10 py-6">
        <svg class="w-7 h-7 animate-spin " xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
        <h3 class="ml-4 text-xl text-center py-6">Loading timetable</h3>
    </div>
    @else
        @if (config('services.lit.relay.weeks_to_fetch.enabled'))
        <div class="mb-8">
            <div class="flex justify-between">
                <div class="">
                    @if ($this->HasPreviousWeek)
                        <button wire:click="decrementWeek()" wire:loading.attr="disabled" class="inline-flex items-center px-3 py-2 mt-2 text-sm font-medium leading-4 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm md:mt-0 dark:button dark:border-gray-600 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Previous Week</button>
                    @endif
                </div>
                <div class="">
                    @if ($this->HasNextWeek)
                        <button wire:click="incrementWeek()" wire:loading.attr="disabled" class="inline-flex items-center px-3 py-2 mt-2 text-sm font-medium leading-4 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm md:mt-0 dark:button dark:border-gray-600 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Next Week</button>
                    @endif
                </div>
            </div>
        </div>
        @endif
        <div wire:loading class="w-full">
            <div class="p-4 flex items-center justify-center bg-white dark:text-dark-icon dark:bg-dark-panel border dark:border-dark-border rounded-lg shadow px-10 py-6">
                <svg class="w-7 h-7 animate-spin " xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <h3 class="ml-4 text-xl text-center py-6">Loading timetable</h3>
            </div>
        </div>

        <div wire:loading.remove>
            @if (!$this->days->count())
                <div class="p-4 py-8 bg-white dark:bg-dark-panel border dark:border-dark-border rounded-lg shadow px-10 py-6 text-center dark:text-dark-icon">
                    @if ($this->isViewingThisWeek)
                        <h3 class="text-xl">You have no classes this week</h3>
                    @else
                        <h3 class="text-xl">Nothing scheduled for academic week {{ $this->selected_week }}</h3>
                    @endif
                    @if ($this->hasNextWeek == false)
                        <h3 class="text-md mt-4 text-gray-400">Take some time off and for yourself!</h3>
                    @else
                        <h3 class="text-md mt-4 text-gray-400">Hopefully you spent some time to look after yourself!</h3>
                    @endif

                </div>
            @else
                @foreach ($this->days as $key => $day)
                    <div
                        class="p-4 bg-white dark:bg-dark-panel border dark:border-dark-border rounded-lg shadow px-10 py-6 {{ $loop->first ? '' : 'mt-7' }}">

                        <div class="prose mb-3">
                            <h3 class="text-xl font-medium leading-6 text-gray-900 dark:text-dark-text">
                                {{ $this->days[$key][0]->starting_date->isoformat('dddd, Do MMMM') }}</h3>
                        </div>

                        <div class="">
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    @foreach ($day as $key => $schedule)
                                        <!-- This example requires Tailwind CSS v2.0+ -->
                                        <li>
                                            <div class="relative {{ $loop->last ? 'mb-8' : '' }}">
                                                {{-- <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span> --}}
                                                <div class="relative flex space-x-3">
                                                    <div class="flex items-center">
                                                        @switch($schedule->type->name)
                                                            @case('Online Lab Lecture')
                                                                <span
                                                                    class="flex items-center justify-center w-8 h-8 text-white bg-red-500 rounded-full ring-8 ring-white dark:ring-dark-panel">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="w-5 h-5 text-white" viewBox="0 0 20 20"
                                                                        fill="currentColor">
                                                                        <path fill-rule="evenodd"
                                                                            d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.769 2.156 18 4.828 18h10.343c2.673 0 4.012-3.231 2.122-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.563-.187a1.993 1.993 0 00-.114-.035l1.063-1.063A3 3 0 009 8.172z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </span>
                                                            @break

                                                            @case('Online Practical')
                                                            @case('Practical')
                                                                <span
                                                                    class="flex items-center justify-center w-8 h-8 text-white bg-green-500 rounded-full ring-8 ring-white dark:ring-dark-panel">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                                    </svg>
                                                                </span>
                                                            @break

                                                            @case('Online Lecture')
                                                                <span
                                                                    class="flex items-center justify-center w-8 h-8 text-white bg-yellow-500 rounded-full ring-8 ring-white dark:ring-dark-panel">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                                    </svg>
                                                                </span>
                                                            @break

                                                            @case('Online Tutorial')
                                                                <span
                                                                    class="flex items-center justify-center w-8 h-8 text-white bg-pink-500 rounded-full ring-8 ring-white dark:ring-dark-panel">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                                                        <path
                                                                            d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                                                    </svg>
                                                                </span>
                                                            @break

                                                            @default
                                                                <span
                                                                    class="flex items-center justify-center w-8 h-8 text-white bg-blue-500 rounded-full ring-8 ring-white dark:ring-dark-panel">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                                    </svg>
                                                                </span>
                                                        @endswitch
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                        <div>
                                                            <section class="">
                                                                <div class="p-3">
                                                                    <div class="prose">
                                                                        <p class="my-0 text-gray-800">
                                                                            <legend
                                                                                class="font-semibold dark:text-dark-text">
                                                                                {{ $schedule->module->name }}</legend>
                                                                            @if ($schedule->type->isOnline())
                                                                                <span
                                                                                    class="text-indigo-500 dark:text-dark-blue">{{ $schedule->type->name }}</span><br>
                                                                            @else
                                                                                <span
                                                                                    class="text-indigo-500 dark:text-dark-blue">{{ $schedule->type->name }}</span>
                                                                                <span class="dark:text-dark-icon">at</span>
                                                                                <span
                                                                                    class="text-indigo-500 dark:text-dark-blue">{{ $schedule->room->door }}</span><br>
                                                                            @endif
                                                                            <time
                                                                                class="text-indigo-500 dark:text-dark-blue">{{ Str::lower($schedule->starting_date->format('g:iA')) }}
                                                                                -
                                                                                {{ Str::lower($schedule->ending_date->format('g:iA')) }}</time><br>
                                                                            <span
                                                                                class="mt-0 font-medium text-gray-700 dark:text-dark-text">
                                                                                @foreach ($schedule->lecturers as $lecturer)
                                                                                    {{ $lecturer->fullname }}
                                                                                    @if (!$loop->last)
                                                                                        &
                                                                                    @endif
                                                                                @endforeach
                                                                            </span>
                                                                        </p>
                                                                        {{-- <p class="mt-0 font-medium text-gray-700">{{ $schedule->course->name }}</p> --}}
                                                                    </div>
                                                                </div>
                                                            </section>
                                                        </div>
                                                        <div
                                                            class="text-sm text-right text-gray-500 whitespace-nowrap flex items-center dark:text-dark-icon">
                                                            <time
                                                                datetime="2020-09-20">{{ $schedule->ending_date->diffInhours($schedule->starting_date) }}
                                                                {{ \Illuminate\Support\Str::of('Hour')->plural($schedule->ending_date->diffInhours($schedule->starting_date)) }}</time>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>


                        {{-- <div class=""> --}}
                        {{-- @foreach ($day as $key => $schedule) --}}
                        {{-- <section class=""> --}}
                        {{-- <div class="p-6 {{ $loop->last ? '' : 'border-b'  }}"> --}}
                        {{-- <div class="prose"> --}}
                        {{-- <p class="my-0 text-gray-800"> --}}
                        {{-- <legend class="font-semibold">{{ $schedule->module->name }}</legend> --}}
                        {{-- <span class="text-indigo-500">{{ $schedule->type->name }}</span> at <span class="text-indigo-500">{{ $schedule->room->door }}</span><br> --}}
                        {{-- <time class="text-indigo-500">{{ Str::lower($schedule->starting_date->format('H:sA')) }} - {{ Str::lower($schedule->ending_date->format('H:sA')) }}</time><br> --}}
                        {{-- @foreach ($schedule->lecturers as $lecturer) --}}
                        {{-- <span class="mt-0 font-medium text-gray-700">{{ $lecturer->fullname }}</span> --}}
                        {{-- @endforeach --}}
                        {{-- </p> --}}
                        {{--  --}}{{-- <p class="mt-0 font-medium text-gray-700">{{ $schedule->course->name }}</p> --}}
                        {{-- </div> --}}
                        {{-- </div> --}}
                        {{-- </section> --}}
                        {{-- @endforeach --}}
                        {{-- </div> --}}

                    </div>
                @endforeach
            @endif
        </div>
    @endif
</div>
