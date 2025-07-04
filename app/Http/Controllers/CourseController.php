<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;

class CourseController extends Controller
{
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

    // Show all courses
    public function index()
    {
        $courses = Course::with('category')->get();
        return response()->json($courses);
    }

//API to fetch courses filtered by specific category
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
        $courses = Course::where('category_id', $category->id)->get();
        return response()->json([
            'status' => true,
            'category' => $category->title,
            'courses' => $courses
        ]);
    }

    //API to fetch complete details of a single course
    public function show($id)
    {
        $course = Course::with('syllabuses.lessons')->findOrFail($id);
        return response()->json([
            'status' => true,
            'course' => $course,
        ]);
    }

}
