<?php

namespace App\Http\Livewire\Profile;

use App\Mail\UpdatedSubscriptionsMail;
use App\Models\Notifiable;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

/**
 * @property User user
 */
class UpdateSubscriptionForm extends Component
{
    public $state;

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $notifiables = Notifiable::user($this->user)->pluck('id');

        $notifiables->each(function($notification) {
            $this->state[$notification] = $notification;
        });
    }

    public function getUserProperty(): User|Authenticatable|null
    {
        return Auth::user();
    }

    public function getNotifiableCoursesProperty(): Collection
    {
        return  Notifiable::userCourses(auth()->user())->get();
    }

    public function getNotifiableLecturersProperty(): Collection
    {
        return  Notifiable::userLecturers(auth()->user())->get();
    }

    public function hasSubscriptions()
    {
        return Notifiable::hasSubscriptions($this->user);
    }

    public function updateSubscriptionInformation()
    {
        if ($this->state == null) {
            return;
        }

        Notifiable::unguard();
        $subscription = Notifiable::user($this->user)->whereIn('id', $this->state)->get();

        Notifiable::user($this->user)->delete();

        $subscription->each(fn($subscription) => Notifiable::create($subscription->toArray()));
        Notifiable::reguard();

        $this->emit('saved');

        Mail::to(auth()->user())->queue(new UpdatedSubscriptionsMail(auth()->id()));

        $this->emit('refresh-navigation-menu');
    }

    public function render()
    {
        return view('profile.update-subscription-form');
    }
}
