<div>
    <div class="flex items-center justify-left p-4 rounded">
        <div class="flex h-16 w-16 mr-3 align-center bg-white rounded-lg border border-gray-200 shadow-sm">
            <img src="http://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}.png" alt="icon">
        </div>
        <div class="">
            <div class="text-2xl mb-0 font-semibold">{{ round($weather['main']['temp']) }}&#176;C</div>
            {{--                <div class="text-gray-500">Feels like {{ round($weather['main']['feels_like']) }}&#176;C</div>--}}
            <div class="text-xl text-gray-500">{{ ucfirst($weather['weather'][0]['description']) }}</div>
        </div>
    </div>
</div>
