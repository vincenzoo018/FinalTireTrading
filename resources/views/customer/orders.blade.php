@extends('layouts.customer.app')

@section('content')
<!-- Orders Header -->
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
                    <!-- Order Card 1 -->
                    <div class="card order-card mb-4">
                        <div class="card-header bg-success text-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5 class="mb-0">
                                        <i class="fas fa-check-circle me-2"></i>Order #ORD-00123
                                    </h5>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <span class="badge bg-light text-success fs-6">Completed</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <small class="text-muted">Order Date</small>
                                    <div class="fw-bold">Dec 4, 2023</div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <small class="text-muted">Items</small>
                                    <div class="fw-bold">2 Products</div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <small class="text-muted">Total Amount</small>
                                    <div class="fw-bold text-success">P5,800</div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <small class="text-muted">Delivery</small>
                                    <div class="fw-bold">Delivered Dec 6, 2023</div>
                                </div>
                            </div>
                            <div class="order-items mt-3">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="/images/tire-1.jpg" alt="Product" class="order-item-img me-3">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Premium All-Terrain Tire</h6>
                                        <small class="text-muted">Quantity: 2 × P2,500</small>
                                    </div>
                                    <span class="text-success fw-bold">P5,000</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <img src="/images/tire-2.jpg" alt="Product" class="order-item-img me-3">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Wheel Alignment Service</h6>
                                        <small class="text-muted">Service Fee</small>
                                    </div>
                                    <span class="text-success fw-bold">P800</span>
                                </div>
                            </div>
                            <div class="order-actions mt-4">
                                <button class="btn btn-outline-primary btn-sm me-2" onclick="viewOrderDetails('ORD-00123')">
                                    <i class="fas fa-eye me-1"></i>View Details
                                </button>
                                <button class="btn btn-outline-success btn-sm me-2">
                                    <i class="fas fa-redo me-1"></i>Reorder
                                </button>
                                <button class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-file-invoice me-1"></i>Invoice
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Order Card 2 -->
                    <div class="card order-card mb-4">
                        <div class="card-header bg-warning text-dark">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5 class="mb-0">
                                        <i class="fas fa-clock me-2"></i>Order #ORD-00122
                                    </h5>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <span class="badge bg-light text-warning fs-6">Pending</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <small class="text-muted">Order Date</small>
                                    <div class="fw-bold">Dec 3, 2023</div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <small class="text-muted">Items</small>
                                    <div class="fw-bold">1 Product</div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <small class="text-muted">Total Amount</small>
                                    <div class="fw-bold text-success">P3,200</div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <small class="text-muted">Est. Delivery</small>
                                    <div class="fw-bold">Dec 5, 2023</div>
                                </div>
                            </div>
                            <div class="order-progress mb-3">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: 25%;"></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <small class="text-muted">Order Placed</small>
                                    <small class="text-muted">Processing</small>
                                    <small class="text-muted">Shipped</small>
                                    <small class="text-muted">Delivered</small>
                                </div>
                            </div>
                            <div class="order-items mt-3">
                                <div class="d-flex align-items-center">
                                    <img src="/images/tire-3.jpg" alt="Product" class="order-item-img me-3">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">High-Performance Tire</h6>
                                        <small class="text-muted">Quantity: 1 × P3,200</small>
                                    </div>
                                    <span class="text-success fw-bold">P3,200</span>
                                </div>
                            </div>
                            <div class="order-actions mt-4">
                                <button class="btn btn-outline-primary btn-sm me-2" onclick="trackOrder('ORD-00122')">
                                    <i class="fas fa-map-marker-alt me-1"></i>Track Order
                                </button>
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-times me-1"></i>Cancel Order
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Order Card 3 -->
                    <div class="card order-card mb-4">
                        <div class="card-header bg-info text-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5 class="mb-0">
                                        <i class="fas fa-shipping-fast me-2"></i>Order #ORD-00121
                                    </h5>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <span class="badge bg-light text-info fs-6">Shipped</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <small class="text-muted">Order Date</small>
                                    <div class="fw-bold">Dec 2, 2023</div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <small class="text-muted">Items</small>
                                    <div class="fw-bold">3 Products</div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <small class="text-muted">Total Amount</small>
                                    <div class="fw-bold text-success">P12,400</div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <small class="text-muted">Tracking</small>
                                    <div class="fw-bold">#TRK-789456</div>
                                </div>
                            </div>
                            <div class="order-progress mb-3">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-info" style="width: 75%;"></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <small class="text-success"><i class="fas fa-check-circle me-1"></i>Order Placed</small>
                                    <small class="text-success"><i class="fas fa-check-circle me-1"></i>Processing</small>
                                    <small class="text-info"><i class="fas fa-shipping-fast me-1"></i>Shipped</small>
                                    <small class="text-muted">Delivered</small>
                                </div>
                            </div>
                            <div class="shipping-info alert alert-info">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-truck fa-2x me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Out for Delivery</h6>
                                        <p class="mb-0">Your order is on the way. Expected delivery: Today by 6:00 PM</p>
                                    </div>
                                </div>
                            </div>
                            <div class="order-actions mt-4">
                                <button class="btn btn-outline-primary btn-sm me-2" onclick="trackOrder('ORD-00121')">
                                    <i class="fas fa-map-marker-alt me-1"></i>Live Tracking
                                </button>
                                <button class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-phone me-1"></i>Contact Carrier
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Order Card 4 -->
                    <div class="card order-card mb-4">
                        <div class="card-header bg-danger text-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5 class="mb-0">
                                        <i class="fas fa-times-circle me-2"></i>Order #ORD-00120
                                    </h5>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <span class="badge bg-light text-danger fs-6">Cancelled</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <small class="text-muted">Order Date</small>
                                    <div class="fw-bold">Dec 1, 2023</div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <small class="text-muted">Items</small>
                                    <div class="fw-bold">1 Product</div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <small class="text-muted">Total Amount</small>
                                    <div class="fw-bold text-muted">P2,500</div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <small class="text-muted">Cancelled On</small>
                                    <div class="fw-bold">Dec 2, 2023</div>
                                </div>
                            </div>
                            <div class="cancellation-reason alert alert-warning">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Cancellation Reason</h6>
                                <p class="mb-0">Order was cancelled per customer request. Refund processed successfully.</p>
                            </div>
                            <div class="order-items mt-3">
                                <div class="d-flex align-items-center">
                                    <img src="/images/tire-1.jpg" alt="Product" class="order-item-img me-3">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">All-Terrain Tire</h6>
                                        <small class="text-muted">Quantity: 1 × P2,500</small>
                                    </div>
                                    <span class="text-muted fw-bold">P2,500</span>
                                </div>
                            </div>
                            <div class="order-actions mt-4">
                                <button class="btn btn-outline-primary btn-sm me-2" onclick="viewOrderDetails('ORD-00120')">
                                    <i class="fas fa-eye me-1"></i>View Details
                                </button>
                                <button class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-redo me-1"></i>Reorder
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other Tabs (Pending, Shipped, Completed, Cancelled) -->
            <!-- Content would be similar but filtered - for brevity, we show the structure -->
            <div class="tab-pane fade" id="pending" role="tabpanel">
                <div class="text-center py-5">
                    <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                    <h5 class="text-muted">No Pending Orders</h5>
                    <p class="text-muted">You don't have any pending orders at the moment.</p>
                </div>
            </div>

            <div class="tab-pane fade" id="shipped" role="tabpanel">
                <!-- Shipped orders would go here -->
            </div>

            <div class="tab-pane fade" id="completed" role="tabpanel">
                <!-- Completed orders would go here -->
            </div>

            <div class="tab-pane fade" id="cancelled" role="tabpanel">
                <!-- Cancelled orders would go here -->
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
</style>
@endsection
