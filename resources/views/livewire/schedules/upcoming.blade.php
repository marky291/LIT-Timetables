<div wire:poll.60000ms class="my-6 overflow-hidden bg-white dark:bg-dark-panel border dark:border-dark-border rounded-lg shadow">
    <div class="px-4 py-5 p-6 border-b border-gray-200 dark:border-dark-border">
        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-dark-text">
            Upcoming Schedules Today
        </h3>
        {{-- <p class="max-w-2xl mt-1 text-sm leading-5 text-gray-500">
            The Current time is {{ now()->format('H:i:s') }}
        </p> --}}
    </div>
    {{--        Schedule::latestAcademicWeek()->get()->today()--}}
    <div class="grid grid-cols-4 gap-4 px-4 py-5 rounded sm:p-6">
        @if(count($upcoming))
            @foreach ($upcoming as $schedule)
                <div class="relative col-span-4 md:col-span-2 lg:col-span-1 p-4 {{ $schedule->isCurrentTime() ? 'bg-green-100 text-green-800 font-medium' : 'bg-gray-100' }} border border-gray-700 dark:border-dark-border dark:bg-dark-background rounded">
                    @switch($schedule->type->name)
                        @case('Online Lab Lecture')
                            <span class="absolute right-4 flex items-center justify-center w-6 h-6 text-white bg-red-500 rounded-full ring-2 ring-white dark:ring-dark-panel">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.769 2.156 18 4.828 18h10.343c2.673 0 4.012-3.231 2.122-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.563-.187a1.993 1.993 0 00-.114-.035l1.063-1.063A3 3 0 009 8.172z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            @break
                        @case('Online Practical')
                        @case('Practical')
                            <span class="absolute right-4 flex items-center justify-center w-6 h-6 text-white bg-green-500 rounded-full ring-2 ring-white dark:ring-dark-panel">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                  </svg>
                            </span>
                            @break
                        @case('Online Lecture')
                            <span class="absolute right-4 flex items-center justify-center w-6 h-6 text-white bg-yellow-500 rounded-full ring-2 ring-white dark:ring-dark-panel">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                  </svg>
                            </span>
                            @break
                        @case('Online Tutorial')
                            <span class="absolute right-4 flex items-center justify-center w-6 h-6 text-white bg-pink-500 rounded-full ring-2 ring-white dark:ring-dark-panel">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                  </svg>
                            </span>
                        @break
                        @default
                            <span class="absolute right-4 flex items-center justify-center w-6 h-6 text-white bg-blue-500 rounded-full ring-2 ring-white dark:ring-dark-panel">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                  </svg>
                            </span>
                    @endswitch
                    <p class="mb-4">
                        <span class="text-lg font-bold text-gray-800 dark:text-dark-blue">{{ $schedule->starting_date->format('H:i') }}</span>
                        <span class="ml-1 text-lg font-normal text-gray-500 dark:text-dark-blue"> - {{ $schedule->ending_date->format('H:i') }}</span>
                    </p>
                    <p class="font-semibold dark:text-dark-text">{{ $schedule->module->name }}</p>

                    <p class="mb-4 text-gray-500 dark:text-dark-icon">
                    @foreach( $schedule->lecturers as $lecturer)
                        {{ $lecturer->fullname }}
                        @if (!$loop->last)
                            &
                        @endif
                    @endforeach
                    </p>

                    @if ($schedule->type->isOnline())
                        <span class="text-indigo-500 dark:text-dark-blue">{{ $schedule->type->name }}</span><br>
                    @else
                        <span class="text-indigo-500 dark:text-dark-blue">{{ $schedule->type->name }}</span> at <span class="text-indigo-500">{{ $schedule->room->door }}</span><br>
                    @endif
                </div>
            @endforeach
        @else
            <div class="col-span-4">
                <h3>There are currently no upcoming schedules</h3>
            </div>
        @endif
    </div>
</div>
