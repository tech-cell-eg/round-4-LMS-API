<?php

namespace App\Http\Controllers\Api\Student;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\TopInstructorsResource;
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

        $userId = auth()->id();

        if (!$userId) {
            return response()->json([
                'message' => 'User must be logged in to submit a review'
            ], 401);
        }

        // تحقق هل المستخدم قيم سابقًا
        $existingReview = $instructor->reviews()
            ->where('user_id', $userId)
            ->first();

        if ($existingReview) {
            // تحديث التقييم السابق
            $existingReview->update([
                'rating'  => $request->rating,
                'comment' => $request->comment,
            ]);

            return response()->json([
                'message' => 'Review updated successfully'
            ], 200);
        }

        // إذا لم يكن هناك تقييم سابق، أنشئ تقييم جديد
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
            ->with(['courses.enrollments'])  // لتحميل علاقات الطلاب مع الكورسات
            ->orderByDesc('reviews_avg_rating')
            ->get();

        return ApiResponse::sendResponse(
            TopInstructorsResource::collection($instructors),
            'Top instructors fetched successfully'
        );
    }



    public function showInstructorCourses($instructorId)
    {
        $instructor = Instructor::find($instructorId);

        if (!$instructor) {
            return ApiResponse::sendResponse([], 'Instructor not found', 404);
        }

        $courses = $instructor->courses()->with([
            'reviews',
            'syllabuses.lessons',
            'instructor'
        ])->get();

        if ($courses->isEmpty()) {
            return ApiResponse::sendResponse([], 'No courses found for this instructor', 404);
        }

        return ApiResponse::sendResponse(
            CourseResource::collection($courses),
            'Courses retrieved successfully'
        );
    }
}
