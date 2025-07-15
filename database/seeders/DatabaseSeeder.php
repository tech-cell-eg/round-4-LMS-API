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
          
        UserSeeder::class,                       // ← لو فيه Admins/Instructors
        CategorySeeder::class,
        InstructorSeeder::class,
        CourseSeeder::class,
        SyllabusSeeder::class,                  // ← course_id
        LessonSeeder::class,                    // ← syllabus_id
        EnrollmentAndDoneLessonSeeder::class,   // ← user_id, course_id, lesson_id
        ReviewSeeder::class,                    // ← user_id, course_id
        ChatAndMessageSeeder::class,            // ← user_id
        CartsSeeder::class,                     // ← user_id
        CartItemsSeeder::class,                 // ← cart_id, course_id
        PaymentsSeeder::class,                  // ← cart_id
        SocialSeeder::class,

        ]);


        Coupon::factory(15)->create();
        CouponRedemption::factory(30)->create();

    }
}
