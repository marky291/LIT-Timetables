@component('mail::message')

# Timetable Changed!

You are subscribed to the following table and because we detected a change, we wanted to let you know!

@component('mail::panel')
    {{ $timetable }}
@endcomponent

@component('mail::button', ['url' => $url])
    View Timetable
@endcomponent

Best Regards,<br>
{{ config('app.name') }}

@endcomponent
