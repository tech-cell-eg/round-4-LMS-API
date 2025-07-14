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
<<<<<<< HEAD
            'duration'    => rand(2000, 6000),
=======
            'duration' => rand(min: 2000,max: 6000),
>>>>>>> c33082e1a49e567a867010d4e02f2485d3162cdc
            'video_url'   => 'https://example.com/videos/directory-structure',
        ]);

        Lesson::create([
            'syllabus_id' => 2,
            'title'       => 'Controller Methods',
            'description' => 'Creating controllers and organizing logic.',
<<<<<<< HEAD
            'duration'    => rand(2000, 6000),
=======
            'duration' => rand(min: 2000,max: 6000),
>>>>>>> c33082e1a49e567a867010d4e02f2485d3162cdc
            'video_url'   => 'https://example.com/videos/controllers',
        ]);

        Lesson::create([
            'syllabus_id' => 3,
            'title'       => 'Binding and Events',
            'description' => 'Understanding v-model, events, and reactivity.',
<<<<<<< HEAD
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
=======
            'duration' => rand(min: 2000,max: 6000),
            'video_url'   => 'https://example.com/videos/binding-events',
        ]);

>>>>>>> c33082e1a49e567a867010d4e02f2485d3162cdc
    }
}
