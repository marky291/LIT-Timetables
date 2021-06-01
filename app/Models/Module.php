<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Module.
 *
 * @method static updateOrCreate(array $array, array $array1)
 * @method static Builder where(string $string, $i)
 * @method static firstOrCreate(array $array)
 * @method static firstWhere(string $string, mixed $module)
 */
class Module extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function department(): BelongsTo|Department
    {
        return $this->belongsTo(Department::class);
    }
}
