<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    /**
     * Store a new review for the instructor.
     */
    public function store(Request $request, $instructor_id)
    {
        $request->validate([
            'rating'  => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $instructor = Instructor::findOrFail($instructor_id);

        // مؤقتًا نستخدم user_id = 1 إلى أن يتم تفعيل المصادقة
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

    /**
     * Display a list of reviews for the instructor.
     */
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
        $instructors = Instructor::withAvg('reviews', 'rating')  // يحسب متوسط تقييمات كل مدرب
            ->orderByDesc('reviews_avg_rating')                  // يرتب حسب متوسط التقييم تنازليًا
            ->get();

        return response()->json([
            'top_instructors' => $instructors,
        ]);
    }
}
