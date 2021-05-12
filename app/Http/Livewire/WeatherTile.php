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
    public $location;

    public $readyToLoad = false;

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
            $response = \Cache::remember("weather.$location", now()->addMinute(), function() use ($location, $api_key) {
                return Http::get("api.openweathermap.org/data/2.5/weather?q={$location}, IE&appid={$api_key}&units=metric");
            });

            if ($response->getStatusCode() == 200) {
                return view('livewire.weather-tile', ['weather' => $response]);
            }
        }

        return view('livewire.weather-tile', ['weather' => null]);
    }
}
