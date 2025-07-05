<?php

namespace Database\Factories;

use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InstructorFactory extends Factory
{
    protected $model = Instructor::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // كلمة المرور الافتراضية مشفرة
            'email_verified_at' => now(),
            'headline' => $this->faker->sentence(6),
            'about' => $this->faker->paragraph(),
            'image' => null, // أو يمكن وضع رابط صورة عشوائية من faker
            'areas_of_expertise' => json_encode([
                $this->faker->word(),
                $this->faker->word(),
                $this->faker->word()
            ]),
            'experience' => $this->faker->paragraph(),
        ];
    }
}
