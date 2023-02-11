<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Beneficiary>
 */
class BeneficiaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory()->create();

        return [
            'firstname' => $this->faker->firstName(),
            'middlename' => $this->faker->lastName(),
            'lastname' => $this->faker->lastName(),
            'relationship' => 'Child',
            'birthdate' => $this->faker->date(),
            'user_id' => $user->id,
        ];
    }
}
