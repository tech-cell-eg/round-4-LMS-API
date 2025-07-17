<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Events\NewMessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Http\Request;

class InstructorChatController extends Controller
{
    public function chats()
    {
        $instructor = auth()->user();
        $chats = $instructor->chats;
        if ($chats->isEmpty()) {
            return response()->json([
                'message' => 'No chats found for this user',
                'chats' => [],
            ], 200);
        }

        $chats = $chats->map(function ($chat) {
            return [
                'id' => $chat->id,
                'student' => $chat->user->first_name . ' ' . $chat->user->last_name,
                'last_message' => $chat->messages->last()?->message,
                'date_time' => $chat->created_at->toDateTimeString(),
            ];
        });

        return response()->json([
            'message' => 'Chats retrieved successfully',
            'chats' => $chats,
        ], 200);
    }

    public function messages($chatId)
    {
        $instructor = auth()->user();
        $chat = $instructor->chats()->with(['messages.senderable'])->find($chatId);

        if (!$chat) {
            return response()->json([
                'message' => 'Chat not found',
            ], 200);
        }

        $messages = $chat->messages->map(function ($message) {
            return [
                'id' => $message->id,
                'sender' => $message->senderable->first_name . ' ' . $message->senderable->last_name,
                'image' => $message->senderable->image ?  asset('storage/' . $message->senderable->image) : null,
                'is_me' => $message->senderable->id === auth()->id() && $message->senderable_type === Instructor::class,
                'message' => $message->message,
                'date_time' => $message->created_at->toDateTimeString(),
            ];

        });

        return response()->json([
            'message' => 'Messages retrieved successfully',
            'messages' => $messages,
        ], 200);
    }

    public function sendMessage(Request $request, $studentUsername)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $instructor = auth()->user();

        $user = User::where('username',$studentUsername)->first();

        $chat = Chat::firstOrCreate([
            'user_id' => $user->id,
            'instructor_id' => $instructor->id,
        ]);

        $message = $chat->messages()->create([
            'senderable_id' => $instructor->id,
            'senderable_type' => Instructor::class,
            'message' => $request->message,
        ]);

        $data = [
            'id' => $message->id,
            'chat_id' => $chat->id,
            'sender' => $instructor->first_name . ' ' . $instructor->last_name,
            'image' => $instructor->image ?? null,
            'is_me' => true,
            'message' => $message->message,
            'date_time' => $message->created_at->toDateTimeString(),
        ];

        event(new NewMessageEvent($data));

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $data,
        ], 201);
    }

}
