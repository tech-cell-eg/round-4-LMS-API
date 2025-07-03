<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnrolledCoursesResource;

class ProfileController extends Controller
{
    public function myCourses()
    {
        $user = auth()->user();
        $courses = $user->courses()->with(['course.instructor', 'course.syllabuses.lessons'])->get();

        if ($courses->isEmpty()) {
            return response()->json([
                'message' => 'No courses found for this user',
                'courses' => [],
            ], 404);
        }

        return response()->json([
            'message' => 'Courses retrieved successfully',
            'courses' =>  EnrolledCoursesResource::collection($courses),
        ], 200);

    }
}
