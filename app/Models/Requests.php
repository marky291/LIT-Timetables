<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Requests extends Model
{
    use HasFactory;

    protected $fillable = ['response', 'time', 'link', 'meta', 'mined'];

    protected $casts = [
        'meta' => 'array',
        'mined' => 'array',
    ];

    public function course(): BelongsTo|Course
    {
        return $this->belongsTo(Course::class);
    }
}
