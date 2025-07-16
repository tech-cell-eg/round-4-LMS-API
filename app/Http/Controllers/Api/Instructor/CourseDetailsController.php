<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseDetailsResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseDetailsController extends Controller
{
    public function saveAsDraft(Request $request, $id)
    {
        $instructor = Auth::user();
        $course = Course::where('instructor_id', $instructor->id)->findOrFail($id);

        $course->update(['status' => 'draft',]);

        return ApiResponse::sendResponse(new CourseDetailsResource($course), 'Course saved as draft');
    }

    public function publish(Request $request, $id)
    {
        $instructor = Auth::user();
        $course = Course::where('instructor_id', $instructor->id)->findOrFail($id);

        $course->update(['status' => 'published']);

        return ApiResponse::sendResponse(new CourseDetailsResource($course), 'Course published successfully');
    }

    public function update(Request $request, $id)
    {
        $instructor = Auth::user();
        $course = Course::where('instructor_id', $instructor->id)->findOrFail($id);

        $course->update($request->only([
            'title', 'price', 'description', 'languages', 'levels', 'image', 'video'
        ]));

        return ApiResponse::sendResponse(new CourseDetailsResource($course), 'Course updated successfully');
    }
}
