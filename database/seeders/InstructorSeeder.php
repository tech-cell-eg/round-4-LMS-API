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

        Instructor::create([
            'first_name' => 'Youssef',
            'last_name' => 'Mahmoud',
            'username' => 'youssef.mahmoud',
            'email' => 'youssef3@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'headline' => 'Expert in UI/UX',
            'about' => 'Youssef is a creative UI/UX designer and instructor.',
            'image' => 'instructor3.jpg',
            'areas_of_expertise' => json_encode(['UI/UX', 'Design', 'Creativity']),
            'experience' => 'Over 6 years of experience in design and teaching.',
        ]);

        Instructor::create([
            'first_name' => 'Fatma',
            'last_name' => 'Hassan',
            'username' => 'fatma.hassan',
            'email' => 'fatma4@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'headline' => 'Expert in Python',
            'about' => 'Fatma is a Python and Data Science instructor.',
            'image' => 'instructor4.jpg',
            'areas_of_expertise' => json_encode(['Python', 'Data Science', 'Machine Learning']),
            'experience' => 'Over 3 years of experience in data and teaching.',
        ]);
    }
}
