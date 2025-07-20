<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Start with base query
        $query = Product::active()->with('category');
        
        // Apply search filter if provided
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }
        
        // Apply category filter if provided
        if ($request->filled('category')) {
            $categorySlug = $request->input('category');
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        
        // Apply price range filter if provided
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }
        
        // Apply stock filter if provided
        if ($request->filled('stock_status')) {
            $stockStatus = $request->input('stock_status');
            if ($stockStatus === 'in_stock') {
                $query->inStock();
            } elseif ($stockStatus === 'low_stock') {
                $query->where('quantity', '>', 0)->where('quantity', '<=', 5);
            } elseif ($stockStatus === 'all') {
                // No additional filter for 'all'
            } else {
                $query->inStock(); // Default to in stock
            }
        } else {
            $query->inStock(); // Default to in stock products
        }
        
        // Apply sorting
        $sortBy = $request->input('sort', 'name');
        $sortDirection = $request->input('direction', 'asc');
        
        switch ($sortBy) {
            case 'price':
                $query->orderBy('price', $sortDirection);
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'stock':
                $query->orderBy('quantity', $sortDirection);
                break;
            default:
                $query->orderBy('name', $sortDirection);
        }
        
        // Get paginated products
        $products = $query->paginate(12)->withQueryString();
        
        // Get all categories for filter dropdown
        $categories = Category::orderBy('name')->get();
        
        // Get price range for filter
        $priceRange = Product::active()
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();
        
        return view('Products.products', compact('products', 'categories', 'priceRange'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        // Get related products from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inStock()
            ->take(4)
            ->get();

        return view('Products.show', compact('product', 'relatedProducts'));
    }
}
