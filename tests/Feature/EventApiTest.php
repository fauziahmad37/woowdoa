<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_events(): void
    {
        Event::factory()->create([
            'title' => 'Test Event',
            'description' => 'Test Description',
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/events');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'data' => [
                        '*' => ['id', 'title', 'description', 'location', 'start_date', 'is_active']
                    ]
                ]
            ]);
    }

    public function test_can_create_event(): void
    {
        $eventData = [
            'title' => 'New Test Event',
            'description' => 'New Test Description',
            'location' => 'Test Location',
            'start_date' => now()->addDays(7)->toISOString(),
            'is_active' => true,
        ];

        $response = $this->postJson('/api/events', $eventData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Event berhasil dibuat',
            ]);

        $this->assertDatabaseHas('events', [
            'title' => 'New Test Event',
        ]);
    }

    public function test_can_get_single_event(): void
    {
        $event = Event::factory()->create();

        $response = $this->getJson("/api/events/{$event->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $event->id,
                    'title' => $event->title,
                ]
            ]);
    }

    public function test_can_update_event(): void
    {
        $event = Event::factory()->create();

        $updateData = [
            'title' => 'Updated Event Title',
        ];

        $response = $this->putJson("/api/events/{$event->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Event berhasil diperbarui',
            ]);

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Updated Event Title',
        ]);
    }

    public function test_can_delete_event(): void
    {
        $event = Event::factory()->create();

        $response = $this->deleteJson("/api/events/{$event->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Event berhasil dihapus',
            ]);

        $this->assertDatabaseMissing('events', [
            'id' => $event->id,
        ]);
    }
}
