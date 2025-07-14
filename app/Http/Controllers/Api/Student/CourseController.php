<?php

namespace App\Http\Controllers\Api\Student;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\InstructorInfoRelatedToCource;
use App\Models\Category;
use App\Models\Course;

class CourseController extends Controller
{

    // Show all courses
 public function index()
    {
        $courses = Course::with(['category', 'instructor', 'reviews', 'syllabuses.lessons'])->get();
        $formattedCourses = $courses->map(function ($course) {
            return $this->formatCourse($course);
        });
        return response()->json([
            'status' => true,
            'courses' => $formattedCourses,
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
        $courses = Course::with(['category', 'instructor', 'reviews', 'syllabuses.lessons'])
            ->where('category_id', $category->id)
            ->get();
        $formattedCourses = $courses->map(function ($course) {
            return $this->formatCourse($course);
        });
        return response()->json([
            'status' => true,
            'category' => $category->title,
            'courses' => $formattedCourses,
        ]);
    }

    public function showCourseDetails($id)
    {
        $course = Course::with(['category', 'instructor', 'reviews', 'syllabuses.lessons'])->find($id);
        if (!$course) {
            return response()->json([
                'status' => false,
                'message' => 'Course not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'course' => $this->formatCourse($course)
        ]);
    }

    private function formatCourse($course)
    {
        $instructor = $course->instructor;
        $instructorName = $instructor ? $instructor->first_name . ' ' . $instructor->last_name : 'Unknown';
        $instructorHeadline = $instructor ? $instructor->headline : null;

        $lessons = $course->syllabuses->flatMap->lessons;
        $totalDuration = $lessons->sum('duration'); // minutes
        $lectureCount = $lessons->count();

        $ratingCount = $course->reviews->count();
        $averageRating = $ratingCount > 0 ? round($course->reviews->avg('rating'), 1) : 0;

        return [
            'title'               => $course->title,
            'price'               => round($course->price, 2),
            'level'               => $this->mapLevel($course->levels),
            'image'               => $course->image,
            'overview'            => $course->overview,
            'category'            => $course->category->name ?? 'Unknown',
            'instructor_name'     => $instructorName,
            'instructor_headline' => $instructorHeadline,
            'average_rating'      => $averageRating,
            'rating_count'        => $ratingCount,
            'total_hours'         => round($totalDuration / 60, 2),
            'lectures'            => $lectureCount,
        ];
    }

    private function mapLevel($level)
    {
        return match ($level) {
            0 => 'Beginner',
            1 => 'Intermediate',
            2 => 'Advanced',
            default => 'All Levels',
        };
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
        'course_id'    => $course->id,
        'course_title' => $course->title,
        'instructor'   => new InstructorInfoRelatedToCource($instructor),
    ], 'Instructor data fetched successfully');
}

}
