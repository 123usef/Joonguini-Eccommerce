@extends('Layout.Base')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>
                            Order Details
                        </h4>
                        <span class="badge bg-{{ $order->status_color }} fs-6">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Order Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>
                                <i class="fas fa-info-circle me-2"></i>
                                Order Information
                            </h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td><strong>Order Number:</strong></td>
                                    <td>{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Order Date:</strong></td>
                                    <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $order->status_color }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Total Items:</strong></td>
                                    <td>{{ $order->total_items }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>
                                <i class="fas fa-credit-card me-2"></i>
                                Payment Information
                            </h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td><strong>Payment Method:</strong></td>
                                    <td>{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Status:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Total Amount:</strong></td>
                                    <td>
                                        <strong class="text-primary h6">{{ $order->formatted_total }}</strong>
                                    </td>
                                </tr>
                            </table>
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
                            Order Items
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
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" 
                                                     class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
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
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Orders
                        </a>
                        <div>
                            <a href="{{ route('index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-home me-2"></i>
                                Continue Shopping
                            </a>
                            @if($order->status === 'pending')
                            <button class="btn btn-outline-danger" onclick="confirmCancelOrder()">
                                <i class="fas fa-times me-2"></i>
                                Cancel Order
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmCancelOrder() {
    if (confirm('Are you sure you want to cancel this order?')) {
        // Add cancel order functionality here
        alert('Order cancellation functionality will be implemented');
    }
}
</script>
@endpush
@endsection