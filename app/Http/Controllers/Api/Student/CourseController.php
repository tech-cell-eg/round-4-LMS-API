<?php

namespace App\Http\Controllers\Api\Student;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\InstructorInfoRelatedToCource;
use App\Models\Category;
use App\Models\Course;

class CourseController extends Controller
{
    // Show all courses
    public function index()
    {
        $courses = Course::with(['category', 'instructor', 'reviews', 'syllabuses.lessons', 'enrollments'])->get();

        return response()->json([
            'status' => true,
            'courses' => CourseResource::collection($courses),
        ]);
    }

    public function filterByCategory($category)
    {
        $category = Category::where('id', $category)
            ->orWhere('title', $category)
            ->first();

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $courses = Course::with(['category', 'instructor', 'reviews', 'syllabuses.lessons', 'enrollments'])
            ->where('category_id', $category->id)
            ->get();

        return response()->json([
            'status' => true,
            'category' => $category->title,
            'courses' => CourseResource::collection($courses),
        ]);
    }

    public function showCourseDetails($id)
    {
        $course = Course::with([
            'category',
            'instructor',
            'reviews.user',
            'syllabuses.lessons',
            'enrollments'
        ])->find($id);

        if (!$course) {
            return response()->json([
                'status' => false,
                'message' => 'Course not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'course' => new CourseResource($course),
        ]);
    }

    public function showInstructorInfoRelatedToCourse($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return ApiResponse::sendResponse([], 'Course not found', 404);
        }

        $instructor = $course->instructor()
            ->with(['courses.enrollments', 'courses.reviews', 'social'])
            ->first();

        if (!$instructor) {
            return ApiResponse::sendResponse([], 'Instructor not found', 404);
        }

        return ApiResponse::sendResponse([
            'course_id' => $course->id,
            'course_title' => $course->title,
            'instructor' => new InstructorInfoRelatedToCource($instructor),
        ], 'Instructor data fetched successfully');
    }

    public function show()
    {
        return 1;
    }
}
