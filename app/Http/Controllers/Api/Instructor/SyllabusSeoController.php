<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Syllabus;
use App\Models\SyllabusSeo;
use Illuminate\Http\Request;

class SyllabusSeoController extends Controller
{
    public function show($id)
    {
        $syllabus = Syllabus::find($id);

        if (!$syllabus) {
            return response()->json(['message' => 'Syllabus not found for this course'], 404);
        }

        $seo = SyllabusSeo::where('syllabus_id', $id)->select('id','title','description')->first();

        if (!$seo) {
            return response()->json(['message' => 'SEO resource not found'], 404);
        }

        return response()->json([
            'seo' => $seo,
        ]);
    }

    public function store(Request $request, $id)
    {
        $syllabus = Syllabus::find($id);

        if (!$syllabus) {
            return response()->json(['message' => 'Syllabus not found for this course'], 404);
        }

        $seo = $syllabus->seo()->updateOrCreate($request->all());

        return response()->json([
            'message' => 'Resource created successfully',
            'seo' => $seo,
        ], 201);
    }
}
