<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Get the full URL for a product image
     */
    public static function getProductImageUrl($imagePath)
    {
        if (!$imagePath) {
            return self::getLocalPlaceholder('product');
        }

        // If it's already a full URL, return it
        if (Str::startsWith($imagePath, ['http://', 'https://'])) {
            return $imagePath;
        }

        // Check if image exists in public/images directory
        $publicPath = public_path('images/' . $imagePath);
        if (file_exists($publicPath)) {
            return asset('images/' . $imagePath);
        }

        // Fallback to local placeholder
        return self::getLocalPlaceholder('product');
    }

    /**
     * Get local placeholder image
     */
    private static function getLocalPlaceholder($type = 'product')
    {
        // Try to use the default placeholder SVG first
        $placeholderPath = public_path('images/placeholder.svg');
        if (file_exists($placeholderPath)) {
            return asset('images/placeholder.svg');
        }

        // If that doesn't exist, generate inline SVG
        return self::generateLocalPlaceholder($type);
    }

    /**
     * Get the full URL for a category image
     */
    public static function getCategoryImageUrl($imagePath)
    {
        if (!$imagePath) {
            return self::getLocalPlaceholder('category');
        }

        // If it's already a full URL, return it
        if (Str::startsWith($imagePath, ['http://', 'https://'])) {
            return $imagePath;
        }

        // Check if image exists in public/images directory
        $publicPath = public_path('images/' . $imagePath);
        if (file_exists($publicPath)) {
            return asset('images/' . $imagePath);
        }

        // Fallback to local placeholder
        return self::getLocalPlaceholder('category');
    }

    /**
     * Get placeholder image URL - using local SVG fallback
     */
    public static function getPlaceholderUrl($type = 'product', $width = 400, $height = 400)
    {
        // Return local SVG data URI instead of external service
        return self::generateLocalPlaceholder($type, $width, $height);
    }

    /**
     * Generate local SVG placeholder
     */
    private static function generateLocalPlaceholder($type = 'product', $width = 400, $height = 400)
    {
        $colors = [
            'product' => '#4F46E5',
            'category' => '#059669',
            'default' => '#6B7280'
        ];

        $color = $colors[$type] ?? $colors['default'];
        $text = ucfirst($type);
        
        $svg = '
        <svg width="' . $width . '" height="' . $height . '" xmlns="http://www.w3.org/2000/svg">
            <rect width="100%" height="100%" fill="' . $color . '"/>
            <text x="50%" y="50%" text-anchor="middle" dy="0.35em" fill="white" font-family="Arial, sans-serif" font-size="16">' . $text . '</text>
        </svg>';
        
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    /**
     * Get responsive placeholder URLs for different sizes
     */
    public static function getResponsivePlaceholders($type = 'product')
    {
        return [
            'thumbnail' => self::getPlaceholderUrl($type, 150, 150),
            'small' => self::getPlaceholderUrl($type, 300, 300),
            'medium' => self::getPlaceholderUrl($type, 400, 400),
            'large' => self::getPlaceholderUrl($type, 600, 600),
        ];
    }

    /**
     * Download and save image from URL
     */
    public static function downloadAndSaveImage($url, $path)
    {
        try {
            $imageContent = file_get_contents($url);
            $fullPath = public_path('images/' . $path);
            
            // Create directory if it doesn't exist
            $directory = dirname($fullPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            file_put_contents($fullPath, $imageContent);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Create sample images for seeding - using local SVG generation
     */
    public static function createSampleImages()
    {
        $productImages = [
            'products/iphone-15-pro.jpg' => ['text' => 'iPhone 15 Pro', 'color' => '#4F46E5'],
            'products/macbook-air-m2.jpg' => ['text' => 'MacBook Air M2', 'color' => '#4F46E5'],
            'products/samsung-galaxy-s24.jpg' => ['text' => 'Samsung Galaxy S24', 'color' => '#4F46E5'],
            'products/sony-headphones.jpg' => ['text' => 'Sony Headphones', 'color' => '#4F46E5'],
            'products/nike-air-max-270.jpg' => ['text' => 'Nike Air Max 270', 'color' => '#059669'],
            'products/levis-501-jeans.jpg' => ['text' => 'Levis 501 Jeans', 'color' => '#059669'],
            'products/patagonia-fleece.jpg' => ['text' => 'Patagonia Fleece', 'color' => '#059669'],
            'products/psychology-of-money.jpg' => ['text' => 'Psychology of Money', 'color' => '#DC2626'],
            'products/atomic-habits.jpg' => ['text' => 'Atomic Habits', 'color' => '#DC2626'],
            'products/dune-complete-series.jpg' => ['text' => 'Dune Complete Series', 'color' => '#DC2626'],
            'products/yoga-mat-premium.jpg' => ['text' => 'Yoga Mat Premium', 'color' => '#7C3AED'],
            'products/adjustable-dumbbells.jpg' => ['text' => 'Adjustable Dumbbells', 'color' => '#7C3AED'],
            'products/fitness-tracker.jpg' => ['text' => 'Fitness Tracker', 'color' => '#7C3AED'],
            'products/instant-pot-duo.jpg' => ['text' => 'Instant Pot Duo', 'color' => '#F59E0B'],
            'products/dyson-v15-detect.jpg' => ['text' => 'Dyson V15 Detect', 'color' => '#F59E0B'],
            'products/smart-thermostat.jpg' => ['text' => 'Smart Thermostat', 'color' => '#F59E0B'],
            'products/lego-architecture.jpg' => ['text' => 'LEGO Architecture', 'color' => '#EC4899'],
            'products/nintendo-switch-oled.jpg' => ['text' => 'Nintendo Switch OLED', 'color' => '#EC4899'],
            'products/monopoly-classic.jpg' => ['text' => 'Monopoly Classic', 'color' => '#EC4899'],
            'products/skincare-routine-kit.jpg' => ['text' => 'Skincare Routine Kit', 'color' => '#10B981'],
            'products/electric-toothbrush.jpg' => ['text' => 'Electric Toothbrush', 'color' => '#10B981'],
            'products/vitamin-d3-supplements.jpg' => ['text' => 'Vitamin D3 Supplements', 'color' => '#10B981'],
            'products/car-phone-mount.jpg' => ['text' => 'Car Phone Mount', 'color' => '#374151'],
            'products/portable-jump-starter.jpg' => ['text' => 'Portable Jump Starter', 'color' => '#374151'],
            'products/dash-cam-4k.jpg' => ['text' => 'Dash Cam 4K', 'color' => '#374151'],
        ];

        $categoryImages = [
            'categories/electronics.jpg' => ['text' => 'Electronics', 'color' => '#4F46E5'],
            'categories/fashion.jpg' => ['text' => 'Fashion', 'color' => '#059669'],
            'categories/books.jpg' => ['text' => 'Books', 'color' => '#DC2626'],
            'categories/sports.jpg' => ['text' => 'Sports', 'color' => '#7C3AED'],
            'categories/home.jpg' => ['text' => 'Home', 'color' => '#F59E0B'],
            'categories/toys.jpg' => ['text' => 'Toys', 'color' => '#EC4899'],
            'categories/beauty.jpg' => ['text' => 'Beauty', 'color' => '#10B981'],
            'categories/automotive.jpg' => ['text' => 'Automotive', 'color' => '#374151'],
        ];

        $allImages = array_merge($productImages, $categoryImages);
        $createdCount = 0;

        foreach ($allImages as $path => $config) {
            if (self::createLocalSVGImage($path, $config['text'], $config['color'])) {
                $createdCount++;
            }
        }

        return $createdCount;
    }

    /**
     * Create local SVG image file
     */
    private static function createLocalSVGImage($path, $text, $color, $width = 400, $height = 400)
    {
        try {
            $svg = '<?xml version="1.0" encoding="UTF-8"?>
            <svg width="' . $width . '" height="' . $height . '" xmlns="http://www.w3.org/2000/svg">
                <rect width="100%" height="100%" fill="' . $color . '"/>
                <text x="50%" y="50%" text-anchor="middle" dy="0.35em" fill="white" font-family="Arial, sans-serif" font-size="18" font-weight="bold">' . htmlspecialchars($text) . '</text>
            </svg>';
            
            $fullPath = public_path('images/' . $path);
            
            // Create directory if it doesn't exist
            $directory = dirname($fullPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Save as SVG file
            file_put_contents($fullPath, $svg);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}