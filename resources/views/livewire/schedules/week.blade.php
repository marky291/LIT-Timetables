<div class="mt-10">
    @foreach ($days as $key => $day)

        <div class="mt-7">

            <div class="prose">
                <h3 class="text-xl font-medium leading-6 text-gray-900">{{ $days[$key][0]->starting_date->format('l') }}</h3>
            </div>

            <div class="mt-3 bg-white border-l-2 border-indigo-500 rounded shadow">
                @foreach($day as $key => $schedule)
                    <section class="">
                        <div class="p-6 {{ $loop->last ? '' : 'border-b'  }}">
                            <div class="prose">
                                <legend class="font-semibold">{{ $schedule->module->name }}</legend>
                                <p class="my-0 text-gray-800"><span class="text-indigo-500">{{ $schedule->type->name }}</span> at <span class="text-indigo-500">{{ $schedule->room->door }}</span></p>
                                <time class="text-indigo-500">{{ Str::lower($schedule->starting_date->format('H:sA')) }} - {{ Str::lower($schedule->ending_date->format('H:sA')) }}</time>
                                <p class="mt-0 font-medium text-gray-700">{{ $schedule->lecturer->fullname }}</p>
                                {{--                                <p class="mt-0 font-medium text-gray-700">{{ $schedule->course->name }}</p>--}}
                            </div>
                        </div>
                    </section>
                @endforeach
            </div>

        </div>

    @endforeach
</div>
