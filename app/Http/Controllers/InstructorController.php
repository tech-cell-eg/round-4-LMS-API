<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\InstructorResource;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{

    public function store(Request $request, $instructor_id)
    {
        $request->validate([
            'rating'  => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $instructor = Instructor::findOrFail($instructor_id);

        $userId = 2;
                    
        $alreadyReviewed = $instructor->reviews()
            ->where('user_id', $userId)
            ->exists();

        if ($alreadyReviewed) {
            return response()->json([
                'message' => 'You have already reviewed this instructor'
            ], 409);
        }

        $instructor->reviews()->create([
            'user_id' => $userId,
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Review created successfully'
        ], 201);
    }


    public function index($instructorId)
    {
        $instructor = Instructor::findOrFail($instructorId);

        $reviews = $instructor->reviews()
            ->with('user')
            ->latest()
            ->get();

        return response()->json([
            'average_rating' => round($instructor->reviews()->avg('rating'), 2),
            'reviews' => $reviews
        ]);
    }

    public function topInstructors()
    {
        $instructors = Instructor::withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->get();

        return response()->json([
            'top_instructors' => InstructorResource::collection($instructors),
        ]);
    }

    public function showInstructorCourses($instructorId)
    {
        $instructor = Instructor::findOrFail($instructorId);

        $courses = $instructor->courses()->with([
            'reviews',
            'syllabuses.lessons',  // يجب تحميل الدروس مع السيلابوسز
            'instructor'
        ])->get();

        if ($courses->isEmpty()) {
            return response()->json([
                'message' => 'No courses found for this instructor'
            ], 404);
        }

        return CourseResource::collection($courses);
    }
}
