@component('mail::message')

# Timetable Changed!

Just to inform you that the following timetable has changed and should be reviewed to stay up-to-date.

@component('mail::panel')
{{ $timetableName }}
@endcomponent

@component('mail::button', ['url' => config('app.url') . '/user/profile#subscriptions'])
Manage Your Timetable Subscriptions
@endcomponent

Best Regards,<br>
{{ config('app.name') }}

@endcomponent
