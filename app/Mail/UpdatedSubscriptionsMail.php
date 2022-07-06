<?php

namespace App\Mail;

use App\Models\Notifiable;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdatedSubscriptionsMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public int $user_id)
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

        return $this->markdown('emails.subscription.updated', [
            'hasSubscriptions' => Notifiable::hasSubscriptions($user),
            'courses' => Notifiable::userCourses($user)->get(),
            'lecturers' => Notifiable::userLecturers($user)->get(),
        ]);
    }
}
