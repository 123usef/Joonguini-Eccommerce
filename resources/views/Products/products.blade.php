@extends('Layout.Base')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center mb-4">Our Products</h1>
            <hr>
        </div>
    </div>
    
    <!-- Filter and Search Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-filter me-2"></i>Filter Products
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('products') }}" id="filterForm">
                        <div class="row g-3">
                            <!-- Search -->
                            <div class="col-md-4">
                                <label for="search" class="form-label">Search Products</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" id="search" name="search" 
                                           placeholder="Search by name..." value="{{ request('search') }}">
                                </div>
                            </div>
                            
                            <!-- Category Filter -->
                            <div class="col-md-4">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}" 
                                                {{ request('category') == $category->slug ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Sort By -->
                            <div class="col-md-4">
                                <label for="sort" class="form-label">Sort By</label>
                                <select class="form-select" id="sort" name="sort">
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                                    <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                    <option value="stock" {{ request('sort') == 'stock' ? 'selected' : '' }}>Stock</option>
                                </select>
                            </div>
                            
                            <!-- Price Range -->
                            <div class="col-md-3">
                                <label for="min_price" class="form-label">Min Price</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="min_price" name="min_price" 
                                           placeholder="0" min="0" step="0.001" value="{{ request('min_price') }}">
                                    <span class="input-group-text">OMR</span>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="max_price" class="form-label">Max Price</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="max_price" name="max_price" 
                                           placeholder="1000" min="0" step="0.001" value="{{ request('max_price') }}">
                                    <span class="input-group-text">OMR</span>
                                </div>
                            </div>
                            
                            <!-- Stock Status -->
                            <div class="col-md-3">
                                <label for="stock_status" class="form-label">Stock Status</label>
                                <select class="form-select" id="stock_status" name="stock_status">
                                    <option value="">All Stock</option>
                                    <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                    <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                                </select>
                            </div>
                            
                            <!-- Sort Direction -->
                            <div class="col-md-3">
                                <label for="direction" class="form-label">Direction</label>
                                <select class="form-select" id="direction" name="direction">
                                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-filter me-2"></i>Apply Filters
                                </button>
                                <a href="{{ route('products') }}" class="btn btn-outline-secondary">
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
                        of {{ $products->total() }} products
                        @if(request('search'))
                            for "<strong>{{ request('search') }}</strong>"
                        @endif
                        @if(request('category'))
                            @php
                                $selectedCategory = $categories->firstWhere('slug', request('category'));
                            @endphp
                            @if($selectedCategory)
                                in <strong>{{ $selectedCategory->name }}</strong>
                            @endif
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
    
    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="position-relative">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->image_url ?: '/images/placeholder-product.jpg' }}" 
                                     alt="{{ $product->name }}" 
                                     class="card-img-top" 
                                     style="height: 200px; object-fit: cover;"
                                     onerror="this.src='/images/placeholder-product.jpg'">
                            </a>
                            
                            @if($product->quantity <= 5 && $product->quantity > 0)
                                <span class="badge bg-warning position-absolute top-0 start-0 m-2">
                                    <i class="fas fa-exclamation-triangle"></i> Low Stock
                                </span>
                            @elseif($product->quantity <= 0)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                    <i class="fas fa-times"></i> Out of Stock
                                </span>
                            @endif
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">
                                    {{ $product->name }}
                                </a>
                            </h5>
                            
                            @if($product->category)
                                <small class="text-muted mb-2">
                                    <i class="fas fa-tag"></i> {{ $product->category->name }}
                                </small>
                            @endif
                            
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
            <div class="col-12">
                <nav aria-label="Products pagination">
                    <ul class="pagination justify-content-center">
                        {{-- Previous Page Link --}}
                        @if ($products->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i> Previous
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->appends(request()->query())->previousPageUrl() }}" rel="prev">
                                    <i class="fas fa-chevron-left"></i> Previous
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $start = $products->currentPage() - 2;
                            $end = $products->currentPage() + 2;
                            
                            if($start < 1) {
                                $start = 1;
                                $end += 1;
                            }
                            
                            if($end >= $products->lastPage()) {
                                $end = $products->lastPage();
                            }
                        @endphp

                        @if($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->appends(request()->query())->url(1) }}">1</a>
                            </li>
                            @if($start > 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        @for($i = $start; $i <= $end; $i++)
                            <li class="page-item {{ ($products->currentPage() == $i) ? 'active' : '' }}">
                                <a class="page-link" href="{{ $products->appends(request()->query())->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if($end < $products->lastPage())
                            @if($end < $products->lastPage() - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->appends(request()->query())->url($products->lastPage()) }}">{{ $products->lastPage() }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($products->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $products->appends(request()->query())->nextPageUrl() }}" rel="next">
                                    Next <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">
                                    Next <i class="fas fa-chevron-right"></i>
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>
                
                {{-- Page Info --}}
                <div class="text-center text-muted mt-3">
                    <small>
                        Page {{ $products->currentPage() }} of {{ $products->lastPage() }} | 
                        Total: {{ $products->total() }} products
                    </small>
                </div>
            </div>
        </div>
        @endif
    @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
                    <h3 class="text-muted">No Products Available</h3>
                    <p class="text-muted">Check back later for new products!</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Enhanced Pagination Styling */
    .pagination {
        margin: 0;
        padding: 0;
    }
    
    .pagination .page-link {
        color: #0066cc;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
        margin: 0 2px;
        border-radius: 0.25rem;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .pagination .page-link:hover {
        background-color: #f8f9fa;
        color: #0056b3;
        border-color: #0066cc;
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0066cc;
        border-color: #0066cc;
        color: white;
        box-shadow: 0 2px 4px rgba(0,102,204,0.3);
    }
    
    .pagination .page-item.disabled .page-link {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
        cursor: not-allowed;
    }
    
    .pagination .page-item:first-child .page-link {
        border-radius: 0.375rem;
    }
    
    .pagination .page-item:last-child .page-link {
        border-radius: 0.375rem;
    }
    
    /* Mobile responsive pagination */
    @media (max-width: 576px) {
        .pagination .page-link {
            padding: 0.375rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .pagination .page-item .page-link i {
            display: none;
        }
    }
</style>
@endpush