<?php

namespace App\Timetable\Listeners;

use App\Models\Lecturer;
use App\Models\User;
use App\Timetable\Events\TimetableScheduleChanged;
use App\Timetable\Mail\TimetableChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Mail;

class SendTimetableChangedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(public Collection $collection){}

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
                    $this->sendMailTo($subscriber);
                }
            }
        }

        foreach($event->course->subscribers as $subscriber) {
            $this->sendMailTo($subscriber);
        }
    }

    private function sendMailTo(User $subscriber)
    {
        Cache::remember("Email::{$subscriber->email}", now()->addMinutes(30), function() use ($subscriber) {
            Mail::to($subscriber)->later(now()->addMinutes(10), new TimetableChanged());
        });
    }
}
