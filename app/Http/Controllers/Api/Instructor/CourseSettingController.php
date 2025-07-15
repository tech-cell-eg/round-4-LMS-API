<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Course_setting;
use App\Models\CourseSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseSettingController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:open,closed,upcoming',
            'requirements' => 'nullable|string',
            'target_audience' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $courseSetting = Course_setting::updateOrCreate(
            ['course_id' => $course->id],
            [
                'status' => $request->status,
                'requirements' => $request->requirements,
                'target_audience' => $request->target_audience,
            ]
        );

        return response()->json([
            'status' => 200,
            'message' => 'Settings saved for course ID: ' . $course->id,
            'data' => $courseSetting,
        ]);
    }
}
