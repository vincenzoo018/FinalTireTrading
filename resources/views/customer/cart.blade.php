@extends('layouts.customer.app')

@section('content')
<!-- Cart Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="section-title text-start mb-2">Shopping Cart</h1>
                <p class="lead mb-0">Review your selected items before proceeding to checkout</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex align-items-center justify-content-lg-end">
                    <span class="badge bg-primary fs-6" id="cartItemCount">3 items</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cart Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card cart-card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-shopping-cart me-2"></i>Cart Items
                            </h5>
                            <span class="badge bg-light text-primary fs-6" id="cartCountDisplay">3 items</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Cart Item -->
                        <div class="cart-item card mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="/images/tire-1.jpg" alt="Premium Tire" class="img-fluid rounded product-thumbnail">
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="product-title mb-1">Premium All-Terrain Tire</h6>
                                        <small class="text-muted">Size: 205/55R16 • All-Season</small>
                                        <div class="mt-2">
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>In Stock
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="product-price">P2,500</span>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="quantity-selector">
                                            <div class="input-group input-group-sm">
                                                <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(this, -1)">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="text" class="form-control text-center" value="2" readonly>
                                                <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(this, 1)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <span class="product-price me-3">P5,000</span>
                                            <button class="btn btn-sm btn-outline-danger" onclick="removeItem(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Another Cart Item -->
                        <div class="cart-item card mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="/images/tire-2.jpg" alt="Performance Tire" class="img-fluid rounded product-thumbnail">
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="product-title mb-1">High-Performance Tire</h6>
                                        <small class="text-muted">Size: 225/45R17 • Summer</small>
                                        <div class="mt-2">
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>Low Stock
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="product-price">P3,200</span>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="quantity-selector">
                                            <div class="input-group input-group-sm">
                                                <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(this, -1)">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="text" class="form-control text-center" value="1" readonly>
                                                <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(this, 1)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <span class="product-price me-3">P3,200</span>
                                            <button class="btn btn-sm btn-outline-danger" onclick="removeItem(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Empty Cart State -->
                        <div class="empty-cart text-center py-5 d-none">
                            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Your cart is empty</h5>
                            <p class="text-muted mb-4">Add some products to get started</p>
                            <a href="{{ route('customer.products') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                            </a>
                        </div>

                        <!-- Cart Actions -->
                        <div class="cart-actions mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('customer.products') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                                    </a>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <button class="btn btn-outline-danger" onclick="clearCart()">
                                        <i class="fas fa-trash me-2"></i>Clear Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="fas fa-shipping-fast me-2 text-primary"></i>Shipping Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="shippingOption" id="pickup" checked>
                                    <label class="form-check-label" for="pickup">
                                        <strong>Store Pickup</strong>
                                        <small class="d-block text-muted">Free • Ready in 2 hours</small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="shippingOption" id="delivery">
                                    <label class="form-check-label" for="delivery">
                                        <strong>Home Delivery</strong>
                                        <small class="d-block text-muted">P200 • 1-2 business days</small>
                                    </label>
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
                        <div class="order-details">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Subtotal (2 items):</span>
                                <span id="subtotalAmount">P8,200</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Shipping:</span>
                                <span id="shippingAmount">P0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Tax (12%):</span>
                                <span id="taxAmount">P984</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-success">Discount:</span>
                                <span class="text-success" id="discountAmount">-P0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <strong class="fs-5">Total:</strong>
                                <strong class="fs-5 text-primary" id="totalAmount">P9,184</strong>
                            </div>
                        </div>

                        <!-- Promo Code -->
                        <div class="promo-section mb-4">
                            <label for="promoCode" class="form-label small">Promo Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" id="promoCode" placeholder="Enter code">
                                <button class="btn btn-outline-primary btn-sm" type="button" onclick="applyPromoCode()">
                                    Apply
                                </button>
                            </div>
                            <div id="promoMessage" class="mt-1 small"></div>
                        </div>

                        <!-- Checkout Button -->
                        <div class="d-grid">
                            <a href="{{ route('customer.checkout') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-lock me-2"></i>Proceed to Checkout
                            </a>
                        </div>

                        <!-- Security Badges -->
                        <div class="security-badges text-center mt-3">
                            <small class="text-muted d-block mb-2">
                                <i class="fas fa-shield-alt me-1 text-success"></i>
                                Secure SSL Encryption
                            </small>
                            <div class="d-flex justify-content-center gap-3">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='25' viewBox='0 0 40 25'%3E%3Crect width='40' height='25' fill='%23f8f9fa' rx='3'/%3E%3Ctext x='20' y='15' font-family='Arial' font-size='10' text-anchor='middle' fill='%236c757d'%3EVisa%3C/text%3E%3C/svg%3E" alt="Visa">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='25' viewBox='0 0 40 25'%3E%3Crect width='40' height='25' fill='%23f8f9fa' rx='3'/%3E%3Ctext x='20' y='15' font-family='Arial' font-size='10' text-anchor='middle' fill='%236c757d'%3EMastercard%3C/text%3E%3C/svg%3E" alt="Mastercard">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='25' viewBox='0 0 40 25'%3E%3Crect width='40' height='25' fill='%23f8f9fa' rx='3'/%3E%3Ctext x='20' y='15' font-family='Arial' font-size='8' text-anchor='middle' fill='%236c757d'%3EPayPal%3C/text%3E%3C/svg%3E" alt="PayPal">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Support -->
                <div class="card mt-4">
                    <div class="card-body text-center">
                        <div class="support-icon mb-3">
                            <i class="fas fa-headset fa-2x text-primary"></i>
                        </div>
                        <h6>Need Help?</h6>
                        <p class="small text-muted mb-3">Our support team is here to assist you</p>
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

                <!-- Return Policy -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h6 class="mb-3">
                            <i class="fas fa-undo-alt text-primary me-1"></i>Return Policy
                        </h6>
                        <p class="small text-muted mb-0">
                            30-day money-back guarantee. Free returns for defective products. Installation services are non-refundable.
                        </p>
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
    updateCartSummary();

    // Shipping option change
    document.querySelectorAll('input[name="shippingOption"]').forEach(radio => {
        radio.addEventListener('change', updateCartSummary);
    });
});

