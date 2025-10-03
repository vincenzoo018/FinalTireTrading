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
                <!-- Shipping Information -->
                <div class="card checkout-card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-truck me-2"></i>Shipping Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="shippingForm">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="shippingFirstName" class="form-label">
                                        <i class="fas fa-user me-1 text-primary"></i>First Name
                                    </label>
                                    <input type="text" class="form-control" id="shippingFirstName" value="Juan" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="shippingLastName" class="form-label">
                                        <i class="fas fa-user me-1 text-primary"></i>Last Name
                                    </label>
                                    <input type="text" class="form-control" id="shippingLastName" value="Dela Cruz" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="shippingAddress" class="form-label">
                                    <i class="fas fa-map-marker-alt me-1 text-primary"></i>Address
                                    </label>
                                <textarea class="form-control" id="shippingAddress" rows="3" required>123 Main Street, Cebu City</textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="shippingCity" class="form-label">City</label>
                                    <input type="text" class="form-control" id="shippingCity" value="Cebu City" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="shippingProvince" class="form-label">Province</label>
                                    <input type="text" class="form-control" id="shippingProvince" value="Cebu" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="shippingZip" class="form-label">ZIP Code</label>
                                    <input type="text" class="form-control" id="shippingZip" value="6000" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="shippingPhone" class="form-label">
                                    <i class="fas fa-phone me-1 text-primary"></i>Phone Number
                                </label>
                                <input type="tel" class="form-control" id="shippingPhone" value="0912-345-6789" required>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="billingSame" checked>
                                <label class="form-check-label" for="billingSame">
                                    Billing address is the same as shipping address
                                </label>
                            </div>

                            <!-- Billing Address (Hidden by default) -->
                            <div id="billingAddress" class="billing-section" style="display: none;">
                                <hr>
                                <h6 class="mb-3">
                                    <i class="fas fa-credit-card me-2 text-primary"></i>Billing Address
                                </h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="billingFirstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="billingFirstName">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="billingLastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="billingLastName">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="billingAddress" class="form-label">Address</label>
                                    <textarea class="form-control" id="billingAddress" rows="2"></textarea>
                                </div>
                            </div>
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

                        <!-- Credit Card Form -->
                        <div id="creditCardForm" class="payment-form">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="cardNumber" class="form-label">Card Number</label>
                                    <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19">
                                    <div class="card-icons mt-2">
                                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='25' viewBox='0 0 40 25'%3E%3Crect width='40' height='25' fill='%231a237e' rx='3'/%3E%3Ctext x='20' y='15' font-family='Arial' font-size='8' text-anchor='middle' fill='white'%3EVisa%3C/text%3E%3C/svg%3E" alt="Visa" class="me-1">
                                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='25' viewBox='0 0 40 25'%3E%3Crect width='40' height='25' fill='%23ff5f00' rx='3'/%3E%3Ctext x='20' y='15' font-family='Arial' font-size='6' text-anchor='middle' fill='white'%3EMastercard%3C/text%3E%3C/svg%3E" alt="Mastercard">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="expiryDate" class="form-label">Expiry Date</label>
                                    <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" maxlength="5">
                                </div>
                                <div class="col-md-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="cvv" placeholder="123" maxlength="4">
                                        <span class="input-group-text" data-bs-toggle="tooltip" title="3 or 4 digit security code">
                                            <i class="fas fa-question-circle text-muted"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="cardName" class="form-label">Name on Card</label>
                                <input type="text" class="form-control" id="cardName" placeholder="JUAN DELA CRUZ">
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
                            <div class="order-item d-flex justify-content-between align-items-start mb-2">
                                <div class="item-info">
                                    <h6 class="mb-1">Premium All-Terrain Tire</h6>
                                    <small class="text-muted">Qty: 2 × P2,500</small>
                                </div>
                                <span class="item-price">P5,000</span>
                            </div>
                            <div class="order-item d-flex justify-content-between align-items-start mb-2">
                                <div class="item-info">
                                    <h6 class="mb-1">High-Performance Tire</h6>
                                    <small class="text-muted">Qty: 1 × P3,200</small>
                                </div>
                                <span class="item-price">P3,200</span>
                            </div>
                        </div>

                        <hr>

                        <!-- Order Totals -->
                        <div class="order-totals">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span id="checkoutSubtotal">P8,200</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span id="checkoutShipping">P200</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax (12%):</span>
                                <span id="checkoutTax">P984</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Discount:</span>
                                <span id="checkoutDiscount">-P0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong class="fs-5">Total:</strong>
                                <strong class="fs-5 text-primary" id="checkoutTotal">P9,184</strong>
                            </div>
                        </div>

                        <!-- Promo Code -->
                        <div class="promo-section mb-3">
                            <label for="checkoutPromoCode" class="form-label small">Promo Code</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="checkoutPromoCode" placeholder="Enter code">
                                <button class="btn btn-outline-primary" type="button" onclick="applyCheckoutPromo()">
                                    Apply
                                </button>
                            </div>
                            <div id="checkoutPromoMessage" class="mt-1 small"></div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="terms-section mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="termsAgreement" required>
                                <label class="form-check-label small" for="termsAgreement">
                                    I agree to the <a href="#" class="text-primary">Terms and Conditions</a> and <a href="#" class="text-primary">Privacy Policy</a>
                                </label>
                            </div>
                        </div>

                        <!-- Complete Purchase Button -->
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary btn-lg" onclick="completePurchase()" id="completePurchaseBtn">
                                <i class="fas fa-lock me-2"></i>Complete Purchase
                            </button>
                        </div>

                        <!-- Security Badges -->
                        <div class="security-badges text-center mt-3">
                            <small class="text-muted d-block mb-2">
                                <i class="fas fa-shield-alt me-1 text-success"></i>
                                256-bit SSL Secured
                            </small>
                            <div class="trust-badges d-flex justify-content-center gap-2">
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-lock me-1"></i>Secure
                                </span>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-shield-alt me-1"></i>Protected
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Support Card -->
                <div class="card mt-4">
                    <div class="card-body text-center">
                        <div class="support-icon mb-3">
                            <i class="fas fa-headset fa-2x text-primary"></i>
                        </div>
                        <h6>Need Help with Checkout?</h6>
                        <p class="small text-muted mb-3">Our support team is ready to assist you</p>
                        <div class="contact-options">
                            <button class="btn btn-outline-primary btn-sm w-100 mb-2">
                                <i class="fas fa-comment-dots me-1"></i>Live Chat
                            </button>
                            <a href="tel:+631234567890" class="btn btn-outline-primary btn-sm w-100">
                                <i class="fas fa-phone me-1"></i>Call Support
                            </a>
                        </div>
                    </div>
                </div>
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
