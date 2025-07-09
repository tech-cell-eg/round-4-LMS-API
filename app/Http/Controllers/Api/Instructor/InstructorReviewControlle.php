<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Instructor;
use App\Models\Review;

class InstructorReviewControlle extends Controller
{
    public function index($id)
    {

        $instructor = Instructor::findOrFail($id);

        $reviews = Review::where([
            'reviewable_type' => Instructor::class,
            'reviewable_id' => $instructor->id,
        ])->paginate(4);

        return ApiResponse::sendResponse(ReviewResource::collection($reviews), 'Reviews retrieved successfully.');

    }
}
