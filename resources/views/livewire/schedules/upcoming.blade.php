<div wire:poll.60000ms class="my-6 overflow-hidden bg-white rounded-lg shadow">
    <div class="px-4 py-5 p-6 border-b border-gray-200">
        <h3 class="text-lg font-medium leading-6 text-gray-900">
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
                <div class="col-span-4 md:col-span-2 lg:col-span-1 p-4 {{ $schedule->isCurrentTime() ? 'bg-green-100 text-green-800 font-medium' : 'bg-gray-100' }} border-2 border-gray-100 rounded">
                    <p class="mb-4"><span class="text-lg font-bold text-gray-800">{{ $schedule->starting_date->format('H:i') }}</span> <span class="ml-1 text-lg font-normal text-gray-500"> - {{ $schedule->ending_date->format('H:i') }}</span></p>
                    <p class="mb-4">{{ $schedule->room->door }}</p>
                    <p class="mb-4">{{ $schedule->module->name }}</p>
                    @foreach( $schedule->lecturers as $lecturer)
                        <p class="mb-4">With {{ $lecturer->fullname }}</p>
                    @endforeach
                    <p>{{ $schedule->type->name }}</p>
                </div>
            @endforeach
        @else
            <div class="col-span-4">
                <h3>There are currently no upcoming schedules</h3>
            </div>
        @endif
    </div>
</div>
