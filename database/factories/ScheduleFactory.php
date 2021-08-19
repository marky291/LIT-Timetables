<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Module;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Type;

class ScheduleFactory extends FileDataFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return array_merge([
            'course_id' => Course::factory(),
            'module_id' => Module::factory(),
            'room_id' => Room::factory(),
            'type_id' => Type::factory(),
        ], $this->withJsonDataFromFile('schedules'));
    }
}
