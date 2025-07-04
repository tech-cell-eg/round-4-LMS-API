<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show($slug)
    {
        $course = Course::with(['instructor.user', 'syllabuses.lessons', 'reviews.user', 'enrollments'])
            ->where('slug', $slug)
            ->firstOrFail();

        return new CourseResource($course);
    }
}