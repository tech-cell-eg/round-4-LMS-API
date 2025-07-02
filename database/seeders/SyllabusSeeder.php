<?php

namespace Database\Seeders;

use App\Models\Syllabus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'description' => 'Introduction to Laravel, installation, and basic structure.',
        ]);

        Syllabus::create([
            'course_id'   => 1,
            'title'       => 'Routing and Controllers',
            'description' => 'Learn how routing works in Laravel and how to use controllers.',
        ]);

        Syllabus::create([
            'course_id'   => 2,
            'title'       => 'Vue Basics and Setup',
            'description' => 'Understand Vue instance, directives, and project setup.',
        ]);

        Syllabus::create([
            'course_id'   => 3,
            'title'       => 'Components and Props',
            'description' => 'Learn how to break your UI into reusable Vue components.',
        ]);

        Syllabus::create([
            'course_id'   => 3,
            'title'       => 'Python Essentials',
            'description' => 'Cover Python syntax, variables, and data types.',
        ]);

        Syllabus::create([
            'course_id'   => 3,
            'title'       => 'Data Science Libraries',
            'description' => 'Introduction to pandas, NumPy, and Matplotlib.',
        ]);

        Syllabus::create([
            'course_id'   => 4,
            'title'       => 'UI vs UX',
            'description' => 'Understand the difference between user interface and user experience.',
        ]);

        Syllabus::create([
            'course_id'   => 5,
            'title'       => 'SEO Fundamentals',
            'description' => 'Learn how to optimize content for search engines.',
        ]);
    }
    
}

