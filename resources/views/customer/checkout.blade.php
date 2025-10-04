@extends('layouts.customer.app')

@section('content')
<!-- Checkout Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="section-title text-start mb-2">Checkout</h1>
                <p class="lead mb-0">Complete your purchase with secure payment and fast delivery</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="checkout-steps">
                    <small class="text-muted">
                        <span class="badge bg-primary me-1">1</span> Cart →
                        <span class="badge bg-primary me-1">2</span> Checkout →
                        <span class="badge bg-secondary me-1">3</span> Confirmation
                    </small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Checkout Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Checkout Forms -->
            <div class="col-lg-8">
                <!-- Delivery Information -->
                <div class="card checkout-card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-truck me-2"></i>Delivery Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="shippingForm">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="shippingFirstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="shippingFirstName" value="{{ Auth::user()->fname }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="shippingLastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="shippingLastName" value="{{ Auth::user()->lname }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="shippingAddress" class="form-label">Address</label>
                                <textarea class="form-control" id="shippingAddress" rows="3" readonly>{{ Auth::user()->address }}</textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="shippingPhone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="shippingPhone" value="{{ Auth::user()->phone }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="shippingEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="shippingEmail" value="{{ Auth::user()->email }}" readonly>
                                </div>
                            </div>

                            <!-- Delivery Vehicle Selection -->
                            <div class="mb-3">
                                <label for="deliveryVehicle" class="form-label">Select Delivery Vehicle</label>
                                <select class="form-select" id="deliveryVehicle" name="delivery_vehicle_id" required>
                                    <option value="">Choose vehicle...</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->vehicle_id }}">
                                            {{ $vehicle->vehicle_name }} ({{ $vehicle->vehicle_plate_number }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @if($delivery)
                                <div class="mb-3">
                                    <label class="form-label">Latest Delivery Info</label>
                                    <div class="p-3 bg-light rounded">
                                        <strong>Receiving No:</strong> {{ $delivery->receiving_no }}<br>
                                        <strong>Delivery Date:</strong> {{ \Carbon\Carbon::parse($delivery->delivery_date)->format('M d, Y') }}<br>
                                        <strong>Shipping Fee:</strong> ₱{{ number_format($delivery->shipping_fee, 2) }}<br>
                                        <strong>Vehicle(s):</strong>
                                        <ul>
                                            @foreach($delivery->vehicles as $v)
                                                <li>{{ $v->vehicle_name }} ({{ $v->vehicle_plate_number }})</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card checkout-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-credit-card me-2"></i>Payment Method
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="payment-methods">
                                <div class="form-check payment-option mb-3">
                                    <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" checked>
                                    <label class="form-check-label w-100" for="creditCard">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-credit-card fa-2x text-primary me-3"></i>
                                            <div>
                                                <strong>Credit/Debit Card</strong>
                                                <small class="d-block text-muted">Pay securely with your card</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div class="form-check payment-option mb-3">
                                    <input class="form-check-input" type="radio" name="paymentMethod" id="paypal">
                                    <label class="form-check-label w-100" for="paypal">
                                        <div class="d-flex align-items-center">
                                            <i class="fab fa-paypal fa-2x text-primary me-3"></i>
                                            <div>
                                                <strong>PayPal</strong>
                                                <small class="d-block text-muted">Fast and secure online payments</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div class="form-check payment-option">
                                    <input class="form-check-input" type="radio" name="paymentMethod" id="bankTransfer">
                                    <label class="form-check-label w-100" for="bankTransfer">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-university fa-2x text-primary me-3"></i>
                                            <div>
                                                <strong>Bank Transfer</strong>
                                                <small class="d-block text-muted">Transfer directly to our bank account</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>



                        <!-- PayPal Form (Hidden by default) -->
                        <div id="paypalForm" class="payment-form" style="display: none;">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                You will be redirected to PayPal to complete your payment securely.
                            </div>
                            <button type="button" class="btn btn-primary w-100" onclick="processPayPal()">
                                <i class="fab fa-paypal me-2"></i>Continue to PayPal
                            </button>
                        </div>

                        <!-- Bank Transfer Form (Hidden by default) -->
                        <div id="bankTransferForm" class="payment-form" style="display: none;">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Please transfer the amount to our bank account. Your order will be processed after we receive the payment.
                            </div>
                            <div class="bank-details p-3 bg-light rounded">
                                <h6 class="mb-3">Bank Transfer Details</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Bank Name:</strong> BDO<br>
                                        <strong>Account Name:</strong> 8PLY TIRE AND SERVICES<br>
                                        <strong>Account Number:</strong> 1234-5678-9012
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Amount:</strong> <span id="transferAmount">P9,184</span><br>
                                        <strong>Reference:</strong> <span id="transferReference">8PLY-2024-001</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card order-summary-card sticky-top">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>Order Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Order Items -->
                        <div class="order-items mb-3">
                            @php
                                $subtotal = 0;
                            @endphp
                            @foreach($cartItems as $cart)
                                <div class="order-item d-flex justify-content-between align-items-start mb-2">
                                    <div class="item-info">
                                        <strong>{{ $cart->product->product_name }}</strong>
                                        <small class="text-muted d-block">₱{{ number_format($cart->product->selling_price, 2) }} x {{ $cart->quantity }}</small>
                                    </div>
                                    <span class="item-price">₱{{ number_format($cart->product->selling_price * $cart->quantity, 2) }}</span>
                                </div>
                                @php
                                    $subtotal += $cart->product->selling_price * $cart->quantity;
                                @endphp
                            @endforeach
                        </div>

                        <hr>

                        <!-- Order Totals -->
                        <div class="order-totals">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span id="checkoutSubtotal">₱{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span id="checkoutShipping">₱200</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax (12%):</span>
                                <span id="checkoutTax">₱{{ number_format($subtotal * 0.12, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Discount:</span>
                                <span id="checkoutDiscount">-₱0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong class="fs-5">Total:</strong>
                                <strong class="fs-5 text-primary" id="checkoutTotal">₱{{ number_format($subtotal + 200 + ($subtotal * 0.12), 2) }}</strong>
                            </div>
                        </div>

                        <!-- Complete Purchase Button -->
                        <form action="{{ route('customer.checkout.complete') }}" method="POST">
                            @csrf
                            <input type="hidden" name="payment_method" value="Credit Card"> <!-- Example -->
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-lock me-2"></i>Complete Purchase
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Support Card -->

            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Billing address toggle
    document.getElementById('billingSame').addEventListener('change', function() {
        const billingSection = document.getElementById('billingAddress');
        billingSection.style.display = this.checked ? 'none' : 'block';
    });

    // Payment method toggle
    document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Hide all payment forms
            document.querySelectorAll('.payment-form').forEach(form => {
                form.style.display = 'none';
            });

            // Show selected payment form
            const selectedForm = document.getElementById(this.id + 'Form');
            if (selectedForm) {
                selectedForm.style.display = 'block';
            }
        });
    });

    // Card number formatting
    document.getElementById('cardNumber').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        let matches = value.match(/\d{4,16}/g);
        let match = matches && matches[0] || '';
        let parts = [];

        for (let i = 0, len = match.length; i < len; i += 4) {
            parts.push(match.substring(i, i + 4));
        }

        if (parts.length) {
            e.target.value = parts.join(' ');
        } else {
            e.target.value = value;
        }
    });

    // Expiry date formatting
    document.getElementById('expiryDate').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        e.target.value = value;
    });
});

