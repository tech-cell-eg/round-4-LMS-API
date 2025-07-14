<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\CartItem;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show($slug)
    {
        $course = Course::with(['instructor', 'syllabuses.lessons', 'reviews.user', 'enrollments'])
            ->where('slug', $slug)
            ->firstOrFail();

        return new CourseResource($course);
    }
    //Create course by instructor and should assign to category.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'instructor_id' => 'required|exists:instructors,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string',
            'slug' => 'required|unique:courses,slug',
            'overview' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'numeric',
        ]);
        $course = Course::create($validated);
        return response()->json([
            'message' => 'Course created successfully',
            'course' => $course
        ]);
    }



// make api to get courses related with an instructor (courses by instructor id)
     public function DashboardInstructorCourses($instructorId)
    {
        $courses = Course::with([
            'syllabuses.lessons',
            'enrollments',
            'reviews'
        ])->where('instructor_id', $instructorId)->get();

        if ($courses->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No courses found for this instructor.',
            ], 404);
        }
        $data = $courses->map(function ($course) {
            return [
                'title' => $course->title,
                'price' => $course->price == 0 ? 'Free' : '$' . number_format($course->price, 2),
                'chapters' => $course->syllabuses->count(),
                'orders' => $course->enrollments->count(),
                'certificates' => $course->certifications,
                'reviews_count' => $course->reviews->count(),
                'added_to_shelf' => CartItem::where('course_id', $course->id)->count(),
            ];
        });
        return response()->json([
            'status' => true,
            'courses' => $data,
        ]);
    }

}
