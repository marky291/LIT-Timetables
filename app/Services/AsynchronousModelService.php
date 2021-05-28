<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class AsynchronousModelService
{
    public function create(string $model, array $attributes)
    {
        $lock = Cache::lock("Inspect::".$attributes[array_key_first($attributes)]."_lock", 300); // 5 min

        try {
            if ($lock->get()) {
                $model::firstOrCreate($attributes);
            }
        } finally {
            $lock->release();
        }
    }
}
