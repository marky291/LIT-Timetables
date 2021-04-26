<div>

    <div class="flex justify-between items-center rounded py-14">

        <div class="flex-1">
            <div class="text-2xl">{{ $location }} Campus</div>
            <p class="text-gray-500 mb-4">Semester 1, Week 23</p>
            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <!-- Heroicon name: solid/mail -->
                <svg class="-ml-0.5 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                </svg>
                Get Notified of Changes
            </button>
        </div>

{{--        <div class="flex flex-1 justify-center">--}}
{{--            <img class="h-40 w-40" src="https://www.pngkey.com/png/full/22-225117_cute-monkey-png-clip-freeuse-download-sad-monkey.png" alt="">--}}
{{--        </div>--}}

        <div class="flex flex-1 items-center justify-end">
            <div class="flex h-16 w-16 align-center">
                <img src="http://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}.png" alt="icon">
            </div>
            <div class="">
                <div class="text-2xl mb-0 font-semibold">{{ round($weather['main']['temp']) }}&#176;C</div>
                <div class="text-gray-500">Feels like {{ round($weather['main']['feels_like']) }}&#176;C</div>
                <div class="font-semibold text-xl">{{ ucfirst($weather['weather'][0]['description']) }}</div>
            </div>
        </div>
    </div>

</div>
