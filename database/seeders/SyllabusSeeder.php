<?php

namespace Database\Seeders;

use App\Models\Syllabus;
use Illuminate\Database\Seeder;

class SyllabusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Syllabus::create([
            'course_id'   => 1,
            'title'       => 'Getting Started with Laravel',
            'subtitle'    => 'Laravel Introduction',
            'description' => 'Introduction to Laravel, installation, and basic structure.',
            'status'      => 'published',
            'type'        => 'video',
        ]);

        Syllabus::create([
            'course_id'   => 1,
            'title'       => 'Routing and Controllers',
            'subtitle'    => 'Laravel Routing',
            'description' => 'Learn how routing works in Laravel and how to use controllers.',
            'status'      => 'published',
            'type'        => 'video',
        ]);

        Syllabus::create([
            'course_id'   => 2,
            'title'       => 'Vue Basics and Setup',
            'subtitle'    => 'Vue.js Setup',
            'description' => 'Understand Vue instance, directives, and project setup.',
            'status'      => 'draft',
            'type'        => 'video',
        ]);

        Syllabus::create([
            'course_id'   => 2,
            'title'       => 'Components and Props',
            'subtitle'    => 'Vue Components',
            'description' => 'Learn how to break your UI into reusable Vue components.',
            'status'      => 'published',
            'type'        => 'video',
        ]);

        Syllabus::create([
            'course_id'   => 3,
            'title'       => 'Python Essentials',
            'subtitle'    => 'Basics of Python',
            'description' => 'Cover Python syntax, variables, and data types.',
            'status'      => 'published',
            'type'        => 'pdf',
        ]);

        Syllabus::create([
            'course_id'   => 3,
            'title'       => 'Data Science Libraries',
            'subtitle'    => 'Pandas & NumPy',
            'description' => 'Introduction to pandas, NumPy, and Matplotlib.',
            'status'      => 'draft',
            'type'        => 'pdf',
        ]);

        Syllabus::create([
            'course_id'   => 4,
            'title'       => 'UI vs UX',
            'subtitle'    => 'Design Thinking',
            'description' => 'Understand the difference between user interface and user experience.',
            'status'      => 'published',
            'type'        => 'video',
        ]);

        Syllabus::create([
            'course_id'   => 5,
            'title'       => 'SEO Fundamentals',
            'subtitle'    => 'Search Optimization',
            'description' => 'Learn how to optimize content for search engines.',
            'status'      => 'draft',
            'type'        => 'video',
        ]);
    }
}
