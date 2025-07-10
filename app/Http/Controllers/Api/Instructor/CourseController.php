<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
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

}
