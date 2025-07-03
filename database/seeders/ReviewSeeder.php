<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // Get up to 10 courses
        $courses = Course::take(10)->get();

        foreach ($courses as $course) {
            // Choose a random number of users (2-5) to review each course
            $randomUsers = $users->random(min(5, $users->count()));

            foreach ($randomUsers as $user) {
                Review::create([
                    'user_id'         => $user->id,
                    'reviewable_id'   => $course->id,
                    'reviewable_type' => Course::class,
                    'rating'          => Arr::random([3.5, 4.0, 4.5, 5.0]),
                    'comment'         => Arr::random([
                        'Very helpful course!',
                        'I enjoyed every part of it.',
                        'Could be more detailed in some sections.',
                        'Clear explanations and useful content.',
                        'Definitely recommend it for beginners.',
                    ]),
                ]);
            }
        }
    }
}
