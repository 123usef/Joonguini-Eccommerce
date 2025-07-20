@extends('Layout.Base')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center mb-4">
                <i class="fas fa-shopping-cart"></i> Shopping Cart
            </h1>
            <hr>
        </div>
    </div>
    
    @if(count($cartItems) > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Cart Items</h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($cartItems as $item)
                            <div class="border-bottom p-3" id="cart-item-{{ $item['product']->id }}">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="{{ $item['product']->image_url ?: '/images/placeholder-product.svg' }}" 
                                             alt="{{ $item['product']->name }}" 
                                             class="img-fluid rounded" 
                                             style="max-height: 80px; width: 80px; object-fit: cover;"
                                             onerror="this.src='/images/placeholder-product.svg'">
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <h6 class="mb-1">{{ $item['product']->name }}</h6>
                                        @if($item['product']->category)
                                            <small class="text-muted">{{ $item['product']->category->name }}</small>
                                        @endif
                                        <div class="mt-1">
                                            <span class="text-primary">{{ $item['product']->formatted_price }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="input-group input-group-sm">
                                            <button class="btn btn-outline-secondary" type="button" 
                                                    onclick="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] - 1 }})">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" class="form-control text-center" 
                                                   value="{{ $item['quantity'] }}" 
                                                   min="1" 
                                                   max="{{ $item['product']->quantity }}"
                                                   onchange="updateQuantity({{ $item['product']->id }}, this.value)">
                                            <button class="btn btn-outline-secondary" type="button" 
                                                    onclick="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] + 1 }})">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted">Max: {{ $item['product']->quantity }}</small>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <strong>{{ number_format($item['subtotal'], 3) }} OMR</strong>
                                    </div>
                                    
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-outline-danger" 
                                                onclick="removeFromCart({{ $item['product']->id }})" 
                                                title="Remove item">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="mt-3">
                    <button class="btn btn-outline-warning" onclick="clearCart()">
                        <i class="fas fa-trash-alt"></i> Clear Cart
                    </button>
                    <a href="{{ route('products') }}" class="btn btn-outline-primary ms-2">
                        <i class="fas fa-arrow-left"></i> Continue Shopping
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span id="cart-subtotal">{{ number_format($cartTotal, 3) }} OMR</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span class="text-success">Free</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax:</span>
                            <span>0.000 OMR</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong id="cart-total">{{ number_format($cartTotal, 3) }} OMR</strong>
                        </div>
                        
                        @auth
                            <a href="{{ route('checkout') }}" class="btn btn-success w-100 mb-2">
                                <i class="fas fa-credit-card"></i> Proceed to Checkout
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-success w-100 mb-2">
                                <i class="fas fa-sign-in-alt"></i> Login to Checkout
                            </a>
                        @endauth
                        
                        <div class="text-center">
                            <small class="text-muted">
                                <i class="fas fa-lock"></i> Secure checkout
                            </small>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-body text-center">
                        <h6>Need Help?</h6>
                        <p class="small text-muted">Contact our customer service</p>
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-phone"></i> Call Us
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                    <h3 class="text-muted">Your cart is empty</h3>
                    <p class="text-muted mb-4">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('products') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag"></i> Start Shopping
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function updateQuantity(productId, quantity) {
    if (quantity < 1) {
        removeFromCart(productId);
        return;
    }
    
    Cart.update(productId, quantity).then(data => {
        if (data.success) {
            // Reload page to update totals and quantities
            location.reload();
        }
    });
}

function removeFromCart(productId) {
    if (confirm('Are you sure you want to remove this item from your cart?')) {
        Cart.remove(productId).then(data => {
            if (data.success) {
                // Remove item from DOM or reload page
                const itemElement = document.getElementById('cart-item-' + productId);
                if (itemElement) {
                    itemElement.remove();
                }
                
                // Reload page to update totals
                setTimeout(() => {
                    location.reload();
                }, 500);
            }
        });
    }
}

function clearCart() {
    if (confirm('Are you sure you want to clear your entire cart?')) {
        Cart.clear().then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>
@endpush
@endsection