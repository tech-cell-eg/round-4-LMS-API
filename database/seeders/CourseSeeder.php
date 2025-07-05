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
    public function run(): void
    {
         Course::factory()->count(5)->create();
         Course::create([
            'slug'          => 'laravel-from-zero-to-hero',
            'category_id'   => 1,
            'instructor_id' => 1,
            'title'         => 'Laravel From Zero to Hero',
            'image'         => null,
            'overview'      => 'A complete guide to Laravel framework for beginners.',
            'description'   => 'This course covers everything you need to build Laravel applications from scratch.',
            'certifications'=> 'Laravel Certified Developer',
            'languages'     => json_encode(['English', 'Arabic']),
            'levels'        => 1,
            'price'         => 100.00,
            'discount'      => 10.00,
            'tax'           => 5.00,
        ]);

        Course::create([
            'slug'          => 'mastering-vuejs',
            'category_id'   => 2,
            'instructor_id' => 2,
            'title'         => 'Mastering Vue.js',
            'image'         => null,
            'overview'      => 'Deep dive into Vue.js for building reactive web apps.',
            'description'   => 'Learn Vue.js concepts, components, and best practices.',
            'certifications'=> 'Vue.js Expert Certificate',
            'languages'     => json_encode(['English']),
            'levels'        => 2,
            'price'         => 120.00,
            'discount'      => 15.00,
            'tax'           => 7.00,
        ]);

        Course::create([
            'slug'          => 'python-for-data-science',
            'category_id'   => 3,
            'instructor_id' => 3,
            'title'         => 'Python for Data Science',
            'image'         => null,
            'overview'      => 'Learn Python programming for data analysis and machine learning.',
            'description'   => 'Comprehensive course on Python basics and data science libraries.',
            'certifications'=> 'Data Science Certificate',
            'languages'     => json_encode(['English']),
            'levels'        => 1,
            'price'         => 130.00,
            'discount'      => 20.00,
            'tax'           => 8.00,
        ]);

        Course::create([
            'slug'          => 'ui-ux-design-fundamentals',
            'category_id'   => 4,
            'instructor_id' => 4,
            'title'         => 'UI/UX Design Fundamentals',
            'image'         => null,
            'overview'      => 'Basics of user interface and user experience design.',
            'description'   => 'Learn design principles, wireframing, and prototyping.',
            'certifications'=> 'Design Certificate',
            'languages'     => json_encode(['English', 'French']),
            'levels'        => 1,
            'price'         => 90.00,
            'discount'      => 5.00,
            'tax'           => 4.50,
        ]);

        Course::create([
            'slug'          => 'digital-marketing-strategies',
            'category_id'   => 5,
            'instructor_id' => 5,
            'title'         => 'Digital Marketing Strategies',
            'image'         => null,
            'overview'      => 'Effective digital marketing techniques for business growth.',
            'description'   => 'SEO, social media marketing, and content strategy essentials.',
            'certifications'=> 'Marketing Expert Certificate',
            'languages'     => json_encode(['English']),
            'levels'        => 2,
            'price'         => 110.00,
            'discount'      => 12.00,
            'tax'           => 6.00,
        ]);
     }
}
