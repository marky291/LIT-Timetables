<?php

namespace Database\Factories;

use App\Models\Campus;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends FileDataFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $data = $this->withJsonDataFromFile('courses');

        return [
            'department_id' => Department::factory(),
            'campus_id' => Campus::factory(),
            'name' => $data['name'],
            'title' => $data['title'],
            'year' => $data['year'],
            'group' => $data['group'],
            'identifier' => $data['identifier'],
        ];
    }
}
