<?php

namespace App\Timetable\Listeners;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\User;
use App\Timetable\Events\TimetableScheduleChanged;
use App\Timetable\Mail\CourseTimetableChanged;
use App\Timetable\Mail\LecturerScheduleChanged;
use App\Timetable\Mail\TimetableChanges;
use Closure;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Mail;

class DispatchSubscriberEmails
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(){}

    /**
     * Handle the event.
     *
     * @param TimetableScheduleChanged $event
     * @return void
     */
    public function handle(TimetableScheduleChanged $event)
    {
        $event->course->load('schedules.lecturers.subscribers')->get();

        foreach ($event->course->schedules as $schedule) {
            foreach($schedule->lecturers as $lecturer) {
                foreach($lecturer->subscribers as $subscriber) {
                    if (Cache::lock("email_{$lecturer->getKey()}_{$subscriber->getKey()}_lock",3600)->get()) {
                        Mail::to($subscriber)->send(new LecturerScheduleChanged($event->course, $lecturer));
                    }
                }
            }
        }

        foreach($event->course->subscribers as $subscriber) {
            if (Cache::lock("email_{$subscriber->getKey()}_lock",3600)->get()) {
                Mail::to($subscriber)->send(new CourseTimetableChanged($event->course));
            }
        }
    }
}
