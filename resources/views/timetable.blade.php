<x-app-layout>
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-l text-gray-800 leading-tight">--}}
{{--            Timetable for {{ $model->routeTitle }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

    @if (App\Models\Synchronization::lastRun()->diff(now())->days > 7)
        <div class="text-center text-xs py-2 bg-red-500 dark:bg-dark-red text-white">
            <p>Timetable was last synced {{ App\Models\Synchronization::lastRun()->diffForHumans() }} and may be outdated.</p>
        </div>
    @endif

    <div class="bg-coolgray dark:bg-dark-background">

        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 pb-6">

{{--            timetable-bg--}}
            <div class="pb-12 dark:bg-dark-background">

                <div class="grid md:grid-cols-4 grid-cols-3 gap-4 justify-between items-center rounded pt-12">

                    <div class="col-span-3 text-left">
                        @if($model instanceof App\Models\Lecturer)
                            <div class="mb-3 dark:text-dark-icon"><p>{{ $schedules[0]->course->campus->location }} Campus</p></div>
                            <p class="text-2xl mb-3 font-semibold dark:text-dark-text">Timetable for {{ $model->fullname }}</p>
                        @else
                            <div class="mb-3 dark:text-dark-icon"><p>{{ $model->campus->location }} Campus</p></div>
                            <p class="text-2xl mb-3 font-semibold dark:text-dark-text">{{ $model->name }}</p>
                        @endif
                        <p class="text-gray-500 mb-3 dark:text-dark-icon">Semester {{ $semester->semester() }}, Week {{ $semester->week() }}</p>
                    </div>

                    @if($model instanceof App\Models\Lecturer)
                        @livewire('weather-tile', ['location' => $schedules[0]->course->campus->location])
                    @else
                        @livewire('weather-tile', ['location' => $model->campus->location])
                    @endif

                </div>

                @livewire('schedules.upcoming', ['schedules' => $schedules])

                    <div class="flex justify-between mt-12">

                        @livewire('buttons.timetable-subscribe-button', ['timetable' => $model])

                        <a target="_blank" href="{{ $model->source() }}" class="mt-2 md:mt-0 dark:button dark:border-gray-600 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            View Timetable @LIT
                        </a>
                    </div>
            </div>


            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="relative my-12">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300 dark:border-dark-border"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-10 rounded text-lg font-medium text-gray-900 dark:text-dark-icon bg-coolgray dark:bg-dark-background">
                        <b>During the Week</b>
                    </span>
                </div>
            </div>


                <div class="">
                    @livewire('schedules.week', ['schedules' => $schedules])
                </div>

            <div class="mt-8 text-sm leading-9 tracking-tight text-center text-gray-500 dark:text-dark-text">
                Want to make this your favorite place
                <a href="https://brainstorm.io?ref=statuspage" class="text-blue-600 hover:text-blue-500 dark:text-dark-blue dark:hover:text-yellow-500">Add us to your homescreen</a>
            </div>
        </div>
    </div>

</x-app-layout>
