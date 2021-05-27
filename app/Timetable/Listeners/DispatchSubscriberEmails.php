<?php

namespace App\Timetable\Listeners;

use App\Timetable\Events\TimetableScheduleChanged;
use App\Timetable\Mail\CourseTimetableChanged;
use App\Timetable\Mail\LecturerScheduleChanged;
use Illuminate\Queue\SerializesModels;
use Mail;

class DispatchSubscriberEmails
{
    use SerializesModels;

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
        foreach ($event->course->schedules as $schedule) {
            foreach($schedule->lecturers as $lecturer) {
                foreach($lecturer->subscribers as $subscriber) {
                    Mail::to($subscriber)->send(new LecturerScheduleChanged($event->course, $lecturer));
                }
            }
        }

        foreach($event->course->subscribers as $subscriber) {
            Mail::to($subscriber)->send(new CourseTimetableChanged($event->course));
        }
    }
}
