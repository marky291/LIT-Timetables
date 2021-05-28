<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property Carbon $starting_date
 * @property Carbon $ending_date
 * @property Module $module
 * @property int $academic_week
 * @property int $latestAvailableWeek
 * @property Room $room
 * @property Type $type
 * @property Course course
 *
 * @method static Builder previousWeek()
 * @method static Builder currentWeek()
 * @method static Builder today()
 * @method static Builder current()
 * @method static Builder latestAcademicWeek()
 * @method static where(string $string, int $academic_week)
 * @method latest(string $string)
 */
class Schedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'starting_date',
        'ending_date',
        'course_id',
        'module_id',
        'academic_week',
        'lecturer_id',
        'room_id',
        'type_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'starting_date',
        'ending_date',
    ];

    // scope current time.
    public function scopeCurrent(Builder $query)
    {
        return $query->where('starting_date', '<', now())->where('ending_date', '>', now());
    }

    // scope current day.
    public function scopeToday(Builder $query)
    {
        return $query->whereDate('starting_date', '=', now());
    }

    // scope current week.
    public function scopeLatestAcademicWeek(Builder $query)
    {
        return $query->where('academic_week', $this->latestAvailableWeek);
    }

    // scope last weeks schedule.
    public function scopePreviousWeek(Builder $query, int $week = 1)
    {
        return $query->whereDate('starting_date', '=', now()->subWeeks($week));
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * @return BelongsToMany|Schedule
     */
    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function type()
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
        return $this->latest('academic_week')->first()?->academic_week;
    }

    public function newCollection(array $models = []): ScheduleCollection
    {
        return new ScheduleCollection($models);
    }
}
