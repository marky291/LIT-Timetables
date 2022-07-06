<?php

namespace App\Mail;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Notifiable;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UnsubscribedFromTimetableMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param Model $timetable
     * @return void
     */
    public function __construct(public int $user_id, public Model $timetable)
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::whereId($this->user_id)->first();

        $timetableName = match ($this->timetable::class) {
            Lecturer::class => $this->timetable->fullname,
            Course::class => $this->timetable->name,
        };

        return $this->markdown('emails.subscription.removed', [
            'timetableType' => class_basename($this->timetable),
            'timetableName' => $timetableName,
            'hasSubscriptions' => Notifiable::hasSubscriptions($user),
            'courses' => Notifiable::userCourses($user)->get(),
            'lecturers' => Notifiable::userLecturers($user)->get(),
        ]);
    }
}
