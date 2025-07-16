<?php

namespace App\Http\Controllers\api\instructor;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseReviewResource;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorCourseReviewsController extends Controller
{
    public function index()
    {

        $instructor = Auth::user();

        $courseIds = $instructor->courses()->pluck('id');

        $reviews = Review::where('reviewable_type', Course::class)
            ->whereIn('reviewable_id', $courseIds)
            ->with('user', 'reviewable')->get();

        if (count($reviews) > 0) {
            return ApiResponse::sendResponse(CourseReviewResource::collection($reviews), 'Reviews Found');
        }
        return ApiResponse::sendError([], 'Reviews Not Found');

    }


    public function ratingSummary()
    {
        $instructor = Auth::user();

        $courseIds = $instructor->courses()->pluck('id');

        $ratings = [];
        $totalReviews = 0;
        for ($star = 1; $star <= 5; $star++) {
            $count = Review::where('reviewable_type', Course::class)
                ->whereIn('reviewable_id', $courseIds)
                ->where('rating', $star)
                ->count();

            $ratings[$star] = $count;
            $totalReviews += $count;
        }

        return ApiResponse::sendResponse(['ratings' => $ratings, 'total_reviews' => $totalReviews], 'Rating summary retrieved successfully');
    }


}
