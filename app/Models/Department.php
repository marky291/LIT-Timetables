<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Department.
 *
 * @method static updateOrCreate(array $array, array $array1)
 * @method static firstWhere(string $string, $i)
 * @method static firstOrCreate(array $array)
 * @method static count()
 * @property string name
 */
class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'filter'];

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
