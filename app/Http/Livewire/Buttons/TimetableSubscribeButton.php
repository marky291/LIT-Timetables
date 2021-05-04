<?php

namespace App\Http\Livewire\Buttons;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Notifiable;
use App\Timetable\Mail\SubscribedToTimetable;
use App\Timetable\Mail\UnsubscribedFromTimetable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class TimetableSubscribeButton extends Component
{
    /**
     * @var Model
     */
    public $timetable;

    /**
     * @var Notifiable
     */
    public $notifiable;

    /**
     * @var integer
     */
    public $mailCounter;

    /**
     * Check if the user is already subscribed.
     *s
     * @return bool
     */
    public function isSubscribed()
    {
        return is_null($this->notifiable);
    }

    /**
     * Toggle subscription of the timetable.
     */
    public function subscribe()
    {
        switch ($this->timetable::class) {
            case Lecturer::class:
                auth()->user()->lecturers()->save($this->timetable);
                break;
            case Course::class:
                auth()->user()->courses()->save($this->timetable);
                break;
        }
        if ($this->mailCounter < 2) {
            Mail::to(auth()->user())->queue(new SubscribedToTimetable(auth()->id(), $this->timetable));
            $this->mailCounter++;
        }
        $this->hydrateNotifiable();
    }

    public function unsubscribe()
    {
        $this->notifiable->delete();
        if ($this->mailCounter < 2) {
            Mail::to(auth()->user())->queue(new UnsubscribedFromTimetable(auth()->id(), $this->timetable));
            $this->mailCounter++;
        }
        $this->hydrateNotifiable();
    }

    /**
     * Hydrate the notifiable property when requested.
     */
    public function hydrateNotifiable()
    {
        $this->notifiable = Notifiable::firstWhere([
            'notifiable_type' => $this->timetable->getMorphClass(),
            'notifiable_id' => $this->timetable->getKey(),
            'user_id' => auth()->user()->getKey(),
        ]);
    }

    public function mount()
    {
        if (auth()->check()) {
            $this->hydrateNotifiable();
            $this->mailCounter = 0;
        }
    }

    public function render()
    {
        return view('livewire.buttons.timetable-subscribe-button');
    }
}
