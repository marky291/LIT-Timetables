<?php

namespace Database\Factories;

use App\Models\Room;

class RoomFactory extends DataFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return $this->fromFile('rooms');
    }
}
