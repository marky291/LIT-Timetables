<x-app-layout>
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-l text-gray-800 leading-tight">--}}
{{--            Timetable for {{ $model->routeTitle }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

    <div style="background:#f7f8fc">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 pb-6">

            <div class="-mx-28 px-28 pb-14 timetable-bg shadow">
                <div class="grid grid-cols-4 gap-4 justify-between items-center rounded pt-14">

                    <div class="col-span-3 text-left">
                        @if($model instanceof App\Models\Lecturer)
                            <div class="mb-3"><p>{{ $schedules[0]->course->campus->location }} Campus</p></div>
                            <p class="text-2xl mb-3 font-semibold">Timetable for {{ $model->fullname }}</p>
                        @else
                            <div class="mb-3"><p>{{$model->campus->location }} Campus</p></div>
                            <p class="text-2xl mb-3 font-semibold">{{ $schedules[0]->course->name }}</p>
                        @endif
                        <p class="text-gray-500 mb-3">Semester {{ $semester->semester() }}, Week {{ $semester->week() }}</p>
                    </div>

                    @if($model instanceof App\Models\Lecturer)
                        @livewire('weather-tile', ['location' => $schedules[0]->course->campus->location])
                    @else
                        @livewire('weather-tile', ['location' => $model->campus->location])
                    @endif

                </div>

                @livewire('schedules.upcoming', ['schedules' => $schedules])

                    <button type="button" class="inline-flex mt-6 items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <!-- Heroicon name: solid/mail -->
                        <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        Subscribe to email notifications
                    </button>
            </div>


            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="relative my-12">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-10 rounded text-lg font-medium text-gray-900" style="background:#f7f8fc">
                        <b>During the Week</b>
                    </span>
                </div>
            </div>


                <div class="-mx-28 px-28">
                    @livewire('schedules.week', ['schedules' => $schedules])
                </div>

            <div class="mt-8 text-xs leading-9 tracking-tight text-center text-gray-500">
                Want to make this your favorite place
                <a href="https://brainstorm.io?ref=statuspage" class="text-blue-600 hover:text-blue-500">Add us to your homescreen</a>
            </div>
        </div>
    </div>

</x-app-layout>
