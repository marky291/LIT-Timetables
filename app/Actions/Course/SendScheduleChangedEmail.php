<?php

namespace App\Actions\Course;

use App\Events\ScheduleChanged;
use App\Mail\CourseTimetableChangedMail;
use App\Models\Course;
use App\Mail\LecturerScheduleChangedMail;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class SendScheduleChangedEmail
{
    use AsAction;

    public function handle(Course $course)
    {
        foreach($course->subscribers as $subscriber) {
            Mail::to($subscriber)->send(new CourseTimetableChangedMail($course));
        }

        foreach ($course->schedules as $schedule) {
            foreach($schedule->lecturers as $lecturer) {
                foreach($lecturer->subscribers as $subscriber) {
                    Mail::to($subscriber)->send(new LecturerScheduleChangedMail($course, $lecturer));
                }
            }
        }
    }

    public function asListener(ScheduleChanged $event): void
    {
        $this->handle($event->course);
    }
}
