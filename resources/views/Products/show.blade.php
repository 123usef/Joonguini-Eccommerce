@extends('Layout.Base')

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
            @if($product->category)
                <li class="breadcrumb-item"><a href="{{ route('categories.show', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-lg-6 mb-4">
            <div class="product-image-container">
                <img src="{{ $product->image_url ?: '/images/placeholder-product.jpg' }}" 
                     alt="{{ $product->name }}" 
                     class="img-fluid rounded shadow-sm w-100" 
                     style="max-height: 500px; object-fit: cover;"
                     onerror="this.src='/images/placeholder-product.jpg'">
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-6">
            <div class="product-details">
                <!-- Product Title -->
                <h1 class="product-title mb-3">{{ $product->name }}</h1>
                
                <!-- Category Badge -->
                @if($product->category)
                    <div class="mb-3">
                        <a href="{{ route('categories.show', $product->category->slug) }}" 
                           class="badge bg-primary text-decoration-none">
                            <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                        </a>
                    </div>
                @endif

                <!-- Price -->
                <div class="price-section mb-4">
                    <h2 class="price text-primary mb-0">{{ $product->formatted_price }}</h2>
                </div>

                <!-- Stock Status -->
                <div class="stock-status mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-cubes me-2 text-{{ $product->stock_color }}"></i>
                        <span class="fw-bold text-{{ $product->stock_color }}">{{ $product->stock_status }}</span>
                        @if($product->quantity > 0 && $product->quantity <= 5)
                            <small class="text-muted ms-2">({{ $product->quantity }} left)</small>
                        @endif
                    </div>
                </div>

                <!-- Add to Cart Section -->
                @if($product->isInStock())
                    <div class="add-to-cart-section mb-4">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <label for="quantity" class="form-label">Quantity:</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary" type="button" id="decreaseQty">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" class="form-control text-center" id="quantity" 
                                           value="1" min="1" max="{{ $product->quantity }}">
                                    <button class="btn btn-outline-secondary" type="button" id="increaseQty">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-8">
                                <button class="btn btn-primary btn-lg w-100 add-to-cart-btn" 
                                        data-product-id="{{ $product->id }}" data-quantity="1">
                                    <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mb-4">
                        <button class="btn btn-secondary btn-lg w-100" disabled>
                            <i class="fas fa-times me-2"></i>Out of Stock
                        </button>
                    </div>
                @endif

                <!-- Product Description -->
                @if($product->description)
                    <div class="product-description mb-4">
                        <h5>Description</h5>
                        <div class="text-muted">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                @endif

                <!-- Product Details -->
                <div class="product-specs">
                    <h5>Product Details</h5>
                    <ul class="list-unstyled">
                        <li><strong>SKU:</strong> PRD-{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</li>
                        @if($product->category)
                            <li><strong>Category:</strong> {{ $product->category->name }}</li>
                        @endif
                        <li><strong>Availability:</strong> {{ $product->stock_status }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="related-products mt-5">
            <div class="row mb-4">
                <div class="col-12">
                    <h3>Related Products</h3>
                    <hr>
                </div>
            </div>
            
            <div class="row">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="position-relative">
                                <a href="{{ route('products.show', $relatedProduct->slug) }}">
                                    <img src="{{ $relatedProduct->image_url ?: '/images/placeholder-product.jpg' }}" 
                                         alt="{{ $relatedProduct->name }}" 
                                         class="card-img-top" 
                                         style="height: 200px; object-fit: cover;"
                                         onerror="this.src='/images/placeholder-product.jpg'">
                                </a>
                                
                                @if($relatedProduct->quantity <= 5 && $relatedProduct->quantity > 0)
                                    <span class="badge bg-warning position-absolute top-0 start-0 m-2">
                                        <i class="fas fa-exclamation-triangle"></i> Low Stock
                                    </span>
                                @elseif($relatedProduct->quantity <= 0)
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                        <i class="fas fa-times"></i> Out of Stock
                                    </span>
                                @endif
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">
                                    <a href="{{ route('products.show', $relatedProduct->slug) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ $relatedProduct->name }}
                                    </a>
                                </h6>
                                
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="h6 mb-0 text-primary">
                                            {{ $relatedProduct->formatted_price }}
                                        </span>
                                        <small class="text-{{ $relatedProduct->stock_color }}">
                                            {{ $relatedProduct->stock_status }}
                                        </small>
                                    </div>
                                    
                                    @if($relatedProduct->isInStock())
                                        <button class="btn btn-primary btn-sm w-100 add-to-cart-btn" 
                                                data-product-id="{{ $relatedProduct->id }}" 
                                                data-quantity="1">
                                            <i class="fas fa-cart-plus"></i> Add to Cart
                                        </button>
                                    @else
                                        <button class="btn btn-secondary btn-sm w-100" disabled>
                                            <i class="fas fa-times"></i> Out of Stock
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const decreaseBtn = document.getElementById('decreaseQty');
    const increaseBtn = document.getElementById('increaseQty');
    const addToCartBtn = document.querySelector('.add-to-cart-btn[data-product-id="{{ $product->id }}"]');
    
    // Quantity controls
    decreaseBtn.addEventListener('click', function() {
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            updateAddToCartButton();
        }
    });
    
    increaseBtn.addEventListener('click', function() {
        const currentValue = parseInt(quantityInput.value);
        const maxValue = parseInt(quantityInput.max);
        if (currentValue < maxValue) {
            quantityInput.value = currentValue + 1;
            updateAddToCartButton();
        }
    });
    
    quantityInput.addEventListener('change', function() {
        const value = parseInt(this.value);
        const min = parseInt(this.min);
        const max = parseInt(this.max);
        
        if (value < min) {
            this.value = min;
        } else if (value > max) {
            this.value = max;
        }
        
        updateAddToCartButton();
    });
    
    function updateAddToCartButton() {
        if (addToCartBtn) {
            addToCartBtn.setAttribute('data-quantity', quantityInput.value);
        }
    }
});
</script>
@endpush

@push('styles')
<style>
.product-title {
    font-size: 2rem;
    font-weight: 600;
    color: #333;
}

.price {
    font-size: 1.8rem;
    font-weight: 700;
}

.product-image-container {
    position: relative;
    overflow: hidden;
    border-radius: 0.5rem;
}

.product-image-container img {
    transition: transform 0.3s ease;
}

.product-image-container:hover img {
    transform: scale(1.05);
}

.stock-status {
    padding: 1rem;
    border-radius: 0.5rem;
    background-color: #f8f9fa;
}

.add-to-cart-section .input-group {
    max-width: 140px;
}

.related-products .card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.related-products .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

@media (max-width: 768px) {
    .product-title {
        font-size: 1.5rem;
    }
    
    .price {
        font-size: 1.5rem;
    }
    
    .add-to-cart-section .row {
        flex-direction: column;
    }
    
    .add-to-cart-section .col-4,
    .add-to-cart-section .col-8 {
        flex: 0 0 100%;
        max-width: 100%;
        margin-bottom: 1rem;
    }
}
</style>
@endpush
@endsection