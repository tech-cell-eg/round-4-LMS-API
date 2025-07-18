<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstructorNotificationController extends Controller
{
    public function index()
    {
        $instructor = auth()->user();

        if (!$instructor) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $notifications = $instructor->notifications->map(function ($notification) {;
            return $notification->data + [
                'id' => $notification->id
            ];
        });

        return response()->json([
            'data' => $notifications,
            'message' => 'Notifications retrieved successfully.'
        ]);
    }
}
