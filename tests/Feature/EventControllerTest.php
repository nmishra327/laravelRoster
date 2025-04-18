<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_events_between_dates()
    {
        $event = Event::factory()->create([
            'start_time' => '2022-01-15 10:00:00',
            'end_time' => '2022-01-15 12:00:00'
        ]);

        $response = $this->getJson('/api/events?start_date=2022-01-14&end_date=2022-01-16');

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'type' => $event->type,
                'start_time' => $event->start_time->toDateTimeString(),
                'end_time' => $event->end_time->toDateTimeString()
            ]);
    }

    public function test_can_get_upcoming_flights()
    {
        $flight = Event::factory()->create([
            'type' => 'FLT',
            'start_time' => '2022-01-16 10:00:00',
            'end_time' => '2022-01-16 12:00:00'
        ]);

        $response = $this->getJson('/api/events/upcoming-flights');

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'type' => 'FLT',
                'start_time' => $flight->start_time->toDateTimeString()
            ]);
    }

    public function test_can_get_upcoming_standby()
    {
        $standby = Event::factory()->create([
            'type' => 'SBY',
            'start_time' => '2022-01-16 10:00:00',
            'end_time' => '2022-01-16 12:00:00'
        ]);

        $response = $this->getJson('/api/events/upcoming-standby');

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'type' => 'SBY',
                'start_time' => $standby->start_time->toDateTimeString()
            ]);
    }

    public function test_can_get_flights_from_location()
    {
        $flight = Event::factory()->create([
            'type' => 'FLT',
            'departure_airport' => 'JFK',
            'arrival_airport' => 'LAX'
        ]);

        $response = $this->getJson('/api/events/flights-from-location?location=JFK');

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'departure_airport' => 'JFK'
            ]);
    }

    public function test_can_upload_roster()
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->create('roster.txt', 100);

        $response = $this->postJson('/api/events/upload-roster', [
            'file' => $file,
            'format' => 'txt'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Roster uploaded and processed successfully'
            ]);
    }
}
