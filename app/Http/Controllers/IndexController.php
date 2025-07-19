<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class IndexController extends Controller
{
    public function index()
    {
        // Get latest products
        $latestProducts = Product::active()
            ->inStock()
            ->with('category')
            ->latest()
            ->take(8)
            ->get();
        
        // Get featured/popular products (for now, random selection)
        $featuredProducts = Product::active()
            ->inStock()
            ->with('category')
            ->inRandomOrder()
            ->take(4)
            ->get();
        
        // Get best sellers (for now, products with low stock - indicating they sell well)
        $bestSellers = Product::active()
            ->where('quantity', '>', 0)
            ->where('quantity', '<=', 10)
            ->with('category')
            ->take(4)
            ->get();
        
        // If not enough best sellers, fill with random products
        if ($bestSellers->count() < 4) {
            $additionalProducts = Product::active()
                ->inStock()
                ->whereNotIn('id', $bestSellers->pluck('id'))
                ->inRandomOrder()
                ->take(4 - $bestSellers->count())
                ->get();
            $bestSellers = $bestSellers->concat($additionalProducts);
        }
        
        // Get all categories
        $categories = Category::all();
        
        return view('index', compact('latestProducts', 'featuredProducts', 'bestSellers', 'categories'));
    }
}
