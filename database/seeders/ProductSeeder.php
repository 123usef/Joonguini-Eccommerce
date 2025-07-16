<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Wireless Mouse',
                'description' => 'A comfortable wireless mouse with ergonomic design.',
                'price' => 19.99,
                'quantity' => 50,
                'category_id' => 1,
                'image' => 'mouse.jpg',
                'slug' => Str::slug('Wireless Mouse'),
                'is_active' => true,
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB backlit mechanical keyboard for gaming and work.',
                'price' => 59.99,
                'quantity' => 30,
                'category_id' => 1,
                'image' => 'keyboard.jpg',
                'slug' => Str::slug('Mechanical Keyboard'),
                'is_active' => true,
            ],
            [
                'name' => 'HD Monitor',
                'description' => '24-inch full HD monitor with vibrant colors.',
                'price' => 129.99,
                'quantity' => 20,
                'category_id' => 2,
                'image' => 'monitor.jpg',
                'slug' => Str::slug('HD Monitor'),
                'is_active' => true,
            ],
            [
                'name' => 'USB-C Hub',
                'description' => 'Multiport USB-C hub with HDMI and USB 3.0.',
                'price' => 34.99,
                'quantity' => 40,
                'category_id' => 3,
                'image' => 'hub.jpg',
                'slug' => Str::slug('USB-C Hub'),
                'is_active' => true,
            ],
            [
                'name' => 'Bluetooth Speaker',
                'description' => 'Portable Bluetooth speaker with deep bass.',
                'price' => 24.99,
                'quantity' => 60,
                'category_id' => 4,
                'image' => 'speaker.jpg',
                'slug' => Str::slug('Bluetooth Speaker'),
                'is_active' => true,
            ],
            [
                'name' => 'Webcam 1080p',
                'description' => 'High-definition webcam for video conferencing.',
                'price' => 39.99,
                'quantity' => 25,
                'category_id' => 2,
                'image' => 'webcam.jpg',
                'slug' => Str::slug('Webcam 1080p'),
                'is_active' => true,
            ],
            [
                'name' => 'External SSD 1TB',
                'description' => 'Fast 1TB external SSD for data storage.',
                'price' => 99.99,
                'quantity' => 15,
                'category_id' => 5,
                'image' => 'ssd.jpg',
                'slug' => Str::slug('External SSD 1TB'),
                'is_active' => true,
            ],
            [
                'name' => 'Gaming Headset',
                'description' => 'Surround sound gaming headset with microphone.',
                'price' => 49.99,
                'quantity' => 35,
                'category_id' => 4,
                'image' => 'headset.jpg',
                'slug' => Str::slug('Gaming Headset'),
                'is_active' => true,
            ],
            [
                'name' => 'Smartwatch',
                'description' => 'Fitness tracking smartwatch with heart rate monitor.',
                'price' => 79.99,
                'quantity' => 22,
                'category_id' => 6,
                'image' => 'smartwatch.jpg',
                'slug' => Str::slug('Smartwatch'),
                'is_active' => true,
            ],
            [
                'name' => 'Portable Charger',
                'description' => '10000mAh portable charger for mobile devices.',
                'price' => 29.99,
                'quantity' => 45,
                'category_id' => 3,
                'image' => 'charger.jpg',
                'slug' => Str::slug('Portable Charger'),
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
} 