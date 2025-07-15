<?php

namespace Database\Seeders;

use App\Models\CartItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         CartItem::create([
            'cart_id' => 1,
            'course_id' => 1,
        ]);

         CartItem::create([
            'cart_id' => 2,
            'course_id' => 2,
        ]);

           CartItem::create([
            'cart_id' => 3,
            'course_id' => 3,
        ]);
    }
}
