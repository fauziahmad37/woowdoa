<?php

namespace Tests\Feature;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_news(): void
    {
        News::factory()->create([
            'title' => 'Test News',
            'content' => 'Test Content',
            'is_published' => true,
        ]);

        $response = $this->getJson('/api/news');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'data' => [
                        '*' => ['id', 'title', 'content', 'author', 'is_published']
                    ]
                ]
            ]);
    }

    public function test_can_create_news(): void
    {
        $newsData = [
            'title' => 'New Test News',
            'content' => 'New Test Content',
            'author' => 'Test Author',
            'is_published' => true,
        ];

        $response = $this->postJson('/api/news', $newsData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Berita berhasil dibuat',
            ]);

        $this->assertDatabaseHas('news', [
            'title' => 'New Test News',
        ]);
    }

    public function test_can_get_single_news(): void
    {
        $news = News::factory()->create();

        $response = $this->getJson("/api/news/{$news->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $news->id,
                    'title' => $news->title,
                ]
            ]);
    }

    public function test_can_update_news(): void
    {
        $news = News::factory()->create();

        $updateData = [
            'title' => 'Updated Title',
        ];

        $response = $this->putJson("/api/news/{$news->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Berita berhasil diperbarui',
            ]);

        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_can_delete_news(): void
    {
        $news = News::factory()->create();

        $response = $this->deleteJson("/api/news/{$news->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Berita berhasil dihapus',
            ]);

        $this->assertDatabaseMissing('news', [
            'id' => $news->id,
        ]);
    }
}
