@extends('layouts.app')

@section('content')

    <div class="max-w-6xl px-4 mx-auto py-14 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold leading-9 tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
                {{ $lecturer->name }}
            </h2>
        </div>

        @livewire('schedules.today', ['schedules' => $schedules])

        @livewire('schedules.week', ['schedules' => $schedules])

        <div class="mt-8 text-xs leading-9 tracking-tight text-center text-gray-500">
            Want to make this your favorite place <a
                href="https://brainstorm.io?ref=statuspage" class="text-blue-600 hover:text-blue-500">Add us to your homescreen</a>
        </div>
    </div>
@endsection
