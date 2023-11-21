<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\todo>
 */
class todoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isDone = rand(0, 1);
        return [
            'note' => fake()->text(50),
            'is_done' => $isDone,
            'date_done' => $isDone? fake()->dateTimeBetween('2023-10-1'): null,
            'todo_type_id' => rand(1, 4),
        ];
    }
}
