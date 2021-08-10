<?php

namespace Database\Factories;

use App\Models\Module;

class ModuleFactory extends FileDataFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Module::class;

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
