<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

abstract class DataFactory extends Factory
{
    public function fromFile(string $filename)
    {
        return $this->faker->randomElement(json_decode(file_get_contents(__DIR__."/../data/{$filename}.json"), true));
    }
}
