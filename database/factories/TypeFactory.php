<?php

namespace Database\Factories;

use App\Models\Type;

class TypeFactory extends DataFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Type::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return $this->fromFile('types');
    }
}
