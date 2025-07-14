<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Course;
use App\Models\CreditCard;
use App\Models\Instructor;
use App\Models\Payment;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
<<<<<<< HEAD

        User::factory()->count(5)->create();

        Instructor::factory()->count(5)->create();
=======
>>>>>>> c33082e1a49e567a867010d4e02f2485d3162cdc

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

<<<<<<< HEAD
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ])->withoutOverwriting();

        // Remove merge conflict markers and keep only the intended seeding logic.
        User::factory()->count(5)->create();
        Instructor::factory()->count(5)->create();
        Cart::factory()->count(5)->create();
        CartItem::factory()->count(5)->create();
        Payment::factory()->count(5)->create();
        CreditCard::factory()->count(5)->create();


        $this->call([
            CategorySeeder::class,
            InstructorSeeder::class,
            CourseSeeder::class,
            SyllabusSeeder::class,
            LessonSeeder::class,
            ReviewSeeder::class,
        ]);

        // Optionally, add more seeders as needed:
        // $this->call([
        //     EnrollmentAndDoneLessonSeeder::class,
        //     ChatAndMessageSeeder::class,
        //     SocialSeeder::class,
        // ]);

        // Example of creating a specific user:
        // User::factory()->create([
        //     'first_name' => 'Test',
        //     'last_name' => 'User',
        //     'username' => 'testuser',
        //     'email' => 'test@example.com',
        // ]);
=======
>>>>>>> c33082e1a49e567a867010d4e02f2485d3162cdc
    }
}
