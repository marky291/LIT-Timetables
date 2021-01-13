<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static where(string $string, array|string|null $get)
 * @method static updateOrCreate(array $array, array $array1)
 * @method static find(int $search_id)
 */
class Search extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cookie_id', 'searchable_id', 'searchable_type', 'updated_at'];

    /**
     * Get the parent searchable model.
     */
    public function searchable()
    {
        return $this->morphTo();
    }
}
