@component('mail::message')

# Notification Changes!

You made some changes to your timetable subscriptions.<br>
@if ($hasSubscriptions)
   Here is the timetables which you will now receive notifications for.
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

@else
<br>
Since you have removed all subscriptions you will no longer receive timetable notifications, if you change
your mind at any time, feel free to resubscribe.
@endif

Best Regards,<br>
{{ config('app.name') }}

@endcomponent
