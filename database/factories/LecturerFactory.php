<?php

namespace Database\Factories;

use App\Models\Lecturer;

class LecturerFactory extends FileDataFactory
{
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
