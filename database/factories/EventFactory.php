<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['DO', 'SBY', 'FLT', 'CI', 'CO', 'UNK']),
            'flight_number' => $this->faker->randomElement([null, 'DX' . $this->faker->numberBetween(1, 999)]),
            'departure_airport' => $this->faker->randomElement(['JFK', 'LAX', 'ORD', 'DFW', 'SFO']),
            'arrival_airport' => $this->faker->randomElement(['JFK', 'LAX', 'ORD', 'DFW', 'SFO']),
            'start_time' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'end_time' => $this->faker->dateTimeBetween('+1 hour', '+12 hours'),
        ];
    }
}
