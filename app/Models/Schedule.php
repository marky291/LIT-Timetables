<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property Carbon $starting_date
 * @property Carbon $ending_date
 * @property Module $module
 * @property int $academic_year
 * @property int $academic_week
 * @property int $latestAvailableWeek
 * @property int $latestAvailableYear
 * @property Room $room
 * @property Type $type
 * @property Course course
 *
 * @method static Builder previousWeek()
 * @method static Builder currentWeek()
 * @method static Builder today()
 * @method static Builder current()
 * @method static Builder latestAcademicWeek()
 * @method static Builder latestAcademicYear()
 * @method static where(string $string, int $academic_week)
 * @method latest(string $string)
 */
class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'starting_date',
        'ending_date',
        'course_id',
        'module_id',
        'academic_week',
        'academic_year',
        'lecturer_id',
        'room_id',
        'type_id',
    ];

    protected $dates = [
        'starting_date',
        'ending_date',
    ];

    public function scopeCurrent(Builder $query): Builder
    {
        return $query->where('starting_date', '<', now())->where('ending_date', '>', now());
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('starting_date', '=', now());
    }

    public function scopeLatestAcademicWeek(Builder $query): Builder
    {
        return $query->latestAcademicYear()->where('academic_week', $this->latestAvailableWeek);
    }
    public function scopeLatestAcademicYear(Builder $query): Builder
    {
        return $query->where('academic_year', $this->latestAvailableYear);
    }
    public function scopePreviousWeek(Builder $query, int $week = 1): Builder
    {
        return $query->whereDate('starting_date', '=', now()->subWeeks($week));
    }

    public function module(): BelongsTo|Module
    {
        return $this->belongsTo(Module::class);
    }

    public function lecturers(): BelongsToMany
    {
        return $this->belongsToMany(Lecturer::class);
    }

    public function course(): BelongsTo|Course
    {
        return $this->belongsTo(Course::class);
    }

    public function room(): BelongsTo|Room
    {
        return $this->belongsTo(Room::class);
    }

    public function type(): BelongsTo|Type
    {
        return $this->belongsTo(Type::class);
    }

    public function isCurrentTime(): bool
    {
        return $this->starting_date < now() && $this->ending_date > now();
    }

    /**
     * Latest available week number from the database records.
     *
     * @return int
     */
    public function getLatestAvailableWeekAttribute() : mixed
    {
        return $this->latest('starting_date')->first()?->academic_week;
    }

    public function getLatestAvailableYearAttribute() : mixed
    {
        return $this->latest('starting_date')->first()?->starting_date->year;
    }

    public function newCollection(array $models = []): ScheduleCollection
    {
        return new ScheduleCollection($models);
    }
}
