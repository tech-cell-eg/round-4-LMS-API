<?php

namespace Database\Seeders;

use App\Models\Instructor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $firstNames = ['John', 'Jane', 'Alice', 'Bob', 'Tom', 'Sara', 'Mike', 'Lily', 'Dave', 'Nina'];
        $lastNames = ['Smith', 'Doe', 'Brown', 'Johnson', 'Taylor', 'Lee', 'Wilson', 'Clark', 'Hall', 'Adams'];

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
<<<<<<< HEAD
    }
    
=======
        }
>>>>>>> 266fafe991bd40180f1046008d0531c5490bd45c
}
