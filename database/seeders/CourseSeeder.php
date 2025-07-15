<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
<<<<<<< HEAD
  public function run(): void
{
    Course::factory()->count(5)->create();

    $courses = [
        [
            'slug' => 'laravel-from-zero-to-hero',
            'category_id' => 1,
=======
    public function run(): void
    {
         Course::create([
            'slug'          => 'laravel-from-zero-to-hero',
            'category_id'   => 1,
>>>>>>> c33082e1a49e567a867010d4e02f2485d3162cdc
            'instructor_id' => 1,
            'title' => 'Laravel From Zero to Hero',
            'image' => null,
            'overview' => 'A complete guide to Laravel framework for beginners.',
            'description' => 'This course covers everything you need to build Laravel applications from scratch.',
            'certifications' => 'Laravel Certified Developer',
            'languages' => json_encode(['English', 'Arabic']),
            'levels' => 1,
            'price' => 100.00,
            'discount' => 10.00,
            'tax' => 5.00,
        ],
        // أضف بقية الدورات هنا بنفس الشكل
    ];

    foreach ($courses as $course) {
        Course::firstOrCreate(
            ['slug' => $course['slug']],
            $course
        );
    }
}

}
