<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        
        Lesson::create([
            'syllabus_id' => 1,
            'title'       => 'Installing Laravel',
            'description' => 'Step-by-step guide to installing Laravel via Composer.',
            'video_url'   => 'https://example.com/videos/laravel-install',
            'duration'    => 15, // بالدقائق
        ]);

        Lesson::create([
            'syllabus_id' => 1,
            'title'       => 'Directory Structure',
            'description' => 'Understanding Laravel’s folder structure and purpose of each.',
            'video_url'   => 'https://example.com/videos/directory-structure',
            'duration'    => 12,
        ]);

        Lesson::create([
            'syllabus_id' => 2,
            'title'       => 'Basic Routing',
            'description' => 'How to define routes and return views or responses.',
            'video_url'   => 'https://example.com/videos/basic-routing',
            'duration'    => 10,
        ]);

        Lesson::create([
            'syllabus_id' => 2,
            'title'       => 'Controller Methods',
            'description' => 'Creating controllers and organizing logic.',
            'video_url'   => 'https://example.com/videos/controllers',
            'duration'    => 18,
        ]);

        Lesson::create([
            'syllabus_id' => 3,
            'title'       => 'Creating Vue Components',
            'description' => 'How to define and use single-file components.',
            'video_url'   => 'https://example.com/videos/vue-components',
            'duration'    => 20,
        ]);

        Lesson::create([
            'syllabus_id' => 3,
            'title'       => 'Binding and Events',
            'description' => 'Understanding v-model, events, and reactivity.',
            'video_url'   => 'https://example.com/videos/binding-events',
            'duration'    => 17,
        ]);

    }
}
