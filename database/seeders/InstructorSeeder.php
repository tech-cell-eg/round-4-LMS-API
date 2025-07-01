<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instructor;
use Illuminate\Support\Facades\Hash;

class InstructorSeeder extends Seeder
{
    public function run(): void
    {
        $firstNames = ['Ahmed', 'Sara', 'Youssef', 'Fatma', 'Omar', 'Nour', 'Hassan', 'Layla', 'Khaled', 'Mona'];
        $lastNames = ['Ali', 'Ibrahim', 'Mahmoud', 'Hassan', 'Salem', 'Younes', 'Adel', 'Fouad', 'Mostafa', 'Tarek'];

        for ($i = 0; $i < 10; $i++) {
            Instructor::create([
                'first_name'         => $firstNames[$i],
                'last_name'          => $lastNames[$i],
                'username'           => strtolower($firstNames[$i]) . '.' . strtolower($lastNames[$i]),
                'email'              => strtolower($firstNames[$i]) . $i . '@example.com',
                'password'           => Hash::make('password'), // كلمة سر وهمية
                'email_verified_at'  => now(),
                'headline'           => 'Expert in ' . ['Laravel', 'Vue.js', 'UI/UX', 'DevOps', 'Python'][$i % 5],
                'about'              => 'This is a sample instructor bio for ' . $firstNames[$i],
                'image'              => null,
                'areas_of_expertise' => json_encode(['PHP', 'Laravel', 'Teaching']),
                'experience'         => 'Over ' . (2 + $i) . ' years of experience in tech and teaching.',
            ]);
        }
    }
}
