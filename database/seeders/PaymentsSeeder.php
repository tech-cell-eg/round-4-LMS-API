<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'cart_id' => 1,
                'credit_card_id' => null,
                'payment_method' => 'credit_card',
                'amount' => 100.00,
                'country' => 'polanda',
                'state' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cart_id' => 2,
                'credit_card_id' => null,
                'payment_method' => 'paypal',
                'amount' => 250.00,
                'country' => 'Imaratiee',
                'state' => 'received',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cart_id' => 3,
                'credit_card_id' => null,
                'payment_method' => 'credit_card',
                'amount' => 300.00,
                'country' => 'Italy',
                'state' => 'complete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cart_id' => 4,
                'credit_card_id' => null,
                'payment_method' => 'paypal',
                'amount' => 180.00,
                'country' => 'Iraq',
                'state' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cart_id' => 5,
                'credit_card_id' => null,
                'payment_method' => 'credit_card',
                'amount' => 220.00,
                'country' => 'Eran',
                'state' => 'received',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cart_id' => 6,
                'credit_card_id' => null,
                'payment_method' => 'paypal',
                'amount' => 350.00,
                'country' => 'Germany',
                'state' => 'complete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
