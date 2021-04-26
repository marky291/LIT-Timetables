<x-app-layout>
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-l text-gray-800 leading-tight">--}}
{{--            Timetable for {{ $model->routeTitle }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

    <div class="bg-white">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 pb-6">

            <div class="-mx-28 px-28 timetable-bg pb-14 shadow">
                @livewire('weather-tile', ['location' => $model->campus->location])
                @livewire('schedules.upcoming', ['schedules' => $schedules])
            </div>

            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="relative my-12">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-3 bg-white rounded text-lg font-medium text-gray-900">
                        <b>During the Week</b>
                    </span>
                </div>
            </div>


                <div class="-mx-28 px-28 py-4" style="background:#f7f8fc"">
                    @livewire('schedules.week', ['schedules' => $schedules])
                </div>

            <div class="mt-8 text-xs leading-9 tracking-tight text-center text-gray-500">
                Want to make this your favorite place
                <a href="https://brainstorm.io?ref=statuspage" class="text-blue-600 hover:text-blue-500">Add us to your homescreen</a>
            </div>
        </div>
    </div>

</x-app-layout>
