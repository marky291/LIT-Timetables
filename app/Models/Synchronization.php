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

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = null;

    /**
     * Get the last run of the sync command.
     * @return Carbon
     */
    public function scopeLastRun() : Carbon
    {
        return $this->latest()->first()->created_at;
    }
}
