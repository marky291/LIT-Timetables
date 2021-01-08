<?php

namespace App\Timetable;

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
        $this->app->singleton(Semester::class, function ($app) {
            return new Semester(now());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
