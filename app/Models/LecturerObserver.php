<?php

namespace App\Models;

use Illuminate\Support\Str;

class LecturerObserver
{
    public function creating(Lecturer $lecturer): void
    {
        $lecturer->uuid = Str::uuid();
    }

    public function created(Lecturer $lecturer): void
    {
        //
    }

    public function updated(Lecturer $lecturer): void
    {
        //
    }

    public function deleted(Lecturer $lecturer): void
    {
        //
    }

    public function restored(Lecturer $lecturer): void
    {
        //
    }

    public function forceDeleted(Lecturer $lecturer): void
    {
        //
    }
}
