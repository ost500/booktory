<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->streetName(),
            'address' => $this->faker->address(),
            'room_count' => $this->faker->numberBetween(5,10)
        ];
    }
}
