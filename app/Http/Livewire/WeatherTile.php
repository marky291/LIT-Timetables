<?php

namespace App\Http\Livewire;

use Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class WeatherTile extends Component
{
    public string $location;

    public bool $readyToLoad = false;

    public function loadWeather()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        if ($this->readyToLoad)
        {
            $api_key = Config::get('weather.api_key');
            $location = Config::get("campus.".strtolower($this->location).".city");
            $weather = Cache::remember($location, now()->addMinutes(5), function() use ($location, $api_key) {
                return Http::get("api.openweathermap.org/data/2.5/weather?q={$location}, IE&appid={$api_key}&units=metric");
            });

            return view('livewire.weather-tile', ['weather' => $weather]);
        }

        return view('livewire.weather-tile', ['weather' => null]);
    }
}
