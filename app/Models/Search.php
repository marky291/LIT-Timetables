<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, array|string|null $get)
 * @method static updateOrCreate(array $array, array $array1)
 * @method static find(int $search_id)
 * @method whereDate(string $string, string $string1, \Carbon\Carbon $carbon)
 * @method static count()
 */
class Search extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cookie_id', 'favorite', 'searchable_id', 'searchable_type', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'favorite' => 'boolean',
    ];

    /**
     * Get the parent searchable model.
     */
    public function searchable()
    {
        return $this->morphTo();
    }
}