function applyCheckoutPromo() {
    const promoCode = document.getElementById('checkoutPromoCode').value.toUpperCase();
    const promoMessage = document.getElementById('checkoutPromoMessage');

    const validCodes = {
        'WELCOME10': 0.1,
        'SAVE15': 0.15,
        'FIRSTORDER': 0.2
    };

    if (validCodes[promoCode]) {
        const discountRate = validCodes[promoCode];
        const subtotal = parseFloat(document.getElementById('checkoutSubtotal').textContent.replace('P', '').replace(',', ''));
        const discount = Math.round(subtotal * discountRate);

        document.getElementById('checkoutDiscount').textContent = '-P' + discount.toLocaleString();
        promoMessage.innerHTML = '<span class="text-success">Promo code applied successfully!</span>';

        // Update total with discount
        const shipping = parseFloat(document.getElementById('checkoutShipping').textContent.replace('P', '').replace(',', '') || 0);
        const tax = parseFloat(document.getElementById('checkoutTax').textContent.replace('P', '').replace(',', ''));
        const total = subtotal + shipping + tax - discount;

        document.getElementById('checkoutTotal').textContent = 'P' + total.toLocaleString();
        document.getElementById('transferAmount').textContent = 'P' + total.toLocaleString();
    } else {
        document.getElementById('checkoutDiscount').textContent = '-P0';
        promoMessage.innerHTML = '<span class="text-danger">Invalid promo code. Please try again.</span>';
        updateCheckoutTotals();
    }
}

