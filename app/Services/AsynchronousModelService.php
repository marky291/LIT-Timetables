<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AsynchronousModelService
{
    public function create(string $model, array $attributes)
    {
        $modelName = strtolower(class_basename($model));

        $uniqueSlug = Str::of($attributes[array_key_first($attributes)])->slug();

        $lock = Cache::lock("{$modelName}-{$uniqueSlug}-lock", 60);

        if ($lock->get()) {
            $model::firstOrCreate($attributes);
        }
    }
}
