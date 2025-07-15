<?php

namespace Database\Seeders;

use App\Models\Cart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    
        Cart::create([
            'user_id' => 1]);
        Cart::create([
            'user_id' => 2]);
        Cart::create([
            'user_id' => 3]);
        Cart::create([
            'user_id' => 4]);
        Cart::create([
            'user_id' => 5]);
            Cart::create([
                'user_id' => 6]); 

    }
}
