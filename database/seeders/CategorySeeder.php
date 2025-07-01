<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    public function run(): void
    {
        Category::create([
            'title' => 'Programming',
            'slug' => 'programming',
            'description' => 'All about programming.'
        ]);

        Category::create([
            'title' => 'Web Development',
            'slug' => 'web-development',
            'description' => 'All about web development.'
        ]);
    }
}
