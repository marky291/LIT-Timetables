@component('mail::message')

    # Timetable Changed!

    Just to inform you that the following timetables have changed and should be reviewed to keep up-to-date.

    @component('mail::panel')
        {{ $course }}
    @endcomponent

    @component('mail::button', ['url' => config('app.url') . '/user/profile#subscriptions'])
        Manage Your Timetable Subscriptions
    @endcomponent

    Best Regards,<br>
    {{ config('app.name') }}

@endcomponent
