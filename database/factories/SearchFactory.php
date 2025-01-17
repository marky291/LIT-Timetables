<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Search;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SearchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cookie_id' => Str::uuid(),
            'favorite' => $this->faker->boolean(),
        ];
    }

    public function lecturer()
    {
        return $this->state(function (array $attributes) {
            return [
                'searchable_id' => Lecturer::factory(),
                'searchable_type' => Lecturer::class,
            ];
        });
    }

    public function course()
    {
        return $this->state(function (array $attributes) {
            return [
                'searchable_id' => Course::factory(),
                'searchable_type' => Course::class,
            ];
        });
    }
}
