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
        ]);

        Lesson::create([
            'syllabus_id' => 1,
            'title'       => 'Directory Structure',
            'description' => 'Understanding Laravel’s folder structure and purpose of each.',
        ]);

        Lesson::create([
            'syllabus_id' => 2,
            'title'       => 'Basic Routing',
            'description' => 'How to define routes and return views or responses.',
        ]);

        Lesson::create([
            'syllabus_id' => 2,
            'title'       => 'Controller Methods',
            'description' => 'Creating controllers and organizing logic.',
        ]);

        Lesson::create([
            'syllabus_id' => 3,
            'title'       => 'Creating Vue Components',
            'description' => 'How to define and use single-file components.',
        ]);

        Lesson::create([
            'syllabus_id' => 3,
            'title'       => 'Binding and Events',
            'description' => 'Understanding v-model, events, and reactivity.',
        ]);

        Lesson::create([
            'syllabus_id' => 4,
            'title'       => 'Binding and Events',
            'description' => 'Understanding v-model, events, and reactivity.',
        ]);

        Lesson::create([
            'syllabus_id' => 4,
            'title'       => 'Binding and Events',
            'description' => 'Understanding v-model, events, and reactivity.',
        ]);

        Lesson::create([
            'syllabus_id' => 5,
            'title'       => 'Binding and Events',
            'description' => 'Understanding v-model, events, and reactivity.',
        ]);

        Lesson::create([
            'syllabus_id' => 5,
            'title'       => 'Binding and Events',
            'description' => 'Understanding v-model, events, and reactivity.',
        ]);

    }
}