function updateQuantity(button, change) {
    const input = button.parentElement.querySelector('input');
    let quantity = parseInt(input.value) + change;

    if (quantity < 1) quantity = 1;
    if (quantity > 10) quantity = 10;

    input.value = quantity;
    updateItemTotal(button);
    updateCartSummary();
}

function updateItemTotal(button) {
    const itemRow = button.closest('.cart-item');
    const priceElement = itemRow.querySelector('.col-md-2 .product-price');
    const quantityInput = itemRow.querySelector('input');
    const totalElement = itemRow.querySelector('.col-md-2 .product-price:last-child');

    const price = parseFloat(priceElement.textContent.replace('P', '').replace(',', ''));
    const quantity = parseInt(quantityInput.value);
    const total = price * quantity;

    totalElement.textContent = 'P' + total.toLocaleString();
}

function removeItem(button) {
    const itemRow = button.closest('.cart-item');
    itemRow.style.opacity = '0';
    itemRow.style.transform = 'translateX(-100px)';

    setTimeout(() => {
        itemRow.remove();
        updateCartSummary();
        checkEmptyCart();
    }, 300);
}

function clearCart() {
    if (confirm('Are you sure you want to clear your cart?')) {
        const cartItems = document.querySelectorAll('.cart-item');
        cartItems.forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-100px)';
            setTimeout(() => item.remove(), 300);
        });

        setTimeout(() => {
            updateCartSummary();
            checkEmptyCart();
        }, 400);
    }
}

