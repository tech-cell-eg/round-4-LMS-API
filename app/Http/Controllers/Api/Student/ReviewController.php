<?php

namespace App\Http\Controllers\Api\Student;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Course;
use App\Models\Review;

class ReviewController extends Controller
{
    // Show all reviews for a course
    public function index($courseId)
    {
        $course = Course::findOrFail($courseId);

        $reviews = $course->reviews()->get();

        if ($reviews->isNotEmpty()) {
            return ApiResponse::sendResponse(ReviewResource::collection($reviews), 'Reviews retrieved successfully.');
        }
        return ApiResponse::sendResponse([], 'Reviews not found.');
    }


    public function store(ReviewRequest $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        $data = $request->validated();


        $data['user_id'] = auth()->id();
        $data['reviewable_id'] = $course->id;
        $data['reviewable_type'] = Course::class;

        $review = Review::create($data);

        return ApiResponse::sendResponse(new ReviewResource($review), 'Review created successfully.', 201);
    }

    // Show a specific review for a course
    public function show($courseId, $reviewId)
    {
        $course = Course::findOrFail($courseId);
        $review = $course->reviews()->findOrFail($reviewId);

        return ApiResponse::sendResponse(new ReviewResource($review), 'Review retrieved successfully.');
    }

    public function update(ReviewRequest $request, $courseId, $reviewId){
        $course = Course::findOrFail($courseId);
        $review = $course->reviews()->findOrFail($reviewId);

        if (auth()->id() !== $review->user_id) {
            return ApiResponse::sendError([], "You aren't allowed to take this action", 403);
        }

        $data = $request->validated();
        $review->update($data);

        return ApiResponse::sendResponse(new ReviewResource($review), 'Review updated successfully.');

    }


    public function destroy($courseId, $reviewId){
        $course = Course::findOrFail($courseId);
        $review = $course->reviews()->findOrFail($reviewId);

        if (auth()->id() !== $review->user_id) {
            return ApiResponse::sendResponse( [], 'You aren\'t allowed to take this action', 403);
        }

        $review->delete();

        return ApiResponse::sendResponse(null, 'Review deleted successfully.');
    }


}
