@extends('Layout.Base')

@section('content')
<!-- Hero Section with Slider -->
<section class="hero-section position-relative">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="hero-slide" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="container">
                        <div class="row align-items-center min-vh-50">
                            <div class="col-lg-6 text-white">
                                <h1 class="display-4 fw-bold mb-3">Welcome to Joonguini Store</h1>
                                <p class="lead mb-4">Discover amazing products at unbeatable prices. Shop the latest trends and enjoy exclusive deals!</p>
                                <a href="{{ route('products') }}" class="btn btn-light btn-lg rounded-pill px-4">
                                    <i class="fas fa-shopping-bag me-2"></i>Shop Now
                                </a>
                            </div>
                            <div class="col-lg-6 text-center">
                                <i class="fas fa-shopping-cart text-white" style="font-size: 200px; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="hero-slide" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="container">
                        <div class="row align-items-center min-vh-50">
                            <div class="col-lg-6 text-white">
                                <h1 class="display-4 fw-bold mb-3">New Arrivals</h1>
                                <p class="lead mb-4">Check out our latest collection of trendy products. Be the first to get yours!</p>
                                <a href="{{ route('products') }}" class="btn btn-dark btn-lg rounded-pill px-4">
                                    <i class="fas fa-arrow-right me-2"></i>Explore Now
                                </a>
                            </div>
                            <div class="col-lg-6 text-center">
                                <i class="fas fa-box-open text-white" style="font-size: 200px; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="hero-slide" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <div class="container">
                        <div class="row align-items-center min-vh-50">
                            <div class="col-lg-6 text-white">
                                <h1 class="display-4 fw-bold mb-3">Special Offers</h1>
                                <p class="lead mb-4">Don't miss out on our limited-time deals. Save big on your favorite products!</p>
                                <a href="{{ route('products') }}" class="btn btn-warning btn-lg rounded-pill px-4">
                                    <i class="fas fa-percentage me-2"></i>View Deals
                                </a>
                            </div>
                            <div class="col-lg-6 text-center">
                                <i class="fas fa-tags text-white" style="font-size: 200px; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>

<!-- Features Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="feature-box">
                    <i class="fas fa-shipping-fast text-primary mb-3" style="font-size: 2.5rem;"></i>
                    <h5>Free Shipping</h5>
                    <p class="text-muted mb-0">On orders over 20 OMR</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="feature-box">
                    <i class="fas fa-shield-alt text-success mb-3" style="font-size: 2.5rem;"></i>
                    <h5>Secure Payment</h5>
                    <p class="text-muted mb-0">100% secure transactions</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="feature-box">
                    <i class="fas fa-undo text-info mb-3" style="font-size: 2.5rem;"></i>
                    <h5>Easy Returns</h5>
                    <p class="text-muted mb-0">30-day return policy</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="feature-box">
                    <i class="fas fa-headset text-warning mb-3" style="font-size: 2.5rem;"></i>
                    <h5>24/7 Support</h5>
                    <p class="text-muted mb-0">Dedicated customer service</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Shop by Category</h2>
            <p class="text-muted">Browse through our wide range of categories</p>
        </div>
        <div class="row">
            @foreach($categories->take(8) as $category)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                    <div class="category-card card h-100 shadow-sm border-0">
                        <div class="card-body text-center p-4">
                            <div class="category-icon mb-3">
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" 
                                     class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            <h5 class="card-title mb-0">{{ $category->name }}</h5>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Latest Products Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="display-5 fw-bold mb-0">Latest Products</h2>
                <p class="text-muted">Just arrived in our store</p>
            </div>
            <a href="{{ route('products') }}" class="btn btn-outline-primary rounded-pill">
                View All <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
        <div class="row">
            @foreach($latestProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-card h-100 shadow-sm border-0">
                    <div class="position-relative overflow-hidden">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                             class="card-img-top product-image" style="height: 250px; object-fit: cover;">
                        <div class="product-overlay">
                            <button class="btn btn-primary btn-sm rounded-pill add-to-cart-btn" 
                                    data-product-id="{{ $product->id }}" data-quantity="1">
                                <i class="fas fa-cart-plus me-1"></i> Quick Add
                            </button>
                        </div>
                        @if($product->created_at->diffInDays(now()) <= 7)
                        <span class="badge bg-success position-absolute top-0 start-0 m-2">New</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <h6 class="card-title text-truncate">{{ $product->name }}</h6>
                        <p class="text-muted small mb-2">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 text-primary">{{ $product->formatted_price }}</span>
                            <small class="text-{{ $product->stock_color }}">
                                <i class="fas fa-circle"></i> {{ $product->stock_status }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Promotional Banner -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="promo-banner rounded-3 p-5 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h3 class="fw-bold mb-3">Summer Sale!</h3>
                    <p class="mb-4">Get up to 50% off on selected items. Limited time offer!</p>
                    <a href="{{ route('products') }}" class="btn btn-light rounded-pill">Shop Sale</a>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="promo-banner rounded-3 p-5 text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <h3 class="fw-bold mb-3">New Customer?</h3>
                    <p class="mb-4">Sign up today and get 10% off your first order!</p>
                    <a href="{{ route('register') }}" class="btn btn-dark rounded-pill">Sign Up Now</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Best Sellers Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Best Sellers</h2>
            <p class="text-muted">Our most popular products</p>
        </div>
        <div class="row">
            @foreach($bestSellers as $product)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card product-card h-100 shadow-sm border-0">
                    <div class="position-relative overflow-hidden">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                             class="card-img-top product-image" style="height: 250px; object-fit: cover;">
                        <div class="product-overlay">
                            <button class="btn btn-primary btn-sm rounded-pill add-to-cart-btn" 
                                    data-product-id="{{ $product->id }}" data-quantity="1">
                                <i class="fas fa-cart-plus me-1"></i> Add to Cart
                            </button>
                        </div>
                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                            <i class="fas fa-fire"></i> Hot
                        </span>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="text-muted small mb-2">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 text-primary">{{ $product->formatted_price }}</span>
                            @if($product->quantity <= 5)
                            <small class="text-danger">Only {{ $product->quantity }} left!</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h3 class="fw-bold mb-2">Subscribe to Our Newsletter</h3>
                <p class="mb-0">Get the latest updates on new products and upcoming sales</p>
            </div>
            <div class="col-lg-6">
                <form class="newsletter-form">
                    <div class="input-group">
                        <input type="email" class="form-control form-control-lg rounded-start-pill" 
                               placeholder="Enter your email address" required>
                        <button class="btn btn-warning btn-lg rounded-end-pill px-4" type="submit">
                            Subscribe <i class="fas fa-paper-plane ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
/* Hero Section Styles */
.hero-section {
    overflow: hidden;
    margin: 0;
    padding: 0;
}

.hero-slide {
    height: 500px; /* Fixed height for all slides */
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    background-attachment: fixed;
    background-size: cover;
    background-position: center;
}

.carousel-inner {
    height: 500px; /* Match the slide height exactly */
}

.carousel-item {
    height: 500px; /* Explicit height for each item */
}

.min-vh-50 {
    height: 100%;
    display: flex;
    align-items: center;
    min-height: unset;
}

/* Enhanced carousel indicators */
.carousel-indicators {
    bottom: 20px;
}

.carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
    opacity: 0.7;
    transition: all 0.3s ease;
}

.carousel-indicators button.active {
    opacity: 1;
    transform: scale(1.2);
    background-color: white;
}

/* Enhanced carousel controls */
.carousel-control-prev,
.carousel-control-next {
    width: 60px;
    height: 60px;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    transition: all 0.3s ease;
}

.carousel-control-prev {
    left: 20px;
}

.carousel-control-next {
    right: 20px;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-50%) scale(1.1);
}

