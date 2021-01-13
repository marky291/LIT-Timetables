<?php

namespace App\Models;

use App\Interfaces\RoutableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * Class Lecturer.
 *
 * @property string $forename
 * @property string $lastname
 *
 * @method static firstOrCreate(array $array)
 * @method static firstWhere(string $string, int $lecturer_id)
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
     * Get the lecturer searches.
     */
    public function searches()
    {
        return $this->morphOne(Search::class, 'searchable');
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
