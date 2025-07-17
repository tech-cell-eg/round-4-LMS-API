<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
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
            ],
            [
                'slug'          => 'vuejs-complete-guide',
                'category_id'   => 2,
                'instructor_id' => 1,
                'title'         => 'Vue.js Complete Guide',
                'image'         => null,
                'overview'      => 'Master the Vue.js framework from basics to advanced concepts.',
                'description'   => 'This course dives deep into Vue components, routing, Vuex, and more.',
                'certifications'=> 'Vue.js Professional',
                'languages'     => json_encode(['English']),
                'levels'        => 2,
                'price'         => 80.00,
                'discount'      => 5.00,
                'tax'           => 3.00,
            ],
            [
                'slug'          => 'python-data-science',
                'category_id'   => 3,
                'instructor_id' => 1,
                'title'         => 'Python for Data Science',
                'image'         => null,
                'overview'      => 'Analyze data and build predictive models using Python.',
                'description'   => 'Pandas, NumPy, Matplotlib, and scikit-learn are all covered.',
                'certifications'=> 'Data Science with Python',
                'languages'     => json_encode(['English']),
                'levels'        => 2,
                'price'         => 120.00,
                'discount'      => 15.00,
                'tax'           => 5.00,
            ],
            [
                'slug'          => 'ui-ux-design-basics',
                'category_id'   => 4,
                'instructor_id' => 1,
                'title'         => 'UI/UX Design Basics',
                'image'         => null,
                'overview'      => 'Learn the fundamentals of UI and UX design.',
                'description'   => 'Covering usability, wireframing, prototyping, and design tools.',
                'certifications'=> 'UX Certified',
                'languages'     => json_encode(['English']),
                'levels'        => 1,
                'price'         => 70.00,
                'discount'      => 5.00,
                'tax'           => 2.00,
            ],
            [
                'slug'          => 'seo-fundamentals',
                'category_id'   => 5,
                'instructor_id' => 1,
                'title'         => 'SEO Fundamentals',
                'image'         => null,
                'overview'      => 'Learn how to optimize content for search engines.',
                'description'   => 'Covers keyword research, on-page SEO, link building, and more.',
                'certifications'=> 'SEO Specialist',
                'languages'     => json_encode(['English']),
                'levels'        => 1,
                'price'         => 60.00,
                'discount'      => 0.00,
                'tax'           => 2.00,
            ],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(
                ['slug' => $course['slug']],
                $course
            );
        }
    }
}
