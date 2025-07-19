<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Electronics
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Latest iPhone with A17 Pro chip, titanium design, and advanced camera system. Perfect for photography and professional use.',
                'price' => 384.996,
                'quantity' => 50,
                'category_slug' => 'electronics',
                'image' => 'products/iphone-15-pro.jpg',
                'slug' => Str::slug('iPhone 15 Pro'),
                'is_active' => true,
            ],
            [
                'name' => 'MacBook Air M2',
                'description' => 'Ultra-thin laptop with M2 chip, 13.6-inch Liquid Retina display, and all-day battery life. Ideal for students and professionals.',
                'price' => 461.996,
                'quantity' => 30,
                'category_slug' => 'electronics',
                'image' => 'products/macbook-air-m2.jpg',
                'slug' => Str::slug('MacBook Air M2'),
                'is_active' => true,
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Premium Android smartphone with AI features, 200MP camera, and S Pen support. Excellence in mobile technology.',
                'price' => 346.496,
                'quantity' => 45,
                'category_slug' => 'electronics',
                'image' => 'products/samsung-galaxy-s24.jpg',
                'slug' => Str::slug('Samsung Galaxy S24'),
                'is_active' => true,
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Industry-leading noise canceling headphones with 30-hour battery life and premium sound quality.',
                'price' => 153.996,
                'quantity' => 25,
                'category_slug' => 'electronics',
                'image' => 'products/sony-headphones.jpg',
                'slug' => Str::slug('Sony WH-1000XM5'),
                'is_active' => true,
            ],

            // Fashion & Clothing
            [
                'name' => 'Nike Air Max 270',
                'description' => 'Comfortable running shoes with Max Air unit and breathable mesh upper. Perfect for daily wear and exercise.',
                'price' => 49.996,
                'quantity' => 60,
                'category_slug' => 'fashion-clothing',
                'image' => 'products/nike-air-max-270.jpg',
                'slug' => Str::slug('Nike Air Max 270'),
                'is_active' => true,
            ],
            [
                'name' => 'Levi\'s 501 Original Jeans',
                'description' => 'Classic straight-leg jeans with the authentic fit and timeless style. Made from premium denim.',
                'price' => 89.99,
                'quantity' => 80,
                'category_slug' => 'fashion-clothing',
                'image' => 'products/levis-501-jeans.jpg',
                'slug' => Str::slug('Levis 501 Original Jeans'),
                'is_active' => true,
            ],
            [
                'name' => 'Patagonia Fleece Jacket',
                'description' => 'Warm and lightweight fleece jacket perfect for outdoor activities. Made from recycled materials.',
                'price' => 159.99,
                'quantity' => 35,
                'category_slug' => 'fashion-clothing',
                'image' => 'products/patagonia-fleece.jpg',
                'slug' => Str::slug('Patagonia Fleece Jacket'),
                'is_active' => true,
            ],

            // Books & Literature
            [
                'name' => 'The Psychology of Money',
                'description' => 'Timeless lessons on wealth, greed, and happiness by Morgan Housel. A must-read for financial wisdom.',
                'price' => 16.99,
                'quantity' => 100,
                'category_slug' => 'books-literature',
                'image' => 'products/psychology-of-money.jpg',
                'slug' => Str::slug('The Psychology of Money'),
                'is_active' => true,
            ],
            [
                'name' => 'Atomic Habits',
                'description' => 'An Easy & Proven Way to Build Good Habits & Break Bad Ones by James Clear. Transform your life one habit at a time.',
                'price' => 14.99,
                'quantity' => 120,
                'category_slug' => 'books-literature',
                'image' => 'products/atomic-habits.jpg',
                'slug' => Str::slug('Atomic Habits'),
                'is_active' => true,
            ],
            [
                'name' => 'Dune: Complete Series',
                'description' => 'Frank Herbert\'s epic science fiction masterpiece. All six books in the original Dune series.',
                'price' => 49.99,
                'quantity' => 40,
                'category_slug' => 'books-literature',
                'image' => 'products/dune-complete-series.jpg',
                'slug' => Str::slug('Dune Complete Series'),
                'is_active' => true,
            ],

            // Sports & Fitness
            [
                'name' => 'Yoga Mat Premium',
                'description' => 'Non-slip yoga mat with excellent grip and cushioning. Perfect for yoga, pilates, and fitness workouts.',
                'price' => 39.99,
                'quantity' => 75,
                'category_slug' => 'sports-fitness',
                'image' => 'products/yoga-mat-premium.jpg',
                'slug' => Str::slug('Yoga Mat Premium'),
                'is_active' => true,
            ],
            [
                'name' => 'Adjustable Dumbbells Set',
                'description' => 'Space-saving adjustable dumbbells with quick-change weight system. Perfect for home workouts.',
                'price' => 299.99,
                'quantity' => 20,
                'category_slug' => 'sports-fitness',
                'image' => 'products/adjustable-dumbbells.jpg',
                'slug' => Str::slug('Adjustable Dumbbells Set'),
                'is_active' => true,
            ],
            [
                'name' => 'Fitness Tracker Watch',
                'description' => 'Advanced fitness tracker with heart rate monitoring, GPS, and 7-day battery life.',
                'price' => 199.99,
                'quantity' => 40,
                'category_slug' => 'sports-fitness',
                'image' => 'products/fitness-tracker.jpg',
                'slug' => Str::slug('Fitness Tracker Watch'),
                'is_active' => true,
            ],

            // Home & Garden
            [
                'name' => 'Instant Pot Duo 7-in-1',
                'description' => 'Multi-functional pressure cooker that replaces 7 kitchen appliances. Perfect for busy families.',
                'price' => 99.99,
                'quantity' => 55,
                'category_slug' => 'home-garden',
                'image' => 'products/instant-pot-duo.jpg',
                'slug' => Str::slug('Instant Pot Duo 7-in-1'),
                'is_active' => true,
            ],
            [
                'name' => 'Dyson V15 Detect',
                'description' => 'Powerful cordless vacuum with laser dust detection and advanced filtration system.',
                'price' => 749.99,
                'quantity' => 15,
                'category_slug' => 'home-garden',
                'image' => 'products/dyson-v15-detect.jpg',
                'slug' => Str::slug('Dyson V15 Detect'),
                'is_active' => true,
            ],
            [
                'name' => 'Smart Thermostat',
                'description' => 'Wi-Fi enabled smart thermostat with energy-saving features and mobile app control.',
                'price' => 199.99,
                'quantity' => 30,
                'category_slug' => 'home-garden',
                'image' => 'products/smart-thermostat.jpg',
                'slug' => Str::slug('Smart Thermostat'),
                'is_active' => true,
            ],

            // Toys & Games
            [
                'name' => 'LEGO Architecture Set',
                'description' => 'Build famous landmarks with this detailed LEGO architecture set. Perfect for display and creativity.',
                'price' => 79.99,
                'quantity' => 45,
                'category_slug' => 'toys-games',
                'image' => 'products/lego-architecture.jpg',
                'slug' => Str::slug('LEGO Architecture Set'),
                'is_active' => true,
            ],
            [
                'name' => 'Nintendo Switch OLED',
                'description' => 'Portable gaming console with vibrant OLED screen and enhanced audio for immersive gaming.',
                'price' => 349.99,
                'quantity' => 25,
                'category_slug' => 'toys-games',
                'image' => 'products/nintendo-switch-oled.jpg',
                'slug' => Str::slug('Nintendo Switch OLED'),
                'is_active' => true,
            ],
            [
                'name' => 'Monopoly Classic',
                'description' => 'The classic property trading board game that brings families together for hours of fun.',
                'price' => 24.99,
                'quantity' => 65,
                'category_slug' => 'toys-games',
                'image' => 'products/monopoly-classic.jpg',
                'slug' => Str::slug('Monopoly Classic'),
                'is_active' => true,
            ],

            // Health & Beauty
            [
                'name' => 'Skincare Routine Kit',
                'description' => 'Complete skincare set with cleanser, toner, serum, and moisturizer for healthy, glowing skin.',
                'price' => 89.99,
                'quantity' => 50,
                'category_slug' => 'health-beauty',
                'image' => 'products/skincare-routine-kit.jpg',
                'slug' => Str::slug('Skincare Routine Kit'),
                'is_active' => true,
            ],
            [
                'name' => 'Electric Toothbrush',
                'description' => 'Rechargeable electric toothbrush with multiple brushing modes and timer for optimal oral health.',
                'price' => 79.99,
                'quantity' => 35,
                'category_slug' => 'health-beauty',
                'image' => 'products/electric-toothbrush.jpg',
                'slug' => Str::slug('Electric Toothbrush'),
                'is_active' => true,
            ],
            [
                'name' => 'Vitamin D3 Supplements',
                'description' => 'High-quality vitamin D3 supplements for bone health and immune system support.',
                'price' => 19.99,
                'quantity' => 80,
                'category_slug' => 'health-beauty',
                'image' => 'products/vitamin-d3-supplements.jpg',
                'slug' => Str::slug('Vitamin D3 Supplements'),
                'is_active' => true,
            ],

            // Automotive
            [
                'name' => 'Car Phone Mount',
                'description' => 'Secure magnetic car phone mount with 360-degree rotation and strong grip.',
                'price' => 24.99,
                'quantity' => 70,
                'category_slug' => 'automotive',
                'image' => 'products/car-phone-mount.jpg',
                'slug' => Str::slug('Car Phone Mount'),
                'is_active' => true,
            ],
            [
                'name' => 'Portable Jump Starter',
                'description' => 'Compact jump starter with USB charging ports and LED flashlight for emergencies.',
                'price' => 89.99,
                'quantity' => 25,
                'category_slug' => 'automotive',
                'image' => 'products/portable-jump-starter.jpg',
                'slug' => Str::slug('Portable Jump Starter'),
                'is_active' => true,
            ],
            [
                'name' => 'Dash Cam 4K',
                'description' => 'Ultra HD dash cam with night vision, GPS, and automatic accident detection.',
                'price' => 149.99,
                'quantity' => 30,
                'category_slug' => 'automotive',
                'image' => 'products/dash-cam-4k.jpg',
                'slug' => Str::slug('Dash Cam 4K'),
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('slug', $productData['category_slug'])->first();
            
            if ($category) {
                Product::firstOrCreate(
                    ['slug' => $productData['slug']],
                    [
                        'name' => $productData['name'],
                        'description' => $productData['description'],
                        'price' => $productData['price'],
                        'quantity' => $productData['quantity'],
                        'category_id' => $category->id,
                        'image' => $productData['image'],
                        'slug' => $productData['slug'],
                        'is_active' => $productData['is_active'],
                    ]
                );
            }
        }
    }
} 