<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'content' => fake()->paragraphs(3, true),
            'author' => fake()->name(),
            'image' => fake()->imageUrl(),
            'is_published' => fake()->boolean(80),
            'published_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
