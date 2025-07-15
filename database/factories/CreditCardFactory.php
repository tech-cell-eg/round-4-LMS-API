<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CreditCard>
 */
class CreditCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
            'name' => $this->faker->name(),
            'number' => $this->faker->creditCardNumber(),
            'expiry_date' => $this->faker->date(),
            'cvv' => $this->faker->numberBetween(100, 999),
        ];
    }
}
