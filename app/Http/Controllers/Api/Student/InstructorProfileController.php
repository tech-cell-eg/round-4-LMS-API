<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstructorProfileResource;
use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorProfileController extends Controller
{
    /**
     * Display the instructor's profile.
     *
     */

    public function show($instructorUsername)
    {
        $instructor = Instructor::with(['courses.enrollments', 'reviews', 'social'])
            ->where('username', $instructorUsername)
            ->firstOrFail();

        if (!$instructor) {
            return response()->json([
                'message' => 'Instructor not found'
            ], 404);
        }


        return response()->json([
        new InstructorProfileResource($instructor)
        ], 200);

    }
}
