<div>

    <div class="flex justify-between rounded p-4">

        <div class="">
            <div class="text-2xl">{{ $location }} Campus</div>
            <p class="text-gray-500">Semester 1</p>
            <p class="font-semibold">Week 23</p>
        </div>


        <div class="flex">
            <div class="flex h-16 w-16 align-center">
                <img src="http://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}.png" alt="icon">
            </div>
            <div class="">
                <div class="text-2xl mb-0 font-semibold">{{ round($weather['main']['temp']) }}&#176;C</div>
                <div class="text-gray-500">Feels like {{ round($weather['main']['feels_like']) }}&#176;C</div>

                <div class="font-semibold">{{ ucfirst($weather['weather'][0]['description']) }}</div>
            </div
        </div>
    </div>

</div>
