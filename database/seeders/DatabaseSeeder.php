<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
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

<<<<<<< HEAD
        Category::factory(5)->create();
        Course::factory(10)->create();
=======
>>>>>>> 5ec8fb9f762bfee97f93535bf05d39b6a60f8f86
    Instructor::factory()->count(5)->create();

        $this->call(InstructorSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(SyllabusSeeder::class);
        $this->call(LessonSeeder::class);
 
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);

    }
}
