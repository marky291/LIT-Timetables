<?php

namespace App\Timetable\Mail;

use App\Models\Course;
use App\Models\Lecturer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LecturerScheduleChanged extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public Course $course, public Lecturer $lecturer){}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.timetable.changed', ['course' => $this->course->name]);
    }
}
