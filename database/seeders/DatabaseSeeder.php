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

         User::factory()->create([
            'first_name' => 'user',
            'last_name' => 'user',
            'username' => 'username',
            'email' => 'user@user',
             'password' => bcrypt('password'),
         ]);

        User::factory()->count(5)->create();

        Instructor::factory()->count(5)->create();
      
            $this->call(InstructorSeeder::class);
            $this->call(CategorySeeder::class);
            $this->call(CourseSeeder::class);
            $this->call(SyllabusSeeder::class);
            $this->call(LessonSeeder::class);
            $this->call(EnrollmentAndDoneLessonSeeder::class);
            $this->call(ChatAndMessageSeeder::class);
            $this->call(LessonSeeder::class);  
            $this->call(ReviewSeeder::class);
            $this->call(SocialSeeder::class);
        }
}
