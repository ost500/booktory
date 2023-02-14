<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        /** @var Hotel $hotel */
        $hotel = Hotel::inRandomOrder()->first();

        return [
            'hotel_id' => $hotel->id,
            'user_name' => $this->faker->userName,
            'count' => $this->faker->numberBetween(0, $hotel->room_count),
            'status' => $this->faker->randomElement(['pending', 'active', 'rejected'])
        ];
    }
}
