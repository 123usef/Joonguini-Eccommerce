@extends('Layout.Base')

@section('content')
<div class="container">
    <!-- Category Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-2">
                                    <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-white-50">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('categories') }}" class="text-white-50">Categories</a></li>
                                    <li class="breadcrumb-item active text-white" aria-current="page">{{ $category->name }}</li>
                                </ol>
                            </nav>
                            <h1 class="display-5 fw-bold mb-2">{{ $category->name }}</h1>
                            @if($category->description)
                                <p class="lead mb-0">{{ $category->description }}</p>
                            @endif
                        </div>
                        <div class="col-md-4 text-center">
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" 
                                 class="rounded-circle border border-white border-3" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2"></i>Filter {{ $category->name }} Products
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('categories.show', $category->slug) }}">
                        <div class="row g-3">
                            <!-- Search -->
                            <div class="col-md-6">
                                <label for="search" class="form-label">Search in {{ $category->name }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" id="search" name="search" 
                                           placeholder="Search products..." value="{{ request('search') }}">
                                </div>
                            </div>
                            
                            <!-- Sort By -->
                            <div class="col-md-6">
                                <label for="sort" class="form-label">Sort By</label>
                                <div class="row g-2">
                                    <div class="col-8">
                                        <select class="form-select" id="sort" name="sort">
                                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                                            <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                            <option value="stock" {{ request('sort') == 'stock' ? 'selected' : '' }}>Stock</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <select class="form-select" name="direction">
                                            <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Asc</option>
                                            <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Desc</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Price Range -->
                            <div class="col-md-4">
                                <label for="min_price" class="form-label">Min Price</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="min_price" name="min_price" 
                                           placeholder="0" min="0" step="0.001" value="{{ request('min_price') }}">
                                    <span class="input-group-text">OMR</span>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="max_price" class="form-label">Max Price</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="max_price" name="max_price" 
                                           placeholder="1000" min="0" step="0.001" value="{{ request('max_price') }}">
                                    <span class="input-group-text">OMR</span>
                                </div>
                            </div>
                            
                            <!-- Stock Status -->
                            <div class="col-md-4">
                                <label for="stock_status" class="form-label">Stock Status</label>
                                <select class="form-select" id="stock_status" name="stock_status">
                                    <option value="">All Stock</option>
                                    <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                    <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-filter me-2"></i>Apply Filters
                                </button>
                                <a href="{{ route('categories.show', $category->slug) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Clear Filters
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Results Info -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-0 text-muted">
                        Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} 
                        of {{ $products->total() }} products in {{ $category->name }}
                        @if(request('search'))
                            for "<strong>{{ request('search') }}</strong>"
                        @endif
                    </p>
                </div>
                <div>
                    @if($priceRange && $priceRange->min_price && $priceRange->max_price)
                        <small class="text-muted">
                            Price range: {{ number_format($priceRange->min_price, 3) }} OMR - {{ number_format($priceRange->max_price, 3) }} OMR
                        </small>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card h-100 shadow-sm border-0">
                        <div class="position-relative overflow-hidden">
                            <img src="{{ $product->image_url }}" 
                                 alt="{{ $product->name }}" 
                                 class="card-img-top product-image" 
                                 style="height: 250px; object-fit: cover;"
                                 onerror="this.src='{{ \App\Services\ImageService::getPlaceholderUrl('product', 400, 250) }}'">
                            
                            <!-- Product Overlay -->
                            <div class="product-overlay">
                                <button class="btn btn-primary btn-sm rounded-pill add-to-cart-btn" 
                                        data-product-id="{{ $product->id }}" data-quantity="1">
                                    <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                </button>
                            </div>
                            
                            <!-- Badges -->
                            @if($product->quantity <= 5 && $product->quantity > 0)
                                <span class="badge bg-warning position-absolute top-0 start-0 m-2">
                                    <i class="fas fa-exclamation-triangle"></i> Low Stock
                                </span>
                            @elseif($product->quantity <= 0)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                    <i class="fas fa-times"></i> Out of Stock
                                </span>
                            @endif
                            
                            @if($product->created_at->diffInDays(now()) <= 7)
                                <span class="badge bg-success position-absolute top-0 end-0 m-2">New</span>
                            @endif
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">{{ $product->name }}</h6>
                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($product->description, 100) }}
                            </p>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="h5 mb-0 text-primary">
                                        {{ $product->formatted_price }}
                                    </span>
                                    <small class="text-{{ $product->stock_color }}">
                                        <i class="fas fa-cubes"></i> {{ $product->stock_status }}
                                    </small>
                                </div>
                                
                                @if($product->isInStock())
                                    <button class="btn btn-primary w-100 add-to-cart-btn" 
                                            data-product-id="{{ $product->id }}" 
                                            data-quantity="1">
                                        <i class="fas fa-cart-plus"></i> Add to Cart
                                    </button>
                                @else
                                    <button class="btn btn-secondary w-100" disabled>
                                        <i class="fas fa-times"></i> Out of Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($products->hasPages())
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
        @endif
    @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-search fa-5x text-muted mb-3"></i>
                    <h3 class="text-muted">No products found</h3>
                    <p class="text-muted">
                        @if(request('search'))
                            No products found for "{{ request('search') }}" in {{ $category->name }}
                        @else
                            No products available in {{ $category->name }} category
                        @endif
                    </p>
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <a href="{{ route('categories.show', $category->slug) }}" class="btn btn-outline-primary">
                            <i class="fas fa-refresh me-2"></i>View All {{ $category->name }}
                        </a>
                        <a href="{{ route('categories') }}" class="btn btn-primary">
                            <i class="fas fa-list me-2"></i>Browse Categories
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Related Categories -->
    @if($categories->count() > 1)
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="fw-bold mb-3">Other Categories</h4>
            <div class="row">
                @foreach($categories->where('slug', '!=', $category->slug)->take(4) as $relatedCategory)
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('categories.show', $relatedCategory->slug) }}" class="text-decoration-none">
                            <div class="card category-card h-100 shadow-sm border-0">
                                <div class="card-body text-center p-3">
                                    <img src="{{ $relatedCategory->image_url }}" alt="{{ $relatedCategory->name }}" 
                                         class="rounded-circle mb-2" style="width: 60px; height: 60px; object-fit: cover;">
                                    <h6 class="card-title mb-0">{{ $relatedCategory->name }}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
/* Product Card Styles */
.product-card {
    transition: all 0.3s ease;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.product-image {
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

/* Product Overlay */
.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

/* Category Card Hover Effects */
.category-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.category-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
}

/* Breadcrumb links */
.breadcrumb-item a {
    text-decoration: none;
}

.breadcrumb-item a:hover {
    text-decoration: underline;
}
</style>
@endpush
@endsection