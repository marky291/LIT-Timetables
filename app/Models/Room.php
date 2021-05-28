<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static firstOrCreate(array $array)
 * @method static firstWhere(string $string, mixed $room)
 */
class Room extends Model
{
    use HasFactory;

    protected $fillable = ['door'];
}
