<?php

namespace App\Models;

use App\Interfaces\SearchableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laravel\Scout\Searchable;

/**
 * Class Lecturer.
 *
 * @property string $fullname
 * @property string $route
 * @property mixed|\Ramsey\Uuid\UuidInterface uuid
 *
 * @method static firstOrCreate(array $array)
 * @method static firstWhere(string $string, int $lecturer_id)
 * @method static first()
 * @method static count()
 * @method static whereIn(string $string, string[] $explode)
 */
class Lecturer extends Model implements SearchableInterface
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['fullname'];

    /**
     * @return BelongsToMany
     */
    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class);
    }

    public function searches(): MorphOne
    {
        return $this->morphOne(Search::class, 'searchable');
    }

    public function subscribers(): MorphToMany
    {
        return $this->morphToMany(User::class, 'notifiable');
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function getRouteTitleAttribute(): string
    {
        return $this->fullname;
    }

    public function getRouteAttribute(): string
    {
        return route('lecturer', $this);
    }

    public function getIconCategoryAttribute() : string
    {
        return 'Lecturer';
    }
}
