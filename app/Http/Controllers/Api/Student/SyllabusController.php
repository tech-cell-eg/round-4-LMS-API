<?php

namespace App\Http\Controllers\Api\Student;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SyllabusResource;
use App\Models\Course;

class SyllabusController extends Controller
{
    public function index($id)
    {

        $course = Course::findOrFail($id);

        $syllabuses = $course->syllabuses()->get();

        if ($syllabuses) {
            return ApiResponse::sendResponse(SyllabusResource::collection($syllabuses), 'Syllabus retrieved successfully.');
        }
        return ApiResponse::sendResponse([], 'Syllabus not found.');
    }

}
