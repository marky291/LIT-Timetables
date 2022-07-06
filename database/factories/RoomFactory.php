<?php

namespace Database\Factories;

use App\Models\Room;

class RoomFactory extends FileDataFactory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return $this->withJsonDataFromFile('rooms');
    }
}
