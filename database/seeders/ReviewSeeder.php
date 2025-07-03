<?php

namespace Database\Seeders;

use App\Models\Instructor;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Review;

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

        foreach ($instructors as $instructor) {
            foreach ($students->random(2) as $student) {
                Review::create([
                    'user_id' => $student->id,
                    'reviewable_id' => $instructor->id,
                    'reviewable_type' => Instructor::class,
                    'rating' => rand(3, 5),
                    'comment' => 'Great instructor!',
                ]);
            }
        }

        foreach ($courses as $course) {
            foreach ($students->random(2) as $student) {
                Review::create([
                    'user_id' => $student->id,
                    'reviewable_id' => $course->id,
                    'reviewable_type' => Course::class,
                    'rating' => rand(3, 5),
                    'comment' => 'Helpful course content!',
                ]);
            }
        }
    }
}
