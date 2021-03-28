<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-l text-gray-800 leading-tight">
            Timetable for {{ $model->routeTitle }}
        </h2>
    </x-slot>

    <div class="bg-panel-gray">
        <div class="max-w-screen-xl px-4 py-6 mx-auto sm:px-6 lg:px-8">

            @livewire('schedules.upcoming', ['schedules' => $schedules])

            @livewire('schedules.week', ['schedules' => $schedules])

            <div class="mt-8 text-xs leading-9 tracking-tight text-center text-gray-500">
                Want to make this your favorite place
                <a href="https://brainstorm.io?ref=statuspage" class="text-blue-600 hover:text-blue-500">Add us to your homescreen</a>
            </div>
        </div>
    </div>

</x-app-layout>
