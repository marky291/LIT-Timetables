<?php

namespace App\Models;

use App\Interfaces\SearchableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laravel\Scout\Searchable;

/**
 * Class Lecturer.
 *
 * @property string $fullname
 * @property string $route
 *
 * @method static firstOrCreate(array $array)
 * @method static firstWhere(string $string, int $lecturer_id)
 * @method static first()
 * @method static count()
 */
class Lecturer extends Model implements SearchableInterface
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
     * @return BelongsToMany
     */
    public function schedules()
    {
        return $this->belongsToMany(Schedule::class);
    }

    /**
     * Get the lecturer searches.
     */
    public function searches()
    {
        return $this->morphOne(Search::class, 'searchable');
    }

    /**
     * Get the users notified
     */
    public function subscribers(): MorphToMany
    {
        return $this->morphToMany(User::class, 'notifiable');
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
        return route('lecturer', $this);
    }

    /**
     * @return string
     */
    public function getIconCategoryAttribute() : string
    {
        return 'Lecturer';
    }
}
