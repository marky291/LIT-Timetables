<?php

namespace App\Http\Livewire;

use Config;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class WeatherTile extends Component
{
    public $campus;

    public $readyToLoad = false;

    public function loadWeather()
    {
        $this->readyToLoad = true;
    }

    public function getApikeyProperty()
    {
        return Config::get('weather.api_key');
    }

    public function getLocationProperty()
    {
        Config::get("campus.".strtolower($this->campus).".city");
    }

    public function getWeatherProperty()
    {
        return Http::get("api.openweathermap.org/data/2.5/weather?q={$this->location}, IE&appid={$this->apikey}&units=metric");
    }

    public function render()
    {
        return view('livewire.weather-tile');
    }
}
