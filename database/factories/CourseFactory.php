<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
   return [
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->slug(),
            'category_id' => Category::factory(), // ينشئ صنف جديد تلقائيًا ويربطه
            'instructor_id' => Instructor::factory(),
            'overview' => $this->faker->paragraph(),
            'description' => $this->faker->text(),
            'certifications' => $this->faker->words(3, true),
            'languages' => ['English', 'Arabic'],
            'levels' => $this->faker->numberBetween(0, 2), // مثلاً 0: مبتدئ، 1: متوسط، 2: متقدم
            'price' => $this->faker->randomFloat(2, 0, 200),
            'discount' => $this->faker->randomFloat(2, 0, 50),
            'tax' => $this->faker->randomFloat(2, 0, 20),
            'image' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
