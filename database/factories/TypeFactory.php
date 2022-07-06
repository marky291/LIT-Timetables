<?php

namespace Database\Factories;

use App\Models\Type;

class TypeFactory extends FileDataFactory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return $this->withJsonDataFromFile('types');
    }
}
