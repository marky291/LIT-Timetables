<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Department
 *
 * @package App
 * @method static updateOrCreate(array $array, array $array1)
 * @method static firstWhere(string $string, $i)
 * @method static firstOrCreate(array $array)
 */
class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'filter'];

    /**
     * A department has many modules.
     *
     * @return HasMany
     */
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    /**
     * @return HasMany
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
