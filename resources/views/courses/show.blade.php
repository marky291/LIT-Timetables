@extends('layouts.app')

@section('content')

    <!-- This example requires Tailwind CSS v2.0+ -->
    <nav class="flex bg-white border-b border-gray-200" aria-label="Breadcrumb">
        <ol class="flex w-full max-w-screen-xl px-4 mx-auto space-x-4 sm:px-6 lg:px-8">
            <li class="flex">
                <div class="flex items-center">
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <!-- Heroicon name: home -->
                        <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <span class="sr-only">Home</span>
                    </a>
                </div>
            </li>
            <li class="flex">
                <div class="flex items-center">
                    <svg class="flex-shrink-0 w-6 h-full text-gray-200" viewBox="0 0 24 44" preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
                    </svg>
                    <a href="#" aria-current="page" class="ml-4 text-sm font-medium text-gray-600 hover:text-gray-700">{{ $course->name }}</a>
                </div>
            </li>
        </ol>
    </nav>


    <div class="bg-panel-gray">
        <div class="max-w-screen-xl px-4 py-6 mx-auto sm:px-6 lg:px-8">

{{--            @livewire('schedules.today', ['schedules' => $schedules])--}}

            @livewire('schedules.upcoming', ['schedules' => $schedules])

            @livewire('schedules.week', ['schedules' => $schedules])

            <div class="mt-8 text-xs leading-9 tracking-tight text-center text-gray-500">
                Want to make this your favorite place
                <a href="https://brainstorm.io?ref=statuspage" class="text-blue-600 hover:text-blue-500">Add us to your homescreen</a>
            </div>
        </div>
    </div>
@endsection
