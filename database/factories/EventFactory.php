<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('now', '+1 month');
        $endDate = fake()->dateTimeBetween($startDate, '+2 months');
        
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraphs(2, true),
            'location' => fake()->address(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'image' => fake()->imageUrl(),
            'is_active' => fake()->boolean(90),
        ];
    }
}
