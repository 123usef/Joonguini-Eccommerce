<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * Display a listing of all categories
     */
    public function index()
    {
        $categories = Category::withCount(['products' => function ($query) {
            $query->active()->inStock();
        }])->orderBy('name')->get();
        
        return view('categories.index', compact('categories'));
    }

    /**
     * Display products for a specific category
     */
    public function show(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        // Get base query for products in this category
        $query = Product::where('category_id', $category->id)
            ->active()
            ->with('category');
        
        // Apply search filter if provided
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
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
            }
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
        $priceRange = Product::where('category_id', $category->id)
            ->active()
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();
        
        return view('categories.show', compact('category', 'products', 'categories', 'priceRange'));
    }
}