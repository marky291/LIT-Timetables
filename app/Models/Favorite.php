<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorite extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cookie_id', 'favorable_id', 'favorable_type', 'updated_at'];

    /**
     * Get the parent searchable model.
     */
    public function favorable()
    {
        return $this->morphTo();
    }
}
