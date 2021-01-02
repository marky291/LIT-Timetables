<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Weather extends Component
{
    private $api;

    public $city;

    public function render()
    {
        $this->api = json_decode(Http::get("http://api.openweathermap.org/data/2.5/weather?q={$this->city},IE&appid=a871a1768b8aeb7330addd98f9ba1b82&units=metric"));

        return view('livewire.weather', [
            'location' => $this->city,
            'icon' => $this->getWeatherIcon(),
            'weather' => $this->getWeather(),
            'temp' => $this->getTemperature(),
        ]);
    }

    private function getTemperature()
    {
        return (int) ceil($this->api->main->temp);
    }

    private function getWeather()
    {
        return $this->api->weather[0]->main;
    }

    private function getWeatherIcon()
    {
        return "https://openweathermap.org/img/wn/{$this->api->weather[0]->icon}@2x.png";
    }
}
