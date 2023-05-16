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
        $pricing = [
            'pricing' => [
                'annual' => 100,
                'semi_annualy' => 50,
                'quarterly' => 25,
                'monthly' => 8,
            ],
        ];

        $commission = [
            'commission' => [
                'agent' => 70,
                'manager' => 30,
                'director' => 10,
            ],
        ];

        return [
            'name' => $this->faker->safeColorName(),
            'description' => $this->faker->paragraph(),
            'contract_price' => $this->faker->numberBetween(10000, 9000),
            'term_period' => $this->faker->numberBetween(1, 5),
            'pricing' => json_encode($pricing['pricing']),
            'commission' => json_encode($commission['commission']),
        ];
    }
}
