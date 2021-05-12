<?php

namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class WeatherTileTest extends TestCase
{
    use RefreshDatabase;

    public function test_weather_is_displayed()
    {
        Http::fake([
            '*' => Http::response([
                'main' => [
                    'temp' => 12
                ],
                'weather' => [
                    [
                        'icon' => '04d',
                        'description' => 'Broken clouds',
                    ]
                ]
            ], 200, ['Headers']),
        ]);

        Livewire::test('weather-tile')
            ->set('location', 'Moylish')
            ->set('readyToLoad', true)
            ->assertSeeHtml('12&#176;C with Broken clouds');
    }

    public function test_weather_displays_error_when_failing_response()
    {
        Http::fake([
            '*' => Http::response(null, 404, ['Headers']),
        ]);

        Livewire::test('weather-tile')
            ->set('location', 'Moylish')
            ->set('readyToLoad', true)
            ->assertSeeHtml("No weather <br> information available");
    }

    public function test_weather_loading_state()
    {
        Livewire::test('weather-tile')
            ->assertSeeHtml("Loading weather...");
    }

}
