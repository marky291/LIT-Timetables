<?php

namespace App\Providers;

use App\Models\Lecturer;
use App\Models\LecturerObserver;
use App\Models\Schedule;
use App\Observers\ScheduleObserver;
use App\Services\SemesterPeriodDateService;
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
        $this->app->singleton(SemesterPeriodDateService::class, fn() => new SemesterPeriodDateService(now()));
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Lecturer::observe(LecturerObserver::class);
        Schedule::observe(ScheduleObserver::class);
    }
}
