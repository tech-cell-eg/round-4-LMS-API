<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnrolledCoursesResource;
use App\Http\Resources\InstructorProfileResource;
use App\Http\Resources\UserReviewsResource;

class ProfileController extends Controller
{
    public function myCourses()
    {
        $user = auth()->user();
        $courses = $user->enrollments()->with(['course.instructor', 'course.syllabuses.lessons'])->get();

        if ($courses->isEmpty()) {
            return response()->json([
                'message' => 'No courses found for this user',
                'courses' => [],
            ], 200);
        }

        return response()->json([
            'message' => 'Courses retrieved successfully',
            'courses' =>  EnrolledCoursesResource::collection($courses),
        ], 200);

    }

    public function myInstructors()
    {
        $user = auth()->user();
        $instructors = $user->enrollments()->with('course.instructor')->get()
            ->pluck('course.instructor')
            ->unique('id');

        if ($instructors->isEmpty()) {
            return response()->json([
                'message' => 'No instructors found for this user',
                'instructors' => [],
            ], 200);
        }

        return response()->json([
            'message' => 'Instructors retrieved successfully',
            'instructors' =>InstructorProfileResource::collection($instructors),
        ], 200);
    }

    public function myReviews()
    {
        $user = auth()->user();
        $reviews = $user->reviews()->with('reviewable')->latest()->get();

        if ($reviews->isEmpty()) {
            return response()->json([
                'message' => 'No reviews found for this user',
            ], 200);
        }

        return response()->json([
            'message' => 'Reviews retrieved successfully',
            'reviews' => UserReviewsResource::collection($reviews),
        ], 200);
    }

}
