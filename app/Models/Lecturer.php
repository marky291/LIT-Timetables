<?php

namespace App\Models;

use App\Interfaces\RoutableInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

/**
 * Class Lecturer
 *
 * @property string $forename
 * @property string $lastname
 *
 * @package App
 * @method static firstOrCreate(array $array)
 */
class Lecturer extends Model implements RoutableInterface
{
    use HasFactory;

    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fullname'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * @return string
     */
    public function getRouteTitleAttribute()
    {
        return $this->fullname;
    }

    /**
     * @return string
     */
    public function getRouteAttribute()
    {
        return route('lecturers.show', $this);
    }
}
