<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstNames = ['Omar', 'Salma', 'Ali', 'Nour', 'Ahmed', 'Laila', 'Kareem', 'Farah', 'Youssef', 'Mona'];
        $lastNames = ['Ibrahim', 'Fahmy', 'Yassin', 'Zaki', 'Hassan', 'Kamal', 'Hegazy', 'Adel', 'Nassar', 'Tamer'];

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'first_name'        => $firstNames[$i],
                'last_name'         => $lastNames[$i],
                'name'              => $firstNames[$i] . ' ' . $lastNames[$i],
                'username'          => strtolower($firstNames[$i]) . '.' . strtolower($lastNames[$i]),
                'email'             => strtolower($firstNames[$i]) . $i . '@example.com',
                'headline'          => 'Passionate Learner',
                'description'       => 'This is a user profile bio for ' . $firstNames[$i],
                'image'             => null,
                'languages'         => json_encode(['English', 'Arabic']),
                'email_verified_at' => now(),
                'password'          => Hash::make('password'), // كلمة السر لكل اليوزرات: password
            ]);
        }
    }
}
