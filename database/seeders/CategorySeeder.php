<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    $categories = [
        [
            'title' => 'Web Development',
            'description' => 'All about building websites and web applications.',
        ],
        [
            'title' => 'Mobile Apps',
            'description' => 'Creating apps for iOS and Android platforms.',
        ],
        [
            'title' => 'Data Science',
            'description' => 'Data analysis, machine learning, and AI topics.',
        ],
        [
            'title' => 'Design',
            'description' => 'UI/UX, graphic design, and creative arts.',
        ],
        [
            'title' => 'Marketing',
            'description' => 'Digital marketing, SEO, and advertising strategies.',
        ],
        [
            'title' => 'Cybersecurity',
            'description' => 'Protecting systems and networks from digital attacks.',
        ],
    ];

    foreach ($categories as $category) {
        Category::firstOrCreate(
            ['title' => $category['title']],  // شرط البحث
            [
                'slug' => Str::slug($category['title']),
                'description' => $category['description'],
            ]
        );
    }
}

}
