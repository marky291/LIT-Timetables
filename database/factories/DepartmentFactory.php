<?php

namespace Database\Factories;

use App\Models\Department;

class DepartmentFactory extends FileDataFactory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return $this->withJsonDataFromFile('departments');
    }
}
