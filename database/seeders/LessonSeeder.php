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
            'title'       => 'Directory Structure',
            'description' => 'Understanding Laravel’s folder structure and purpose of each.',
            'duration'    => rand(2000, 6000),
            'video_url'   => 'https://example.com/videos/directory-structure',
        ]);

        Lesson::create([
            'syllabus_id' => 2,
            'title'       => 'Controller Methods',
            'description' => 'Creating controllers and organizing logic.',
            'duration'    => rand(2000, 6000),
            'video_url'   => 'https://example.com/videos/controllers',
        ]);

        Lesson::create([
            'syllabus_id' => 3,
            'title'       => 'Binding and Events',
            'description' => 'Understanding v-model, events, and reactivity.',
            'duration'    => rand(2000, 6000),
            'video_url'   => 'https://example.com/videos/binding-events',
        ]);

        Lesson::create([
            'syllabus_id' => 4,
            'title'       => 'Binding and Events',
            'description' => 'Understanding v-model, events, and reactivity.',
             'duration'    => rand(2000, 6000),
            'video_url'   => 'https://example.com/videos/binding-events',
        ]);

        Lesson::create([
            'syllabus_id' => 5,
            'title'       => 'Binding and Events',
            'description' => 'Understanding v-model, events, and reactivity.',
             'duration'    => rand(2000, 6000),
            'video_url'   => 'https://example.com/videos/binding-events',
        ]);
    }
}
