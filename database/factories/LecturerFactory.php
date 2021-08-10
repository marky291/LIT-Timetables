<?php

namespace Database\Factories;

use App\Models\Lecturer;

class LecturerFactory extends FileDataFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lecturer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return $this->withJsonDataFromFile('lecturers');
    }
}
