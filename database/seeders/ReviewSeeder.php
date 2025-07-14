<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Instructor;
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
        $students = User::all();
        $instructors = Instructor::all();
        $courses = Course::all();

        // Add reviews for instructors
        foreach ($instructors as $instructor) {
            $randomStudents = $students->random(min(5, $students->count()));

            foreach ($randomStudents as $student) {
                Review::create([
                    'user_id'         => $student->id,
                    'reviewable_id'   => $instructor->id,
                    'reviewable_type' => Instructor::class,
                    'rating'          => Arr::random([3.5, 4.0, 4.5, 5.0]),
                    'comment'         => Arr::random([
                        'Excellent instructor!',
                        'Very helpful and clear.',
                        'Loved the sessions.',
                        'Needs more examples sometimes.',
                        'Highly recommend this instructor.',
                    ]),
                ]);
            }
        }

        // Add reviews for courses
        foreach ($courses as $course) {
            $randomStudents = $students->random(min(5, $students->count()));

            foreach ($randomStudents as $student) {
                Review::create([
                    'user_id'         => $student->id,
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
