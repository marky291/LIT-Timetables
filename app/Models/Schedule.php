<?php

namespace App\Models;

use App\Timetable\Collections\ScheduleCollection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Carbon $starting_date
 * @property Carbon $ending_date
 * @property Module $module
 * @property Lecturer $lecturer
 * @property int $academic_week
 * @property Room $room
 * @property Type $type
 *
 * @method static Builder previousWeek()
 * @method static Builder currentWeek()
 * @method static Builder today()
 * @method static Builder current()
 * @method static Builder latestAcademicWeek()
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
        'type_id'
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
        return $query->latest('academic_week');
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

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
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

    public function isCurrentTime()
    {
        return $this->starting_date < now() && $this->ending_date > now();
    }

    public function newCollection(array $models = [])
    {
        return new ScheduleCollection($models);
    }
}
