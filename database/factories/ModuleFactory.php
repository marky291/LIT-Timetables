<?php

namespace Database\Factories;

use App\Models\Module;

class ModuleFactory extends FileDataFactory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return $this->withJsonDataFromFile('modules');
    }
}
