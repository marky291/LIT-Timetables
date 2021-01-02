<?php

namespace App\Observers;

use App\Models\Lecturer;
use Illuminate\Support\Str;

class LecturerObserver
{
    /**
     * Handle the lecturer "creating" event.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return void
     */
    public function creating(Lecturer $lecturer)
    {
        $lecturer->uuid = Str::uuid();
    }

    /**
     * Handle the lecturer "created" event.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return void
     */
    public function created(Lecturer $lecturer)
    {
        //
    }

    /**
     * Handle the lecturer "updated" event.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return void
     */
    public function updated(Lecturer $lecturer)
    {
        //
    }

    /**
     * Handle the lecturer "deleted" event.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return void
     */
    public function deleted(Lecturer $lecturer)
    {
        //
    }

    /**
     * Handle the lecturer "restored" event.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return void
     */
    public function restored(Lecturer $lecturer)
    {
        //
    }

    /**
     * Handle the lecturer "force deleted" event.
     *
     * @param  \App\Models\Lecturer  $lecturer
     * @return void
     */
    public function forceDeleted(Lecturer $lecturer)
    {
        //
    }
}
