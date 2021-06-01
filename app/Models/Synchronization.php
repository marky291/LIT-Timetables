<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Carbon lastRun()
 * @method latest()
 */
class Synchronization extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    public function scopeLastRun() : Carbon
    {
        return $this->latest()->first()->created_at;
    }
}
