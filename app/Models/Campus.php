<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static firstOrCreate(array $array)
 * @property string location
 */
class Campus extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['location'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Only moylish is undefined in the weather.
     *
     * @return string
     */
    public function getCityAttribute()
    {
        return $this->location == 'Moylish' ? 'limerick' : $this->location;
    }
}
