<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Module
 *
 * @package App
 * @method static updateOrCreate(array $array, array $array1)
 * @method static Builder where(string $string, $i)
 * @method static firstOrCreate(array $array)
 */
class Module extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * A module belongs to a department.
     *
     * @return BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
