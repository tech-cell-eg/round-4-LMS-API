<?php

namespace Database\Seeders;

use App\Models\Instructor;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Social;

class SocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $instructors =  Instructor::all();

        foreach ($users as $user) {
            Social::create([
                'sociable_id' => $user->id,
                'sociable_type' => User::class,
                'website' => 'https://userwebsite.com/' . $user->username,
                'facebook' => 'https://facebook.com/' . $user->username,
                'x' => 'https://x.com/' . $user->username,
                'linkedin' => 'https://linkedin.com/in/' . $user->username,
                'youtube' => null,
            ]);
        }

        foreach ($instructors as $instructor) {
            Social::create([
                'sociable_id' => $instructor->id,
                'sociable_type' => Instructor::class,
                'website' => 'https://instructorwebsite.com/' . $instructor->username,
                'facebook' => 'https://facebook.com/' . $instructor->username,
                'x' => 'https://x.com/' . $instructor->username,
                'linkedin' => 'https://linkedin.com/in/' . $instructor->username,
                'youtube' => 'https://youtube.com/' . $instructor->username,
            ]);
        }
    }
}
