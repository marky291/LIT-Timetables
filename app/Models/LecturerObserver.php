<?php

namespace App\Models;

use Illuminate\Support\Str;

class LecturerObserver
{
    /**
     * Handle the lecturer "creating" event.
     *
     * @param Lecturer $lecturer
     * @return void
     */
    public function creating(Lecturer $lecturer)
    {
        $lecturer->uuid = Str::uuid();
    }

    /**
     * Handle the lecturer "created" event.
     *
     * @param Lecturer $lecturer
     * @return void
     */
    public function created(Lecturer $lecturer)
    {
        //
    }

    /**
     * Handle the lecturer "updated" event.
     *
     * @param Lecturer $lecturer
     * @return void
     */
    public function updated(Lecturer $lecturer)
    {
        //
    }

    /**
     * Handle the lecturer "deleted" event.
     *
     * @param Lecturer $lecturer
     * @return void
     */
    public function deleted(Lecturer $lecturer)
    {
        //
    }

    /**
     * Handle the lecturer "restored" event.
     *
     * @param Lecturer $lecturer
     * @return void
     */
    public function restored(Lecturer $lecturer)
    {
        //
    }

    /**
     * Handle the lecturer "force deleted" event.
     *
     * @param Lecturer $lecturer
     * @return void
     */
    public function forceDeleted(Lecturer $lecturer)
    {
        //
    }
}
