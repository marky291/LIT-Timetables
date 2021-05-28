<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static firstOrCreate(array $array)
 * @method static count()
 * @property string location
 */
class Campus extends Model
{
    use HasFactory;

    protected $fillable = ['location'];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
