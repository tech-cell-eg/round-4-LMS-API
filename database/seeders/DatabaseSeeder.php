<?php

namespace Database\Seeders;

use App\Models\Instructor;
use App\Models\Payment;
use App\Models\User;
use App\Models\Course;
use App\Models\Coupon;
use App\Models\CouponRedemption;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->count(5)->create(); // Adding fake students before the Reviews

        $this->call([
            CategorySeeder::class,
            InstructorSeeder::class,
            CourseSeeder::class,
            SyllabusSeeder::class,
            LessonSeeder::class,
            ReviewSeeder::class,
            EnrollmentAndDoneLessonSeeder::class,
            ChatAndMessageSeeder::class,
            SocialSeeder::class,
        ]);


        Coupon::factory(15)->create();
        CouponRedemption::factory(30)->create();

    }
}
