<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->safeColorName(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(10000, 9000),
            'year_period' => $this->faker->numberBetween(1, 5),
        ];
    }
}
