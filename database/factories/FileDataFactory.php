<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

abstract class FileDataFactory extends Factory
{
    public function withJsonDataFromFile(string $filename)
    {
        return $this->faker->unique()->randomElement(json_decode(file_get_contents(__DIR__."/../data/{$filename}.json"), true));
    }
}
