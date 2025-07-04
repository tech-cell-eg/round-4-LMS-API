<?php

namespace Database\Seeders;

use App\Models\Instructor;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->count(5)->create();

        Instructor::factory()->count(5)->create();

        $this->call([
            CategorySeeder::class,
            InstructorSeeder::class,
            CourseSeeder::class,
            SyllabusSeeder::class,
            LessonSeeder::class,
            ReviewSeeder::class,
        ]);


        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);

    }
}