/* Text animations */
.hero-slide h1 {
    animation: slideInFromLeft 1s ease-out;
}

.hero-slide p {
    animation: slideInFromLeft 1s ease-out 0.2s both;
}

.hero-slide .btn {
    animation: slideInFromLeft 1s ease-out 0.4s both;
}

@keyframes slideInFromLeft {
    0% {
        transform: translateX(-100px);
        opacity: 0;
    }
    100% {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Category Card Hover Effects */
.category-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.category-icon {
    transition: transform 0.3s ease;
}

.category-card:hover .category-icon {
    transform: scale(1.1);
}

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

/* Feature Box */
.feature-box {
    padding: 20px;
    transition: transform 0.3s ease;
}

.feature-box:hover {
    transform: translateY(-5px);
}

/* Promotional Banners */
.promo-banner {
    transition: transform 0.3s ease;
    min-height: 200px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.promo-banner:hover {
    transform: scale(1.02);
}

/* Newsletter Form */
.newsletter-form .form-control:focus {
    box-shadow: none;
    border-color: #ffc107;
}

/* Carousel Controls */
.carousel-control-prev,
.carousel-control-next {
    width: 5%;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .hero-slide,
    .carousel-inner {
        height: 400px; /* Smaller fixed height for mobile */
    }
    
    .display-4 {
        font-size: 2rem;
    }
    
    .lead {
        font-size: 1rem; /* Smaller text on mobile */
    }
    
    .display-5 {
        font-size: 1.5rem;
    }
    
    /* Hide icons on mobile for more content space */
    .hero-slide .col-lg-6.text-center {
        display: none;
    }
    
    /* Center content on mobile */
    .hero-slide .col-lg-6.text-white {
        text-align: center;
    }
}

@media (max-width: 576px) {
    .hero-slide,
    .carousel-inner {
        height: 350px; /* Even smaller for very small screens */
    }
    
    .display-4 {
        font-size: 1.75rem;
    }
}

/* Animation for badges */
@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

.badge {
    animation: pulse 2s infinite;
}
</style>
@endpush

@push('scripts')
<script>
// Initialize carousel with custom settings
document.addEventListener('DOMContentLoaded', function() {
    const heroCarousel = new bootstrap.Carousel(document.getElementById('heroCarousel'), {
        interval: 5000,
        pause: 'hover'
    });
});

// Newsletter form handler
document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = e.target.querySelector('input[type="email"]').value;
    
    // For now, just show success message
    Cart.showMessage('Thank you for subscribing! We\'ll keep you updated.', 'success');
    e.target.reset();
});
</script>
@endpush

@endsection