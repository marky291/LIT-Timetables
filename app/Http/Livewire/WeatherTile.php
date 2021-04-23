<?php

namespace App\Http\Livewire;

use Config;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class WeatherTile extends Component
{

    public string $location;

    public function render()
    {
        $api_key = Config::get('weather.api_key');

        $location = Config::get("campus.".strtolower($this->location).".city");

        $response = Http::get("api.openweathermap.org/data/2.5/weather?q={$location}, IE&appid={$api_key}&units=metric");

        return view('livewire.weather-tile', ['weather' => $response->json()]);
    }
}
