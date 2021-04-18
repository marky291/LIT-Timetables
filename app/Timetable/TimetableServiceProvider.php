<?php

namespace App\Timetable;

use App\Timetable\View\ViewScheduleLayout;
use Blade;
use Illuminate\Support\ServiceProvider;

class TimetableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SemesterPeriods::class, function ($app) {
            return new SemesterPeriods(now());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Blade::component('schedule', ViewScheduleLayout::class);
    }
}
