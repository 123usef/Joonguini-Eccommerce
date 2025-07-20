@extends('Layout.Base')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                    <h3 class="mb-0">Order Confirmed!</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <h5>Thank you for your order!</h5>
                        <p class="text-muted">Your order has been placed successfully and is being processed.</p>
                    </div>

                    <!-- Order Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-receipt me-2"></i>
                                        Order Details
                                    </h6>
                                    <p class="mb-1"><strong>Order Number:</strong> {{ $order->order_number }}</p>
                                    <p class="mb-1"><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                                    <p class="mb-1"><strong>Status:</strong> 
                                        <span class="badge bg-{{ $order->status_color }}">{{ ucfirst($order->status) }}</span>
                                    </p>
                                    <p class="mb-0"><strong>Total:</strong> 
                                        <span class="text-primary h6">{{ $order->formatted_total }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-credit-card me-2"></i>
                                        Payment Details
                                    </h6>
                                    <p class="mb-1"><strong>Payment Method:</strong> {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                                    <p class="mb-1"><strong>Payment Status:</strong> 
                                        <span class="badge bg-warning">{{ ucfirst($order->payment_status) }}</span>
                                    </p>
                                    <p class="mb-0"><strong>Amount:</strong> {{ $order->formatted_total }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="mb-4">
                        <h6>
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Shipping Address
                        </h6>
                        <div class="bg-light p-3 rounded">
                            {{ $order->shipping_address }}
                        </div>
                    </div>

                    @if($order->notes)
                    <!-- Order Notes -->
                    <div class="mb-4">
                        <h6>
                            <i class="fas fa-sticky-note me-2"></i>
                            Order Notes
                        </h6>
                        <div class="bg-light p-3 rounded">
                            {{ $order->notes }}
                        </div>
                    </div>
                    @endif

                    <!-- Order Items -->
                    <div class="mb-4">
                        <h6>
                            <i class="fas fa-box me-2"></i>
                            Order Items ({{ $order->total_items }} items)
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->product->image_url ?: '/images/placeholder-product.svg' }}" alt="{{ $item->product->name }}" 
                                                     class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;"
                                                     onerror="this.src='/images/placeholder-product.svg'">
                                                <div>
                                                    <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                    <small class="text-muted">{{ $item->product->category->name ?? 'Uncategorized' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->formatted_price }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->formatted_total }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-primary">
                                        <th colspan="3" class="text-end">Total:</th>
                                        <th>{{ $order->formatted_total }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i>
                            Continue Shopping
                        </a>
                        <div>
                            <a href="{{ route('orders.index') }}" class="btn btn-primary">
                                <i class="fas fa-list me-2"></i>
                                View All Orders
                            </a>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-eye me-2"></i>
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.fa-check-circle {
    animation: checkmark 0.6s ease-in-out;
}

@keyframes checkmark {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
    }
}
</style>
@endpush
@endsection