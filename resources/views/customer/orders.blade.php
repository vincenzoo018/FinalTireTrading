@extends('layouts.customer.app')

@section('styles')
<style>
    /* Order Card Styles */
    .booking-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .booking-id {
        font-weight: bold;
        font-size: 18px;
        color: #6a11cb;
    }

    .booking-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-pending {
        background-color: #fff3e0;
        color: #ff9800;
    }

    .status-confirmed {
        background-color: #e3f2fd;
        color: #2196f3;
    }

    .status-completed {
        background-color: #e8f5e9;
        color: #4caf50;
    }

    .status-cancelled {
        background-color: #ffebee;
        color: #f44336;
    }

    .booking-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
    }

    .detail-label {
        font-size: 12px;
        color: #888;
        margin-bottom: 5px;
    }

    .detail-value {
        font-size: 14px;
        font-weight: 500;
    }

    .service-info {
        margin-top: 15px;
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 8px;
    }

    .service-name {
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .service-price {
        font-weight: 600;
        color: #6a11cb;
        font-size: 16px;
    }

    .order-card {
        transition: transform 0.3s ease;
    }

    .order-card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="section-title text-start mb-2">My Orders</h1>
                <p class="lead mb-0">Track and manage your orders in one place. Stay updated on your purchases and services.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex align-items-center justify-content-lg-end">
                    <span class="badge bg-primary fs-6">
                        <i class="fas fa-shopping-bag me-1"></i>4 Orders
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Orders Section -->
<section class="py-5">
    <div class="container">
        <!-- Order Statistics -->
        <div class="row mb-5">
            <div class="col-md-3 col-6 mb-3">
                <div class="stat-card text-center">
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h4 class="stat-number">1</h4>
                    <p class="stat-label">Pending</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="stat-card text-center">
                    <div class="stat-icon bg-info">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h4 class="stat-number">1</h4>
                    <p class="stat-label">Shipped</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="stat-card text-center">
                    <div class="stat-icon bg-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h4 class="stat-number">1</h4>
                    <p class="stat-label">Completed</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-3">
                <div class="stat-card text-center">
                    <div class="stat-icon bg-danger">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <h4 class="stat-number">1</h4>
                    <p class="stat-label">Cancelled</p>
                </div>
            </div>
        </div>

        <!-- Orders Tabs -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <ul class="nav nav-tabs nav-justified" id="ordersTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                                    <i class="fas fa-list me-2"></i>All Orders
                                    <span class="badge bg-primary ms-2">4</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                                    <i class="fas fa-clock me-2"></i>Pending
                                    <span class="badge bg-warning ms-2">1</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="shipped-tab" data-bs-toggle="tab" data-bs-target="#shipped" type="button" role="tab">
                                    <i class="fas fa-shipping-fast me-2"></i>Shipped
                                    <span class="badge bg-info ms-2">1</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">
                                    <i class="fas fa-check-circle me-2"></i>Completed
                                    <span class="badge bg-success ms-2">1</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab">
                                    <i class="fas fa-times-circle me-2"></i>Cancelled
                                    <span class="badge bg-danger ms-2">1</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content" id="ordersTabContent">
            <!-- All Orders -->
            <div class="tab-pane fade show active" id="all" role="tabpanel">
                <div class="orders-list">
                    @foreach($orders as $order)
                        <div class="card order-card mb-4 border-0 shadow-sm">
                            <div class="card-header border-0">
                                <div class="booking-header">
                                    <div class="booking-id">
                                        Order #{{ $order->order_id }}
                                    </div>
                                    @php
                                        $status = strtolower($order->status);
                                        $displayStatus = $status === 'approved' ? 'Shipped' : ucfirst($status);
                                        $statusClass = match($status) {
                                            'pending' => 'status-pending',
                                            'approved', 'shipped' => 'status-confirmed',
                                            'completed' => 'status-completed',
                                            'cancelled' => 'status-cancelled',
                                            default => 'status-pending'
                                        };
                                    @endphp
                                    <span class="booking-status {{ $statusClass }}">{{ $displayStatus }}</span>
                                </div>
                                
                                <div class="booking-details">
                                    <div class="detail-item">
                                        <span class="detail-label">Order Date</span>
                                        <span class="detail-value">{{ \Carbon\Carbon::parse($order->order_date)->format('F d, Y') }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Total Amount</span>
                                        <span class="detail-value">₱{{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Payment Method</span>
                                        <span class="detail-value">{{ $order->payment_method ?? 'Cash on Delivery' }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Items</span>
                                        <span class="detail-value">{{ count($order->items) }} items</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-3 fw-bold text-primary">
                                    <i class="fas fa-box me-2"></i>Order Items
                                </h6>
                                @forelse($order->items as $item)
                                    @if($item->product)
                                        <div class="order-item-card mb-3 p-3 border rounded-3 bg-light">
                                            <div class="row align-items-center g-3">
                                                <div class="col-auto">
                                                    <div class="product-image-wrapper">
                                                        @if($item->product->image)
                                                            <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->product_name }}"
                                                                class="product-image rounded-3 shadow-sm">
                                                        @else
                                                            <img src="{{ asset('images/default-product.png') }}" alt="Default Product"
                                                                class="product-image rounded-3 shadow-sm">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="product-details">
                                                        <h6 class="product-name mb-2 fw-bold text-dark">{{ $item->product->product_name }}</h6>
                                                        <div class="product-specs d-flex flex-wrap gap-3 mb-2">
                                                            <span class="spec-item">
                                                                <i class="fas fa-tag text-primary me-1"></i>
                                                                <small class="text-muted">Brand: <strong>{{ $item->product->brand ?? '-' }}</strong></small>
                                                            </span>
                                                            <span class="spec-item">
                                                                <i class="fas fa-expand-arrows-alt text-success me-1"></i>
                                                                <small class="text-muted">Size: <strong>{{ $item->product->size ?? '-' }}</strong></small>
                                                            </span>
                                                            <span class="spec-item">
                                                                <i class="fas fa-barcode text-info me-1"></i>
                                                                <small class="text-muted">Serial: <strong>{{ $item->product->serial_number ?? '-' }}</strong></small>
                                                            </span>
                                                        </div>
                                                        <p class="product-description mb-0">
                                                            <small class="text-muted">{{ $item->product->description ?? 'No description available' }}</small>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-auto text-end">
                                                    <div class="pricing-info">
                                                        <div class="unit-price mb-1">
                                                            <small class="text-muted">Unit Price:</small>
                                                            <div class="fw-semibold text-primary">₱{{ number_format($item->price, 2) }}</div>
                                                        </div>
                                                        <div class="quantity mb-2">
                                                            <small class="text-muted">Quantity:</small>
                                                            <div class="fw-semibold">{{ $item->quantity }}</div>
                                                        </div>
                                                        <div class="total-price">
                                                            <small class="text-muted">Total:</small>
                                                            <div class="fw-bold text-success fs-5">₱{{ number_format($item->price * $item->quantity, 2) }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <div class="empty-state text-center py-4">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No products found for this order.</p>
                                    </div>
                                @endforelse

                                @if(strtolower($order->status) === 'pending')
                                    <form action="{{ route('customer.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Cancel this pending order?')">
                                        @csrf
                                        <div class="d-flex align-items-center gap-2 mt-3">
                                            <input type="text" name="cancelled_reason" class="form-control" placeholder="Optional reason">
                                            <button class="btn btn-outline-danger">
                                                <i class="fas fa-times me-1"></i>Cancel Order
                                            </button>
                                        </div>
                                    </form>
                                @elseif(in_array(strtolower($order->status), ['approved','shipped']))
                                    <form action="{{ route('customer.orders.receive', $order) }}" method="POST" onsubmit="return confirm('Mark this order as received?')">
                                        @csrf
                                        <button class="btn btn-success mt-3">
                                            <i class="fas fa-box-open me-1"></i>Received
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pending Tab -->
            <div class="tab-pane fade" id="pending" role="tabpanel">
                <div class="orders-list">
                    @foreach($orders->where('status','pending') as $order)
                        <div class="card order-card mb-4">
                            <div class="card-header bg-warning text-white">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h6>Order ID: {{ $order->order_id }}</h6>
                                        <p class="mb-0">Order Date: {{ \Carbon\Carbon::parse($order->order_date)->format('F d, Y') }}</p>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <h6>Total: ₱{{ number_format($order->total_amount, 2) }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6>Order Items:</h6>
                                @foreach($order->items as $item)
                                    @if($item->product)
                                        <div class="d-flex align-items-start mb-3 p-3 border rounded">
                                            <div class="flex-grow-1">
                                                <strong>{{ $item->product->product_name }}</strong>
                                                <div class="text-muted small">
                                                    Price: ₱{{ number_format($item->price, 2) }} | Qty: {{ $item->quantity }}
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <strong>₱{{ number_format($item->price * $item->quantity, 2) }}</strong>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <form action="{{ route('customer.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Cancel this pending order?')">
                                    @csrf
                                    <button class="btn btn-outline-danger mt-2">
                                        <i class="fas fa-times me-1"></i>Cancel Order
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipped Tab (Approved) -->
            <div class="tab-pane fade" id="shipped" role="tabpanel">
                <div class="orders-list">
                    @foreach($orders->filter(function($o){ return in_array(strtolower($o->status), ['approved','shipped']); }) as $order)
                        <div class="card order-card mb-4">
                            <div class="card-header bg-info text-white">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h6>Order ID: {{ $order->order_id }}</h6>
                                        <p class="mb-0">Approved: {{ optional($order->approved_date)->format('F d, Y H:i') }}</p>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <h6>Total: ₱{{ number_format($order->total_amount, 2) }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6>Order Items:</h6>
                                @foreach($order->items as $item)
                                    @if($item->product)
                                        <div class="d-flex align-items-start mb-3 p-3 border rounded">
                                            <div class="flex-grow-1">
                                                <strong>{{ $item->product->product_name }}</strong>
                                                <div class="text-muted small">
                                                    Price: ₱{{ number_format($item->price, 2) }} | Qty: {{ $item->quantity }}
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <strong>₱{{ number_format($item->price * $item->quantity, 2) }}</strong>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <form action="{{ route('customer.orders.receive', $order) }}" method="POST" onsubmit="return confirm('Mark this order as received?')">
                                    @csrf
                                    <button class="btn btn-success">
                                        <i class="fas fa-box-open me-1"></i>Received
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Completed Tab -->
            <div class="tab-pane fade" id="completed" role="tabpanel">
                <div class="orders-list">
                    @foreach($orders->where('status','completed') as $order)
                        <div class="card order-card mb-4">
                            <div class="card-header bg-success text-white">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h6>Order ID: {{ $order->order_id }}</h6>
                                        <p class="mb-0">Received: {{ optional($order->received_date)->format('F d, Y H:i') }}</p>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <h6>Total: ₱{{ number_format($order->total_amount, 2) }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6>Order Items:</h6>
                                @foreach($order->items as $item)
                                    @if($item->product)
                                        <div class="d-flex align-items-start mb-3 p-3 border rounded">
                                            <div class="flex-grow-1">
                                                <strong>{{ $item->product->product_name }}</strong>
                                                <div class="text-muted small">
                                                    Price: ₱{{ number_format($item->price, 2) }} | Qty: {{ $item->quantity }}
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <strong>₱{{ number_format($item->price * $item->quantity, 2) }}</strong>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <nav aria-label="Order pagination" class="mt-5">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">
                        <i class="fas fa-chevron-left me-2"></i>Previous
                    </a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">
                        Next<i class="fas fa-chevron-right ms-2"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</section>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="orderDetailsModalLabel">
                    <i class="fas fa-file-invoice me-2"></i>Order Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Order details would be loaded here dynamically -->
                <div id="orderDetailsContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-print me-2"></i>Print Invoice
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function viewOrderDetails(orderId) {
    // Simulate loading order details
    const modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
    document.getElementById('orderDetailsModalLabel').textContent = `Order Details - ${orderId}`;

    // Show loading state
    document.getElementById('orderDetailsContent').innerHTML = `
        <div class="text-center py-4">
            <i class="fas fa-spinner fa-spin fa-2x text-primary mb-3"></i>
            <p>Loading order details...</p>
        </div>
    `;

    modal.show();

    // Simulate API call
    setTimeout(() => {
        document.getElementById('orderDetailsContent').innerHTML = `
            <div class="order-detail-content">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Order Information</h6>
                        <p><strong>Order ID:</strong> ${orderId}</p>
                        <p><strong>Order Date:</strong> Dec 4, 2023</p>
                        <p><strong>Status:</strong> <span class="badge bg-success">Completed</span></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Customer Information</h6>
                        <p><strong>Name:</strong> Juan Dela Cruz</p>
                        <p><strong>Email:</strong> juan.delacruz@example.com</p>
                        <p><strong>Phone:</strong> 0912-345-6789</p>
                    </div>
                </div>

                <div class="order-items-detail">
                    <h6>Order Items</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Premium All-Terrain Tire</td>
                                    <td>P2,500</td>
                                    <td>2</td>
                                    <td>P5,000</td>
                                </tr>
                                <tr>
                                    <td>Wheel Alignment Service</td>
                                    <td>P800</td>
                                    <td>1</td>
                                    <td>P800</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="order-summary-detail mt-4">
                    <div class="row justify-content-end">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>P5,800</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span>P200</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax:</span>
                                <span>P696</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total:</span>
                                <span>P6,696</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }, 1000);
}

function trackOrder(orderId) {
    alert(`Tracking order: ${orderId}\n\nThis would open the order tracking page with real-time updates.`);
}

// Initialize tab functionality
document.addEventListener('DOMContentLoaded', function() {
    // Add animation to order cards
    const orderCards = document.querySelectorAll('.order-card');
    orderCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in-up');
    });
});
</script>

<style>
.order-card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
    transform: translateY(20px);
}

.order-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.order-card .card-header {
    border-radius: 1rem 1rem 0 0 !important;
    border: none;
}

.order-item-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 0.5rem;
}

.stat-card {
    padding: 1.5rem;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #6c757d;
    font-weight: 500;
}

.nav-tabs .nav-link {
    border: none;
    padding: 1rem 1.5rem;
    font-weight: 500;
    color: #6c757d;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link.active {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    border-radius: 0;
}

.nav-tabs .nav-link:hover:not(.active) {
    background: #f8f9fa;
    color: #3498db;
}

.order-progress .progress {
    border-radius: 1rem;
}

.shipping-info, .cancellation-reason {
    border: none;
    border-radius: 0.75rem;
    border-left: 4px solid;
}

.shipping-info {
    border-left-color: #17a2b8;
}

.cancellation-reason {
    border-left-color: #ffc107;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .order-card .row > div {
        margin-bottom: 1rem;
    }

    .order-item-img {
        width: 50px;
        height: 50px;
    }

    .nav-tabs .nav-link {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }

    .stat-card {
        padding: 1rem;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }

    .stat-number {
        font-size: 1.5rem;
    }
}

/* Enhanced Order Item Cards */
.order-item-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border: 1px solid #e3e6f0 !important;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.order-item-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    border-color: #3498db !important;
}

.order-item-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(135deg, #3498db, #2980b9);
}

.product-image-wrapper {
    position: relative;
}

.product-image {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border: 3px solid #fff;
    transition: transform 0.3s ease;
}

.order-item-card:hover .product-image {
    transform: scale(1.05);
}

.product-details .product-name {
    color: #2c3e50;
    font-size: 1.1rem;
    line-height: 1.3;
}

.product-specs {
    margin: 0;
}

.spec-item {
    background: rgba(52, 152, 219, 0.1);
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
    border: 1px solid rgba(52, 152, 219, 0.2);
}

.pricing-info {
    background: rgba(255, 255, 255, 0.8);
    padding: 1rem;
    border-radius: 0.5rem;
    border: 1px solid #e9ecef;
    min-width: 140px;
}

.pricing-info .unit-price,
.pricing-info .quantity {
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #f1f3f4;
}

.pricing-info .total-price {
    background: linear-gradient(135deg, #27ae60, #2ecc71);
    color: white;
    margin: 0.5rem -1rem -1rem -1rem;
    padding: 0.75rem 1rem;
    border-radius: 0 0 0.5rem 0.5rem;
    text-align: center;
}

.pricing-info .total-price .fw-bold {
    color: white !important;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.empty-state {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 1rem;
    border: 2px dashed #dee2e6;
}
</style>
@endsection
