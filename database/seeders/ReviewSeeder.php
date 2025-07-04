<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Instructor;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $course = Course::first();


        Review::create([
            'user_id' => $user->id,
            'reviewable_id' => $course->id,
            'reviewable_type' => Course::class,
            'rating' => 5,
            'comment' => 'Excellent course review.',
        ]);

        Review::create([
            'user_id' => $user->id,
            'reviewable_id' => $course->id,
            'reviewable_type' => instructor::class,
            'rating' => 4,
            'comment' => 'Very useful course, highly recommended.',
        ]);
    }
}

