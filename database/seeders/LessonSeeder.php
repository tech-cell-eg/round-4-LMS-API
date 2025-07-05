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
            'duration' => rand(min: 2000,max: 6000)
            'video_url'   => 'https://example.com/videos/directory-structure',
            'duration'    => 12,
        ]);

        Lesson::create([
            'syllabus_id' => 2,
            'title'       => 'Controller Methods',
            'description' => 'Creating controllers and organizing logic.',
            'duration' => rand(min: 2000,max: 6000)
            'video_url'   => 'https://example.com/videos/controllers',
            'duration'    => 18,
        ]);

        Lesson::create([
            'syllabus_id' => 3,
            'title'       => 'Binding and Events',
            'description' => 'Understanding v-model, events, and reactivity.',
            'duration' => rand(min: 2000,max: 6000)
            'video_url'   => 'https://example.com/videos/binding-events',
            'duration'    => 17,
        ]);

    }
}
