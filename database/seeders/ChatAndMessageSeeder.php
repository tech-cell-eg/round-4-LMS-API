<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use App\Models\Instructor;
use Illuminate\Database\Seeder;

class ChatAndMessageSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::take(5)->get();
        $instructors = Instructor::take(5)->get();

        foreach ($students as $student) {
            foreach ($instructors as $instructor) {
                $chat = Chat::firstOrCreate([
                    'user_id' => $student->id,
                    'instructor_id' => $instructor->id,
                ]);

                Message::create([
                    'chat_id' => $chat->id,
                    'senderable_id' => $student->id,
                    'senderable_type' => get_class($student),
                    'message' => 'Hello, I have a question about your course.',
                ]);

                Message::create([
                    'chat_id' => $chat->id,
                    'senderable_id' => $instructor->id,
                    'senderable_type' => get_class($instructor),
                    'message' => 'Sure! How can I help you?',
                ]);
            }
        }
    }
}
