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
        Category::create([
            'title'       => 'Web Development',
            'slug'        => Str::slug('Web Development'),
            'description' => 'All about building websites and web applications.',
        ]);

        Category::create([
            'title'       => 'Mobile Apps',
            'slug'        => Str::slug('Mobile Apps'),
            'description' => 'Creating apps for iOS and Android platforms.',
        ]);

        Category::create([
            'title'       => 'Data Science',
            'slug'        => Str::slug('Data Science'),
            'description' => 'Data analysis, machine learning, and AI topics.',
        ]);

        Category::create([
            'title'       => 'Design',
            'slug'        => Str::slug('Design'),
            'description' => 'UI/UX, graphic design, and creative arts.',
        ]);

        Category::create([
            'title'       => 'Marketing',
            'slug'        => Str::slug('Marketing'),
            'description' => 'Digital marketing, SEO, and advertising strategies.',
        ]);

        Category::create([
            'title'       => 'Cybersecurity',
            'slug'        => Str::slug('Cybersecurity'),
            'description' => 'Protecting systems and networks from digital attacks.',
          
         ]);
     }       

}
