<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\ImageService;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating sample images...');
        
        $imageCount = ImageService::createSampleImages();
        
        $this->command->info("Created {$imageCount} sample images successfully!");
    }
}