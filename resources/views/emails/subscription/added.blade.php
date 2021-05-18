@component('mail::message')

# You're being Notified!

You requested timetable notifications for a {{ strtolower($timetableType) }},
we will send updates straight to your inbox when we find something has changed.
But just so we are clear, here is everything you have subscribed to!

@if($lecturers->count())
@component('mail::panel')
Lecturers<br>
@foreach($lecturers as $subscription)
@switch(class_basename($subscription->notifiable::class))
@case("Lecturer")
<sub>- {{ $subscription->notifiable->fullname }}</sub><br>
@endswitch
@endforeach
@endcomponent
@endif

@if ($courses->count())
@component('mail::panel')
Courses<br>
@foreach($courses as $subscription)
@switch(class_basename($subscription->notifiable::class))
@case("Course")
<sub>- {{ $subscription->notifiable->name }}</sub><br>
@endswitch
@endforeach
@endcomponent
@endif

@component('mail::button', ['url' => config('app.url') . '/user/profile#subscriptions'])
Manage Your Timetable Subscriptions
@endcomponent

Best Regards,<br>
{{ config('app.name') }}

@endcomponent
