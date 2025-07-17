<?php

namespace App\Http\Controllers\Api\Student;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentProfileRequest;
use App\Http\Resources\StudentProfileResource;

class StudentProfileController extends Controller
{

    public function show(){
        $user = auth()->user();

        return ApiResponse::sendResponse(new StudentProfileResource($user), 'Student profile retrieved successfully.');
    }


    public function update(UpdateStudentProfileRequest $request)
    {
        $user = auth()->user();

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
            $data['image'] = $imagePath;
        }

        $user->update($data);

        return ApiResponse::sendResponse(new StudentProfileResource($user), 'Profile updated successfully.');

    }
}
