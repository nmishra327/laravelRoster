<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Create some flight events
        Event::create([
            'type' => 'FLT',
            'flight_number' => 'DX123',
            'departure_airport' => 'JFK',
            'arrival_airport' => 'LAX',
            'start_time' => Carbon::parse('2022-01-15 10:00:00'),
            'end_time' => Carbon::parse('2022-01-15 13:00:00')
        ]);

        Event::create([
            'type' => 'FLT',
            'flight_number' => 'DX456',
            'departure_airport' => 'LAX',
            'arrival_airport' => 'JFK',
            'start_time' => Carbon::parse('2022-01-16 15:00:00'),
            'end_time' => Carbon::parse('2022-01-16 18:00:00')
        ]);

        // Create some standby events
        Event::create([
            'type' => 'SBY',
            'departure_airport' => 'JFK',
            'arrival_airport' => 'JFK',
            'start_time' => Carbon::parse('2022-01-17 08:00:00'),
            'end_time' => Carbon::parse('2022-01-17 20:00:00')
        ]);

        // Create some check-in/out events
        Event::create([
            'type' => 'CI',
            'departure_airport' => 'JFK',
            'arrival_airport' => 'JFK',
            'start_time' => Carbon::parse('2022-01-15 08:00:00'),
            'end_time' => Carbon::parse('2022-01-15 09:00:00')
        ]);

        Event::create([
            'type' => 'CO',
            'departure_airport' => 'LAX',
            'arrival_airport' => 'LAX',
            'start_time' => Carbon::parse('2022-01-15 14:00:00'),
            'end_time' => Carbon::parse('2022-01-15 15:00:00')
        ]);
    }
}
