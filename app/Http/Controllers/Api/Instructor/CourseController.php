<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\CartItem;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Syllabus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class CourseController extends Controller
{
    public function show($slug)
    {
        $course = Course::with(['instructor', 'syllabuses.lessons', 'reviews.user', 'enrollments'])
            ->where('slug', $slug)
            ->firstOrFail();

        return new CourseResource($course);
    }
    //Create course by instructor and should assign to category.
    public function store(Request $request)
{
    $validated = validator($request->all(), [
        'instructor_id' => 'required|exists:instructors,id',
        'category_id'   => 'required|exists:categories,id',
        'title'         => 'required|string',
        'slug'          => 'required|unique:courses,slug',
        'overview'      => 'nullable|string',
        'description'   => 'nullable|string',
        'price'         => 'nullable|numeric',
    ]);

    if ($validated->fails()) {
        return response()->json([
            'status'  => false,
            'message' => 'Validation failed',
            'errors'  => $validated->errors()
        ], 422);
    }

    $course = Course::create($validated->validated());

    return response()->json([
        'status'  => true,
        'message' => 'Course created successfully',
        'course'  => $course
    ], 201);
}




// make api to get courses related with an instructor (courses by instructor id)
    public function DashboardInstructorCourses($instructorId)
{
    if (!Instructor::where('id', $instructorId)->exists()) {
        return response()->json([
            'status' => false,
            'message' => 'Instructor not found.',
        ], 404);
    }

    $courses = Course::with([
        'syllabuses.lessons',
        'enrollments',
        'reviews'
    ])->where('instructor_id', $instructorId)->get();

    if ($courses->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'No courses found for this instructor.',
        ], 404);
    }

    $data = $courses->map(function ($course) {
        return [
            'title'           => $course->title,
            'price'           => $course->price == 0 ? 'Free' : '$' . number_format($course->price, 2),
            'chapters'        => $course->syllabuses->count(),
            'orders'          => $course->enrollments->count(),
            'certificates'    => $course->certifications,
            'reviews_count'   => $course->reviews->count(),
            'added_to_shelf'  => CartItem::where('course_id', $course->id)->count(),
        ];
    });
    return response()->json([
        'status'  => true,
        'courses' => $data,
    ]);
}

public function chapter()
{
    try {
        $user = Auth::user();

        if (!$user instanceof Instructor) {
            return response()->json(['status' => false, 'message' => 'Unauthorized or not an instructor.'], 403);
        }

        $chapters = Syllabus::with('course')
            ->whereHas('course', function ($query) use ($user) {
                $query->where('instructor_id', $user->id);
            })
            ->get()
            ->map(function ($chapter) {
                return [
                    'id'        => $chapter->id,
                    'order_id'  => $chapter->order ?? null,
                    'chapter'   => $chapter->chapter ?? null,
                    'title'     => $chapter->title,
                    'type'      => 'student',
                    'date'      => $chapter->created_at->toDateString(),
                    'status'    => $chapter->status,
                    'price'     => $chapter->course->price ?? 0,
                ];
            });

        return response()->json(['status' => true, 'chapters' => $chapters]);

    } catch (Throwable $e) {
        return response()->json(['status' => false, 'message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
    }
}

    public function chapterdetails($id)
{
    try {
        $user = Auth::user();

        if (!$user instanceof Instructor) {
            return response()->json(['status' => false, 'message' => 'Unauthorized or not an instructor.'], 403);
        }

        $chapter = Syllabus::with('course')->findOrFail($id);
        $data = [
            'title'       => $chapter->title,
            'subtitle'    => $chapter->subtitle,
            'description' => $chapter->description,
        ];

        return response()->json(['status' => true, 'chapter' => $data]);

    } catch (ModelNotFoundException $e) {
        return response()->json(['status' => false, 'message' => 'Chapter not found.'], 404);
    } catch (Throwable $e) {
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function destroy($id)
{
    try {
        $user = Auth::user();

        if (!$user instanceof Instructor) {
            return response()->json(['status' => false, 'message' => 'Unauthorized or not an instructor.'], 403);
        }

        $chapter = Syllabus::with('course')->findOrFail($id);
        $chapter->delete();

        return response()->json(['status' => true, 'message' => 'Chapter deleted successfully.']);

    } catch (ModelNotFoundException $e) {
        return response()->json(['status' => false, 'message' => 'Chapter not found.'], 404);
    } catch (Throwable $e) {
        return response()->json(['status' => false, 'message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
    }
    }

    public function toggleStatus($id)
    {
        try {
            $user = Auth::user();

            if (!$user instanceof Instructor) {
                return response()->json(['status' => false, 'message' => 'Unauthorized or not an instructor.'], 403);
            }

            $chapter = Syllabus::with('course')->findOrFail($id);

            $oldStatus = $chapter->status;
            $chapter->status = $oldStatus === 'published' ? 'draft' : 'published';
            $chapter->save();

            return response()->json([
                'status'  => true,
                'message' => "Chapter status updated from $oldStatus to {$chapter->status}",
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => false, 'message' => 'Chapter not found.'], 404);
        } catch (Throwable $e) {
            return response()->json(['status' => false, 'message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

}