<?php

namespace App\Http\Livewire;

use Config;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class WeatherTile extends Component
{
    public string $location;

    public bool $error = false;

    public bool $readyToLoad = false;

    public function loadWeather()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        if ($this->readyToLoad)
        {
            try {
                $api_key = Config::get('weather.api_key');
                $location = Config::get("campus.".strtolower($this->location).".city");
                $weather = Cache::remember($location, now()->addMinutes(5), function() use ($location, $api_key) {
                    return Http::get("api.openweathermap.org/data/2.5/weather?q={$location}, IE&appid={$api_key}&units=metric");
                });
                return view('livewire.weather-tile', ['weather' => $weather]);
            } catch (Exception $e) {
                $this->error = true;
                Log::error($e);
            }
        }

        return view('livewire.weather-tile', ['weather' => null]);
    }
}
