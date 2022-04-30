<div wire:init="loadWeather" x-show="error" class="col-span-3 md:col-span-1">

    @if ($campus == null)
        <div class="md:text-lg mb-0 text-gray-500 font-semibold dark:text-dark-icon">
            <h2>Unknown Campus</h2>
        </div>
    @else
        @if ($this->readyToLoad == false)
            <div wire:loading class="md:text-lg mb-0 text-gray-500 font-semibold dark:text-dark-icon">
                <div class="flex">
                    <svg class="w-7 h-7 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <h2 class="ml-2">Loading weather...</h2>
                </div>
            </div>
        @else
            <div wire:loading.remove class="">
                @if ($this->weather->getStatusCode() == 200)
                    <div class="hidden md:flex items-center justify-left md:p-4 rounded">
                        <div class="flex md:h-16 md:w-16 mr-3 align-center bg-gray-200 dark:bg-dark-background rounded-full ring-2 ring-white dark:ring-dark-background">
                            <img src="https://openweathermap.org/img/wn/{{ $this->weather['weather'][0]['icon'] }}.png" alt="icon">
                        </div>
                        <div class="">
                            <div class="md:text-2xl mb-0 font-semibold dark:text-dark-text">{{ round($this->weather['main']['temp']) }}&#176;C</div>
                            {{--            <div class="text-gray-500">Feels like {{ round($weather['main']['feels_like']) }}&#176;C</div>--}}
                            <div class="md:text-xl text-gray-500 dark:text-dark-icon">{{ ucfirst($this->weather['weather'][0]['description']) }}</div>
                        </div>
                    </div>

                    <div class="md:hidden flex items-center">
                        <div class="flex md:h-16 md:w-16 mr-3 align-center bg-gray-200 dark:bg-dark-background rounded-full ring-2 ring-white dark:ring-dark-background">
                            <img src="https://openweathermap.org/img/wn/{{ $this->weather['weather'][0]['icon'] }}.png" alt="icon">
                        </div>
                        <div class="md:text-2xl mb-0 font-semibold dark:text-dark-text">{{ round($this->weather['main']['temp']) }}&#176;C with {{ ucfirst($this->weather['weather'][0]['description']) }}</div>
                    </div>
                @else
                    <div class="md:text-lg mb-0 text-gray-300 font-semibold dark:text-gray-400">
                        <h2>No weather <br> information available</h2>
                    </div>
                @endif
            </div>
        @endif
    @endif
</div>
