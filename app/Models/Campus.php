<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static firstOrCreate(array $array)
 * @method static count()
 * @property string location
 * @property string city
 */
class Campus extends Model
{
    use HasFactory;

    protected $fillable = ['location'];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function getCityAttribute(): string
    {
        return match (strtolower($this->location)) {
            'moylish' => 'Moyross',
            'clonmel' => 'Clonmel',
            'ennis' => 'Ennis',
            'thurles' => 'Thurles',
            default => 'Unknown Location',
        };
    }
}
