<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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

    protected $fillable = ['cookie_id', 'favorite', 'searchable_id', 'searchable_type', 'updated_at'];

    protected $casts = [
        'favorite' => 'boolean',
    ];

    public function searchable(): MorphTo
    {
        return $this->morphTo();
    }
}
