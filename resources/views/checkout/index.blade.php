@extends('Layout.Base')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Checkout
                    </h4>
                </div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        
                        <!-- Order Summary -->
                        <div class="mb-4">
                            <h5 class="mb-3">Order Summary</h5>
                            <div class="bg-light p-3 rounded">
                                @foreach($cartItems as $item)
                                <div class="row align-items-center mb-3">
                                    <div class="col-2">
                                        <img src="{{ $item['product']->image_url ?: '/images/placeholder-product.svg' }}" alt="{{ $item['product']->name }}" 
                                             class="img-fluid rounded" style="width: 60px; height: 60px; object-fit: cover;"
                                             onerror="this.src='/images/placeholder-product.svg'">
                                    </div>
                                    <div class="col-6">
                                        <h6 class="mb-1">{{ $item['product']->name }}</h6>
                                        <small class="text-muted">{{ number_format($item['product']->price, 3) }} OMR each</small>
                                    </div>
                                    <div class="col-2 text-center">
                                        <span class="badge bg-secondary">{{ $item['quantity'] }}</span>
                                    </div>
                                    <div class="col-2 text-end">
                                        <strong>{{ number_format($item['subtotal'], 3) }} OMR</strong>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                <hr class="my-2">
                                @endif
                                @endforeach
                                
                                <hr class="my-3">
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="mb-0">Total:</h5>
                                    </div>
                                    <div class="col-4 text-end">
                                        <h5 class="mb-0 text-primary">{{ number_format($cartTotal, 3) }} OMR</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="mb-4">
                            <label for="shipping_address" class="form-label">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                Shipping Address <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                      id="shipping_address" name="shipping_address" rows="3" 
                                      placeholder="Enter your complete shipping address"
                                      required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-credit-card me-2"></i>
                                Payment Method <span class="text-danger">*</span>
                            </label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" 
                                               id="cash_on_delivery" value="cash_on_delivery" 
                                               {{ old('payment_method') == 'cash_on_delivery' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cash_on_delivery">
                                            <i class="fas fa-money-bill-wave me-2"></i>
                                            Cash on Delivery
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" 
                                               id="credit_card" value="credit_card"
                                               {{ old('payment_method') == 'credit_card' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="credit_card">
                                            <i class="fas fa-credit-card me-2"></i>
                                            Credit Card
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" 
                                               id="bank_transfer" value="bank_transfer"
                                               {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bank_transfer">
                                            <i class="fas fa-university me-2"></i>
                                            Bank Transfer
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('payment_method')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Order Notes -->
                        <div class="mb-4">
                            <label for="notes" class="form-label">
                                <i class="fas fa-sticky-note me-2"></i>
                                Order Notes (Optional)
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="Any special instructions for your order">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back to Cart
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-check me-2"></i>
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set default payment method
    const cashOnDelivery = document.getElementById('cash_on_delivery');
    if (cashOnDelivery && !document.querySelector('input[name="payment_method"]:checked')) {
        cashOnDelivery.checked = true;
    }
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!paymentMethod) {
            e.preventDefault();
            alert('Please select a payment method');
            return;
        }
        
        // Disable submit button to prevent double submission
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
    });
});
</script>
@endpush
@endsection