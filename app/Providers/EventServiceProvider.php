<?php

namespace App\Providers;

use App\Timetable\Events\TimetableSubscribed;
use App\Timetable\Events\TimetableUnsubscribed;
use App\Timetable\Events\TimetableScheduleChanged;
use App\Timetable\Listeners\SendSubscribedNotification;
use App\Timetable\Listeners\SendTimetableChangedNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TimetableScheduleChanged::class => [
            SendTimetableChangedNotification::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
