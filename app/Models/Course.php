<?php

namespace App\Models;

use App\Interfaces\RoutableInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Stringable;
use Laravel\Scout\Searchable;

/**
 * @property string $name
 * @property string $identifier
 * @property string $meta
 * @property Collection $timetables
 * @method static updateOrCreate(array $array, array $array1)
 * @method static where(string $string, Stringable $name)
 * @method static make(array $toArray)
 * @method static firstWhere(string $string, int $course_id)
 */
class Course extends Model implements RoutableInterface
{
    use HasFactory;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'identifier', 'year', 'group', 'title'];

    /**
     * @return HasMany|Schedule
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function requests()
    {
        return $this->hasMany(Requests::class);
    }

    public function request()
    {
        return $this->hasOne(Requests::class);
    }

    /**
     * Get the lecturer searches.
     */
    public function searches(): MorphOne
    {
        return $this->morphOne(Search::class, 'searchable');
    }

    /**
     * Get the lecturer favorable models.
     */
    public function favorable(): MorphOne
    {
        return $this->morphOne(Favorite::class, 'favorable');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'identifier';
    }

    /**
     * @return string
     */
    public function getRouteTitleAttribute()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRouteAttribute()
    {
        return route('courses.show', $this);
    }
}
