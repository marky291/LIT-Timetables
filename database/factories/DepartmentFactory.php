<?php

namespace Database\Factories;

use App\Models\Department;

class DepartmentFactory extends FileDataFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Department::class;

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
