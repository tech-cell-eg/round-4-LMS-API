<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CreditCard;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cart_id' => Cart::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'country' => $this->faker->country(),
            'state' => $this->faker->state(),
            'credit_card_id'=>CreditCard::factory(),
            'payment_method' => $this->faker->randomElement(['paypal', 'credit_card']),
            'created_at' => now(),
            'updated_at' => now(),

        ];
    }
}
