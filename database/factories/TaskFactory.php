<?php

namespace Database\Factories;

use Faker\Core\DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->text(20),
            'description' => fake()->text(100),
            'deadline' => fake()->dateTimeBetween('now', '+5 days')->format('Y-m-dTH:i'),
            'user_id' => 1
        ];
    }
}
