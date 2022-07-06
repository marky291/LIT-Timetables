<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @method static firstWhere(array $array)
 * @method static where(array $array)
 * @method static userCourses(int|string|null $id)
 * @method static userLecturers(int|string|null $id)
 * @method static user(User $user)
 * @method static create($toArray)
 * @method static hasSubscriptions(User|\Illuminate\Contracts\Auth\Authenticatable|null $user)
 */
class Notifiable extends Model
{
    use HasFactory;

    public function usesTimestamps(): bool
    {
        return false;
    }

    public function scopeHasSubscriptions(Builder $query, User $user) : int
    {
        return $query->user($user)->count() > 0;
    }

    public function scopeUser(Builder $query, User $user): Builder
    {
        return $query->where('user_id', $user->getKey());
    }

    public function scopeUserCourses(Builder $query, User $user): Builder
    {
        return $query->where(['user_id' => $user->getKey(), 'notifiable_type' => Course::class]);
    }

    public function scopeUserLecturers(Builder $query, User $user): Builder
    {
        return $query->where(['user_id' => $user->getKey(), 'notifiable_type' => Lecturer::class]);
    }

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
