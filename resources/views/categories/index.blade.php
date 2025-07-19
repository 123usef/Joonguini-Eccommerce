@extends('Layout.Base')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center mb-4">
                <i class="fas fa-list me-2"></i>All Categories
            </h1>
            <p class="text-center text-muted">Browse through our wide range of product categories</p>
            <hr>
        </div>
    </div>
    
    @if($categories->count() > 0)
        <div class="row">
            @foreach($categories as $category)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                        <div class="card category-card h-100 shadow-sm border-0">
                            <div class="card-body text-center p-4">
                                <div class="category-icon mb-3">
                                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" 
                                         class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                                <h5 class="card-title mb-2">{{ $category->name }}</h5>
                                @if($category->description)
                                    <p class="text-muted small mb-3">{{ Str::limit($category->description, 100) }}</p>
                                @endif
                                <div class="d-flex justify-content-center align-items-center">
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $category->products_count }} {{ $category->products_count == 1 ? 'Product' : 'Products' }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 text-center">
                                <span class="btn btn-outline-primary btn-sm rounded-pill">
                                    <i class="fas fa-arrow-right me-1"></i>Browse Products
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        
        <!-- Quick Access Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card bg-light border-0">
                    <div class="card-body text-center py-5">
                        <h3 class="fw-bold mb-3">Looking for something specific?</h3>
                        <p class="text-muted mb-4">Search through all our products or browse by category</p>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="{{ route('products') }}" class="btn btn-primary rounded-pill">
                                <i class="fas fa-search me-2"></i>Search All Products
                            </a>
                            <a href="{{ route('products', ['sort' => 'newest']) }}" class="btn btn-outline-success rounded-pill">
                                <i class="fas fa-star me-2"></i>New Arrivals
                            </a>
                            <a href="{{ route('products', ['sort' => 'price', 'direction' => 'asc']) }}" class="btn btn-outline-info rounded-pill">
                                <i class="fas fa-dollar-sign me-2"></i>Best Deals
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-5x text-muted mb-3"></i>
                    <h3 class="text-muted">No Categories Available</h3>
                    <p class="text-muted">Check back later for new categories!</p>
                    <a href="{{ route('index') }}" class="btn btn-primary rounded-pill">
                        <i class="fas fa-home me-2"></i>Back to Home
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
/* Category Card Hover Effects */
.category-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.category-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
}

.category-icon {
    transition: transform 0.3s ease;
}

.category-card:hover .category-icon {
    transform: scale(1.1);
}

.category-card:hover .card-title {
    color: #0d6efd !important;
}

.category-card:hover .btn-outline-primary {
    background-color: #0d6efd;
    color: white;
}

/* Badge animation */
.badge {
    transition: all 0.3s ease;
}

.category-card:hover .badge {
    transform: scale(1.1);
}
</style>
@endpush
@endsection