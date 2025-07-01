<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    // تحديد الموديل المرتبط بالفاتوري
    protected $model = User::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'headline' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(),
            'image' => null, // يمكن وضع رابط صورة هنا أو تركها null
            'languages' => json_encode([
                $this->faker->languageCode(),
                $this->faker->languageCode(),
                $this->faker->languageCode(),
            ]),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // كلمة مرور افتراضية مشفرة
            'remember_token' => Str::random(10),
        ];
    }
}