function checkEmptyCart() {
    const cartItems = document.querySelectorAll('.cart-item');
    const emptyCart = document.querySelector('.empty-cart');
    const cartActions = document.querySelector('.cart-actions');

    if (cartItems.length === 0) {
        emptyCart.classList.remove('d-none');
        cartActions.classList.add('d-none');
    } else {
        emptyCart.classList.add('d-none');
        cartActions.classList.remove('d-none');
    }
}

function updateCartSummary() {
    let subtotal = 0;

    // Calculate subtotal from all items
    document.querySelectorAll('.cart-item').forEach(item => {
        const totalElement = item.querySelector('.col-md-2 .product-price:last-child');
        const itemTotal = parseFloat(totalElement.textContent.replace('P', '').replace(',', ''));
        subtotal += itemTotal;
    });

    // Calculate shipping
    const shippingOption = document.querySelector('input[name="shippingOption"]:checked').id;
    const shipping = shippingOption === 'delivery' ? 200 : 0;

    // Calculate tax (12%)
    const tax = Math.round(subtotal * 0.12);

    // Calculate total
    const total = subtotal + shipping + tax;

    // Update display
    document.getElementById('subtotalAmount').textContent = 'P' + subtotal.toLocaleString();
    document.getElementById('shippingAmount').textContent = shipping > 0 ? 'P' + shipping.toLocaleString() : 'Free';
    document.getElementById('taxAmount').textContent = 'P' + tax.toLocaleString();
    document.getElementById('totalAmount').textContent = 'P' + total.toLocaleString();

    // Update item count
    const itemCount = document.querySelectorAll('.cart-item').length;
    document.getElementById('cartItemCount').textContent = itemCount + ' item' + (itemCount !== 1 ? 's' : '');
    document.getElementById('cartCountDisplay').textContent = itemCount + ' item' + (itemCount !== 1 ? 's' : '');
}

function applyPromoCode() {
    const promoCode = document.getElementById('promoCode').value.toUpperCase();
    const promoMessage = document.getElementById('promoMessage');

    // Simulate promo code validation
    const validCodes = {
        'WELCOME10': 0.1,
        'SAVE15': 0.15,
        'FIRSTORDER': 0.2
    };

    if (validCodes[promoCode]) {
        const discountRate = validCodes[promoCode];
        const subtotal = parseFloat(document.getElementById('subtotalAmount').textContent.replace('P', '').replace(',', ''));
        const discount = Math.round(subtotal * discountRate);

        document.getElementById('discountAmount').textContent = '-P' + discount.toLocaleString();
        promoMessage.innerHTML = '<span class="text-success">Promo code applied successfully!</span>';

        // Update total with discount
        const shipping = parseFloat(document.getElementById('shippingAmount').textContent.replace('P', '').replace(',', '') || 0);
        const tax = parseFloat(document.getElementById('taxAmount').textContent.replace('P', '').replace(',', ''));
        const total = subtotal + shipping + tax - discount;

        document.getElementById('totalAmount').textContent = 'P' + total.toLocaleString();
    } else {
        document.getElementById('discountAmount').textContent = '-P0';
        promoMessage.innerHTML = '<span class="text-danger">Invalid promo code. Please try again.</span>';
        updateCartSummary();
    }
}
</script>

<style>
.cart-card, .order-summary-card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.cart-item {
    border: none !important;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
    overflow: hidden;
}

.cart-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.product-thumbnail {
    width: 80px;
    height: 80px;
    object-fit: cover;
}

.quantity-selector .input-group {
    width: 120px;
}

.quantity-selector .btn {
    padding: 0.25rem 0.5rem;
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

.security-badges img {
    border-radius: 3px;
    border: 1px solid #dee2e6;
}

.sticky-top {
    position: sticky;
    z-index: 10;
    top: 2rem;
}

@media (max-width: 768px) {
    .order-summary-card {
        position: static !important;
        margin-bottom: 2rem;
    }

    .cart-item .row > div {
        margin-bottom: 1rem;
    }

    .product-thumbnail {
        width: 60px;
        height: 60px;
    }
}
</style>
@endsection
