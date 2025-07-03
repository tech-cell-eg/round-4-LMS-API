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

        Category::factory(5)->create();
        Course::factory(10)->create();
    Instructor::factory()->count(5)->create();


    }
}
