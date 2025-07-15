<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Resources\syllabusResourcesResource;
use App\Models\Course;
use App\Models\Syllabus;
use App\Models\SyllabusResource;
use Illuminate\Http\Request;

class SyllabusResourcesController extends Controller
{
    public function show($id)
    {
        $syllabus = Syllabus::find($id);

        if (!$syllabus) {
            return response()->json(['message' => 'Syllabus not found for this course'], 404);
        }

        $resource = SyllabusResource::where('syllabus_id', $id)->first();

        if (!$resource) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        return response()->json([
            'resources' => new SyllabusResourcesResource($resource),
        ]);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $syllabus = Syllabus::find($id);

        if (!$syllabus) {
            return response()->json(['message' => 'Syllabus not found for this course'], 404);
        }

        $data = [
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
        ];

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('syllabus_files', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $request->file('thumbnail')->store('syllabus_thumbnails', 'public');
        }

        $resource = $syllabus->resources()->updateOrCreate($data);

        return response()->json([
            'message' => 'Syllabus resource created successfully',
            'resource' => new SyllabusResourcesResource($resource),
        ], 201);
    }
}
