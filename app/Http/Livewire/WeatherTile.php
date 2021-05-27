<?php

namespace App\Http\Livewire;

use Config;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

/**
 * @property mixed campusLocation
 * @property mixed weather
 * @property mixed apikey
 */
class WeatherTile extends Component
{
    public string $campus = '';

    public bool $readyToLoad = false;

    public function loadWeather()
    {
        $this->readyToLoad = true;
    }

    public function getApikeyProperty()
    {
        return Config::get('weather.api_key');
    }

    public function getCampusLocationProperty()
    {
        return Config::get("campus.".strtolower($this->campus).".city");
    }

    public function getWeatherProperty()
    {
        return \Cache::remember("weather::$this->campusLocation", now()->addMinutes(5), function() {
            return Http::get("api.openweathermap.org/data/2.5/weather?q={$this->campusLocation},IE&appid={$this->apikey}&units=metric");
        });
    }

    public function render()
    {
        return view('livewire.weather-tile');
    }
}
