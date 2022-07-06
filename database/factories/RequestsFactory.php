<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Model;
use App\Models\Requests;

class RequestsFactory extends FileDataFactory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return array_merge([
            'course_id' => Course::factory(),
        ], $this->withJsonDataFromFile('requests'));
    }
}
