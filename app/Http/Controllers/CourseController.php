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
            'category_id'   => 'required|exists:categories,id',
            'title'         => 'required|string',
            'slug'          => 'required|unique:courses,slug',
            'overview'      => 'nullable|string',
            'description'   => 'nullable|string',
            'price'         => 'numeric',
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
    $courses = Course::with(['category', 'instructor', 'reviews', 'syllabuses.lessons'])->get();
    $formattedCourses = [];
    foreach ($courses as $course) {
        $instructor = $course->instructor;

        $instructorName = $instructor ? $instructor->first_name . ' ' . $instructor->last_name : 'Unknown';
        $instructorHeadline = $instructor ? $instructor->headline : null;

        $lessons = $course->syllabuses->flatMap->lessons;
        $totalDuration = $lessons->sum('duration'); // in minutes
        $lectureCount = $lessons->count();

        $ratingCount = $course->reviews->count();
        $averageRating = $ratingCount > 0 ? round($course->reviews->avg('rating'), 1) : 0;

        $formattedCourses[] = [
            'title'             => $course->title,
            'price'             => round($course->price, 2),
            'level'             => $this->mapLevel($course->levels), // convert number to text
            'image'             => $course->image,
            'overview'          => $course->overview,
            'category'          => $course->category->name ?? 'Unknown',
            'instructor_name'   => $instructorName,
            'instructor_headline' => $instructorHeadline,
            'average_rating'    => $averageRating,
            'rating_count'      => $ratingCount,
            'total_hours'       => round($totalDuration / 60, 2),
            'lectures'          => $lectureCount,
        ];
    }
    return response()->json($formattedCourses);
    }
        private function mapLevel($level)
    {
        return match($level) {
            0 => 'Beginner',
            1 => 'Intermediate',
            2 => 'Advanced',
            default => 'All Levels',
        };
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
    $course = Course::with('syllabuses.lessons'  )->findOrFail($id);
    return response()->json([
        'status' => true,
        'course' => $course,
    ]);
}

}
