<?php

namespace App\Providers;

use App\Models\Lecturer;
use App\Observers\LecturerObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Lecturer::observe(LecturerObserver::class);
    }
}
