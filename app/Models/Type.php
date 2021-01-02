<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $abbreviation
 * @property string $name
 * @property string $description
 *
 * @method static firstOrCreate(array $array)
 */
class Type extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abbreviation',
    ];

    public function GetNameAttribute(): string
    {
        return config("timetable.type.{$this->abbreviation}.name", $this->abbreviation);
    }
}
