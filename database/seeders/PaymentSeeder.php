<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Cart;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $cart = Cart::first();

        if (!$cart) {
            $this->command->warn('You need at least one cart in the database before running this seeder.');
            return;
        }

        // إضافة 10 مدفوعات وهمية
        foreach (range(1, 10) as $i) {
            Payment::create([
                'cart_id'        => $cart->id, 
                'credit_card_id' => null, 
                'payment_method' => ['credit_card', 'paypal'][rand(0, 1)],
                'amount'         => rand(100, 1000),
                'country'        => fake()->country(),
                'state'          => fake()->city(),
                'created_at'     => now()->subDays(rand(0, 365)),
                'updated_at'     => now(),
            ]);
        }

        $this->command->info('Payments seeded successfully.');
    }
}
