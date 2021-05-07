<div wire:init="loadWeather">
    @if ($weather != null)
        <div class="flex items-center justify-left p-4 rounded">
            <div class="flex h-16 w-16 mr-3 align-center bg-gray-200 dark:bg-dark-background rounded-full ring-2 ring-white dark:ring-dark-background">
                <img src="http://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}.png" alt="icon">
            </div>
            <div class="">
                <div class="text-2xl mb-0 font-semibold dark:text-dark-text">{{ round($weather['main']['temp']) }}&#176;C</div>
{{--            <div class="text-gray-500">Feels like {{ round($weather['main']['feels_like']) }}&#176;C</div>--}}
                <div class="text-xl text-gray-500 dark:text-dark-icon">{{ ucfirst($weather['weather'][0]['description']) }}</div>
            </div>
        </div>
    @endif
</div>
