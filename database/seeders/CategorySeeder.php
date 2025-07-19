<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Latest smartphones, laptops, tablets, and electronic accessories for modern life',
                'slug' => 'electronics',
                'image' => 'categories/electronics.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Fashion & Clothing',
                'description' => 'Trendy clothing, shoes, and accessories for men, women, and children',
                'slug' => 'fashion-clothing',
                'image' => 'categories/fashion.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Books & Literature',
                'description' => 'Fiction, non-fiction, educational books, and digital reading materials',
                'slug' => 'books-literature',
                'image' => 'categories/books.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Sports & Fitness',
                'description' => 'Athletic wear, fitness equipment, and outdoor sports gear',
                'slug' => 'sports-fitness',
                'image' => 'categories/sports.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Home decor, furniture, kitchen appliances, and gardening supplies',
                'slug' => 'home-garden',
                'image' => 'categories/home.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Toys & Games',
                'description' => 'Educational toys, board games, and entertainment for all ages',
                'slug' => 'toys-games',
                'image' => 'categories/toys.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Health & Beauty',
                'description' => 'Skincare, cosmetics, health supplements, and wellness products',
                'slug' => 'health-beauty',
                'image' => 'categories/beauty.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Automotive',
                'description' => 'Car accessories, tools, and automotive maintenance products',
                'slug' => 'automotive',
                'image' => 'categories/automotive.jpg',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}