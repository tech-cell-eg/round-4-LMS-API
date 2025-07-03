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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    User::factory()->count(5)->create();

    Instructor::factory()->count(5)->create();

        $this->call(InstructorSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(SyllabusSeeder::class);
        $this->call(LessonSeeder::class);  
             $this->call( ReviewSeeder::class);
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);

    }
}
