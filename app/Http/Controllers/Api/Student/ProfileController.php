<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnrolledCoursesResource;
use App\Http\Resources\InstructorProfileResource;
use App\Http\Resources\UserReviewsResource;

class ProfileController extends Controller
{
    public function myCourses()
    {
        $user = auth()->user();
        $courses = $user->enrollments()->with(['course.instructor', 'course.syllabuses.lessons'])->get();

        if ($courses->isEmpty()) {
            return response()->json([
                'message' => 'No courses found for this user',
                'courses' => [],
            ], 200);
        }

        return response()->json([
            'message' => 'Courses retrieved successfully',
            'courses' =>  EnrolledCoursesResource::collection($courses),
        ], 200);

    }

    public function myInstructors()
    {
        $user = auth()->user();
        $instructors = $user->enrollments()->with('course.instructor')->get()
            ->pluck('course.instructor')
            ->unique('id');

        if ($instructors->isEmpty()) {
            return response()->json([
                'message' => 'No instructors found for this user',
                'instructors' => [],
            ], 200);
        }

        return response()->json([
            'message' => 'Instructors retrieved successfully',
            'instructors' =>InstructorProfileResource::collection($instructors),
        ], 200);
    }

    public function myReviews()
    {
        $user = auth()->user();
        $reviews = $user->reviews()->with('reviewable')->latest()->get();

        if ($reviews->isEmpty()) {
            return response()->json([
                'message' => 'No reviews found for this user',
            ], 200);
        }

        return response()->json([
            'message' => 'Reviews retrieved successfully',
            'reviews' => UserReviewsResource::collection($reviews),
        ], 200);
    }

    public function myChats()
    {
        $user = auth()->user();
        $chats = $user->chat_courses_with_instructors;
        if ($chats->isEmpty()) {
            return response()->json([
                'message' => 'No chats found for this user',
                'chats' => [],
            ], 200);
        }

        $chats = $chats->map(function ($chat) {
            return [
                'id' => $chat->id,
                'instructor' => $chat->instructor->first_name . ' ' . $chat->instructor->last_name,
                'last_message' => $chat->messages->last()?->message,
                'date_time' => $chat->created_at->toDateTimeString(),
            ];
        });

        return response()->json([
            'message' => 'Chats retrieved successfully',
            'chats' => $chats,
        ], 200);
    }
    public function getMessages($chatId)
    {
        $user = auth()->user();
        $chat = $user->chats()->with(['messages.senderable'])->find($chatId);

        if (!$chat) {
            return response()->json([
                'message' => 'Chat not found',
            ], 200);
        }

        $messages = $chat->messages->map(function ($message) {
            return [
                'id' => $message->id,
                'sender' => $message->senderable->first_name . ' ' . $message->senderable->last_name,
                'image' => $message->senderable->image ?? null,

                'is_me' => $message->senderable->id === auth()->id() && $message->senderable_type === \App\Models\User::class,

                'message' => $message->message,
                'date_time' => $message->created_at->toDateTimeString(),
            ];

        });

        return response()->json([
            'message' => 'Messages retrieved successfully',
            'messages' => $messages,
        ], 200);
    }
}
