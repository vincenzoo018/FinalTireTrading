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
                    <span class="badge bg-primary fs-6" id="cartItemCount">{{ $cartItems->count() }} items</span>
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
                            <span class="badge bg-light text-primary fs-6" id="cartCountDisplay">{{ $cartItems->count() }} items</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @forelse($cartItems as $cart)
                        <div class="cart-item card mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        @if($cart->product && $cart->product->image)
                                            <img src="{{ asset($cart->product->image) }}" alt="{{ $cart->product->product_name }}" class="img-fluid rounded product-thumbnail">
                                        @else
                                            <img src="{{ asset('images/default-product.png') }}" alt="Default Product" class="img-fluid rounded product-thumbnail">
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="product-title mb-1">{{ $cart->product->product_name ?? 'Unknown Product' }}</h6>
                                        <small class="text-muted">
                                            Size: {{ $cart->product->size ?? '-' }} • Brand: {{ $cart->product->brand ?? '-' }}
                                        </small>
                                        <div class="mt-2">
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>In Stock
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="product-price">P{{ number_format($cart->product->selling_price ?? 0, 2) }}</span>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="quantity-selector">
                                            <form action="{{ route('customer.cart.update', $cart->cart_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <div class="input-group input-group-sm">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(this, -1)">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" name="quantity" class="form-control text-center quantity-input"
                                                           value="{{ $cart->quantity ?? 1 }}" min="1" max="10"
                                                           data-cart-id="{{ $cart->cart_id }}">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(this, 1)">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <span class="product-price me-3">P{{ number_format(($cart->product->selling_price ?? 0) * ($cart->quantity ?? 1), 2) }}</span>
                                            <form action="{{ route('customer.cart.remove', $cart->cart_id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" type="submit">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="empty-cart text-center py-5">
                            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Your cart is empty</h5>
                            <p class="text-muted mb-4">Add some products to get started</p>
                            <a href="{{ route('customer.products') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                            </a>
                        </div>
                        @endforelse

                        <!-- Cart Actions -->
                        @if($cartItems->count())
                        <div class="cart-actions mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('customer.products') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                                    </a>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <form action="{{ route('customer.cart.clear') }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger" type="submit">
                                            <i class="fas fa-trash me-2"></i>Clear Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="fas fa-shipping-fast me-2 text-primary"></i>Delivery Information
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
                        @php
                            $subtotal = $cartItems->sum(function($cart) {
                                return ($cart->product->selling_price ?? 0) * ($cart->quantity ?? 1);
                            });
                            $shipping = 0;
                            $tax = round($subtotal * 0.12);
                            $discount = 0;
                            $total = $subtotal + $shipping + $tax - $discount;
                        @endphp
                        <div class="order-details">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Subtotal ({{ $cartItems->count() }} items):</span>
                                <span id="subtotalAmount">P{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Shipping:</span>
                                <span id="shippingAmount">Free</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Tax (12%):</span>
                                <span id="taxAmount">P{{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-success">Discount:</span>
                                <span class="text-success" id="discountAmount">-P{{ number_format($discount, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <strong class="fs-5">Total:</strong>
                                <strong class="fs-5 text-primary" id="totalAmount">P{{ number_format($total, 2) }}</strong>
                            </div>
                        </div>

                        <!-- Promo Code -->


                        <!-- Checkout Button -->
                        <div class="d-grid">
                            <a href="{{ route('customer.checkout') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-lock me-2"></i>Proceed to Checkout
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

    // Auto-submit the form to update the database
    const form = input.closest('form');
    if (form) {
        // Show loading indicator
        const loadingOverlay = document.createElement('div');
        loadingOverlay.className = 'position-fixed w-100 h-100 bg-dark bg-opacity-25 d-flex justify-content-center align-items-center';
        loadingOverlay.style.top = '0';
        loadingOverlay.style.left = '0';
        loadingOverlay.style.zIndex = '9999';
        loadingOverlay.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
        document.body.appendChild(loadingOverlay);
        
        form.submit();
    }
}

function updateItemTotal(button) {
    const itemRow = button.closest('.cart-item');
    const priceElements = itemRow.querySelectorAll('.product-price');
    const quantityInput = itemRow.querySelector('input[name="quantity"]');
    
    // First price element is the unit price
    const unitPriceElement = priceElements[0];
    // Last price element is the total
    const totalElement = priceElements[priceElements.length - 1];

    const price = parseFloat(unitPriceElement.textContent.replace('P', '').replace(/,/g, ''));
    const quantity = parseInt(quantityInput.value);
    const total = price * quantity;

    totalElement.textContent = 'P' + total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

function applyPromoCode() {
    const promoCode = document.getElementById('promoCode').value.toUpperCase();
    const promoMessage = document.getElementById('promoMessage');

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

    document.querySelectorAll('.cart-item').forEach(item => {
        const priceElement = item.querySelector('.col-md-2 .product-price');
        const quantityInput = item.querySelector('input');
        
        const price = parseFloat(priceElement.textContent.replace('P', '').replace(/,/g, ''));
        const quantity = parseInt(quantityInput.value);
        const itemTotal = price * quantity;
        
        subtotal += itemTotal;
    });

    const shippingOption = document.querySelector('input[name="shippingOption"]:checked').id;
    const shipping = shippingOption === 'delivery' ? 200 : 0;

    const tax = Math.round(subtotal * 0.12);
    const discountText = document.getElementById('discountAmount').textContent;
    const discount = parseFloat(discountText.replace('-P', '').replace(/,/g, '') || 0);

    const total = subtotal + shipping + tax - discount;

    document.getElementById('subtotalAmount').textContent = 'P' + subtotal.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    document.getElementById('shippingAmount').textContent = shipping > 0 ? 'P' + shipping.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) : 'Free';
    document.getElementById('taxAmount').textContent = 'P' + tax.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    document.getElementById('totalAmount').textContent = 'P' + total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});

    const itemCount = document.querySelectorAll('.cart-item').length;
    document.getElementById('cartItemCount').textContent = itemCount + ' item' + (itemCount !== 1 ? 's' : '');
    document.getElementById('cartCountDisplay').textContent = itemCount + ' item' + (itemCount !== 1 ? 's' : '');
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
