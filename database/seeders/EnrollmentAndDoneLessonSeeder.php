<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\DoneLesson;

class EnrollmentAndDoneLessonSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::all();
        $courses = Course::with('syllabuses.lessons')->get();

        foreach ($students as $student) {

            $enrolledCourses = $courses->random(min(2, $courses->count()));

            foreach ($enrolledCourses as $course) {

                Enrollment::firstOrCreate([
                    'user_id' => $student->id,
                    'course_id' => $course->id,
                ]);

                $lessons = $course->syllabuses->flatMap(function ($syllabus) {
                    return $syllabus->lessons;
                });

                $doneLessons = $lessons->random(min(3, $lessons->count()));

                foreach ($doneLessons as $lesson) {
                    DoneLesson::firstOrCreate([
                        'user_id' => $student->id,
                        'lesson_id' => $lesson->id,
                    ]);
                }
            }
        }
    }
}
