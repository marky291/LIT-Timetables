<?php

namespace App\Http\Livewire;

use Config;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

/**
 * @property mixed campusLocation
 * @property mixed weather
 * @property mixed apikey
 */
class WeatherTile extends Component
{
    public $campus;

    public bool $readyToLoad = false;

    public function loadWeather(): void
    {
        $this->readyToLoad = true;
    }

    public function getApikeyProperty(): string
    {
        return Config::get('services.openweather.key');
    }

    public function getWeatherProperty(): Response
    {
        return Http::get("api.openweathermap.org/data/2.5/weather?q={$this->campus->city},IE&appid={$this->apikey}&units=metric");
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.weather-tile');
    }
}
