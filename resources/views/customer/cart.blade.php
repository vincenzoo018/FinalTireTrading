@extends('layouts.customer.app')

@section('content')
<!-- Cart Header -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">Shopping Cart</h1>
        <p class="lead">Review your selected items before checkout</p>
    </div>
</section>

<!-- Cart Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Cart Items -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Cart Items</h5>
                    </div>
                    <div class="card-body">
                        <!-- Example Item -->
                        <div class="row align-items-center mb-3">
                            <div class="col-md-4">
                                <h6 class="mb-0">Sample Product</h6>
                                <small class="text-muted">Product ID: 001</small>
                            </div>
                            <div class="col-md-2">
                                <span class="product-price">P500</span>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary" type="button">-</button>
                                    <input type="text" class="form-control text-center" value="1" readonly>
                                    <button class="btn btn-outline-secondary" type="button">+</button>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-center">
                                <span class="product-price">P500</span>
                                <button class="btn btn-sm btn-outline-danger ms-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <hr>
                        <!-- Repeat this block for more products -->
                        <div class="text-end">
                            <a href="{{ url('/checkout') }}" class="btn btn-primary">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>P500</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span>P200</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax:</span>
                            <span>P60</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong>P760</strong>
                        </div>
                        <a href="{{ url('/checkout') }}" class="btn btn-primary w-100">Checkout</a>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h6><i class="fas fa-shield-alt me-2"></i>Secure Shopping</h6>
                        <p class="small text-muted mb-0">
                            Your items are protected and securely processed. Review before completing checkout.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