function updateCheckoutTotals() {
    // This function would recalculate totals based on cart items
    // For now, we're using static values
    const subtotal = 8200;
    const shipping = 200;
    const tax = 984;
    const total = subtotal + shipping + tax;

    document.getElementById('checkoutSubtotal').textContent = 'P' + subtotal.toLocaleString();
    document.getElementById('checkoutShipping').textContent = 'P' + shipping.toLocaleString();
    document.getElementById('checkoutTax').textContent = 'P' + tax.toLocaleString();
    document.getElementById('checkoutTotal').textContent = 'P' + total.toLocaleString();
    document.getElementById('transferAmount').textContent = 'P' + total.toLocaleString();
}

function processPayPal() {
    // Simulate PayPal processing
    const btn = document.querySelector('#paypalForm .btn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Redirecting...';
    btn.disabled = true;

    setTimeout(() => {
        completePurchase();
    }, 2000);
}

function completePurchase() {
    if (!document.getElementById('termsAgreement').checked) {
        alert('Please agree to the Terms and Conditions to continue.');
        return;
    }

    // Validate forms
    const shippingForm = document.getElementById('shippingForm');
    if (!shippingForm.checkValidity()) {
        shippingForm.reportValidity();
        return;
    }

    const selectedPayment = document.querySelector('input[name="paymentMethod"]:checked').id;
    if (selectedPayment === 'creditCard') {
        const cardForm = document.getElementById('creditCardForm');
        const inputs = cardForm.querySelectorAll('input[required]');
        for (let input of inputs) {
            if (!input.value.trim()) {
                alert('Please complete all required payment information.');
                input.focus();
                return;
            }
        }
    }

    // Show processing state
    const btn = document.getElementById('completePurchaseBtn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
    btn.disabled = true;

    // Simulate payment processing
    setTimeout(() => {
        // Show success message
        alert('Order placed successfully! Thank you for your purchase. You will receive a confirmation email shortly.');

        // Redirect to order confirmation page
        window.location.href = "{{ route('customer.orders') }}";
    }, 3000);
}

// Generate random reference number
document.getElementById('transferReference').textContent = '8PLY-' +
    new Date().getFullYear() + '-' +
    Math.random().toString(36).substr(2, 9).toUpperCase();
</script>

<style>
.checkout-card, .order-summary-card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.payment-option {
    padding: 1rem;
    border: 2px solid #e9ecef;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
}

.payment-option:hover {
    border-color: #3498db;
    background: rgba(52, 152, 219, 0.05);
}

.payment-option .form-check-input {
    margin-top: 0.5rem;
}

.card-icons img {
    height: 25px;
    border-radius: 3px;
}

.bank-details {
    border-left: 4px solid #3498db;
}

.support-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #3498db, #2980b9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin: 0 auto;
}

.trust-badges .badge {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}

.order-item {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.order-item:last-child {
    border-bottom: none;
}

.sticky-top {
    position: sticky;
    z-index: 10;
    top: 2rem;
}

.billing-section {
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .order-summary-card {
        position: static !important;
        margin-bottom: 2rem;
    }

    .checkout-steps {
        text-align: center !important;
        margin-top: 1rem;
    }

    .payment-option .d-flex {
        flex-direction: column;
        text-align: center;
    }

    .payment-option i {
        margin-bottom: 0.5rem;
    }
}
</style>
@endsection
