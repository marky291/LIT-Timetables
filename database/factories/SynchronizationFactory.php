<?php

namespace Database\Factories;

use App\Models\Synchronization;
use Illuminate\Database\Eloquent\Factories\Factory;

class SynchronizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'created_at' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
