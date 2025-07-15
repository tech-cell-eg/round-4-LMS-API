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
    'slug' => $this->faker->unique()->slug,
    'category_id' => Category::factory(),
    'instructor_id' => Instructor::factory(),
    'title' => $this->faker->sentence,
    'image' => $this->faker->imageUrl(),
    'overview' => $this->faker->paragraph,
    'description' => $this->faker->text,
    'certifications' => $this->faker->sentence,
    'languages' => ['ar', 'en'],
    'levels' => $this->faker->numberBetween(1, 3),
    'price' => $this->faker->randomFloat(2, 100, 1000),
    'discount' => $this->faker->randomFloat(2, 0, 50),
    'tax' => $this->faker->randomFloat(2, 0, 15),
];
    }
}
