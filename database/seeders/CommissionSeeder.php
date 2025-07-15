<?php

namespace Database\Seeders;

use App\Models\Commission;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class CommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructor = Instructor::first();
        $course     = Course::first();

        if (!$instructor || !$course) {
            $this->command->warn('You need at least one Instructor and one Course in the database before running this seeder.');
            return;
        }

        // إضافة 12 عمولة واحدة لكل شهر
        foreach (range(1, 12) as $month) {
            $payment = Payment::inRandomOrder()->first(); // دفع عشوائي

            Commission::create([
                'instructor_id' => $instructor->id,
                'course_id'     => $course->id,
                'payment_id'    => $payment->id,
                'amount'        => rand(100, 1000),
                'status'        => ['pending', 'received'][rand(0, 1)],
                'created_at'    => now()->startOfYear()->addMonths($month - 1),
                'updated_at'    => now(),
            ]);
        }

        $this->command->info('Commissions seeded successfully with random payments.');
    }
}
