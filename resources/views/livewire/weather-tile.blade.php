<div>

    <div class="flex bg-green-500 rounded p-4">

        <div class="">
            <div class="text-3xl">{{ $location }}</div>
            <div class="text-white">Ireland</div>
        </div>

        <div class="">
            <div class="text-5xl mb-0 font-semibold">{{ round($weather['main']['temp']) }} &#176;C</div>
            <div class="text-white">Feels like {{ round($weather['main']['feels_like']) }}&#176;C</div>

            <div class="font-semibold">{{ ucfirst($weather['weather'][0]['description']) }}</div>
            <div class="text-gray-400"></div>
        </div>

        <img src="http://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}@2x.png" alt="icon">
    </div>

</div>
