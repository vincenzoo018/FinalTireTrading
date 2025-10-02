@extends('layouts.customer.app')

@section('content')
<!-- Checkout Header -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">Checkout</h1>
        <p class="lead">Complete your purchase with secure payment</p>
    </div>
</section>

<!-- Checkout Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Shipping Information -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Shipping Information</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="shippingFirstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="shippingFirstName" value="John">
                                </div>
                                <div class="col-md-6">
                                    <label for="shippingLastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="shippingLastName" value="Doe">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="shippingAddress" class="form-label">Address</label>
                                <textarea class="form-control" id="shippingAddress" rows="3">123 Main Street, Davao City</textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="shippingCity" class="form-label">City</label>
                                    <input type="text" class="form-control" id="shippingCity" value="Davao City">
                                </div>
                                <div class="col-md-4">
                                    <label for="shippingProvince" class="form-label">Province</label>
                                    <input type="text" class="form-control" id="shippingProvince" value="Davao del Sur">
                                </div>
                                <div class="col-md-4">
                                    <label for="shippingZip" class="form-label">ZIP Code</label>
                                    <input type="text" class="form-control" id="shippingZip" value="8000">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="shippingPhone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="shippingPhone" value="0912-345-6789">
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="billingSame">
                                <label class="form-check-label" for="billingSame">
                                    Billing address is the same as shipping address
                                </label>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" checked>
                                <label class="form-check-label" for="creditCard">
                                    Credit/Debit Card
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="paypal">
                                <label class="form-check-label" for="paypal">
                                    PayPal
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="bankTransfer">
                                <label class="form-check-label" for="bankTransfer">
                                    Bank Transfer
                                </label>
                            </div>
                        </div>

                        <!-- Credit Card Form -->
                        <div id="creditCardForm">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="cardNumber" class="form-label">Card Number</label>
                                    <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456">
                                </div>
                                <div class="col-md-3">
                                    <label for="expiryDate" class="form-label">Expiry Date</label>
                                    <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY">
                                </div>
                                <div class="col-md-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control" id="cvv" placeholder="123">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="cardName" class="form-label">Name on Card</label>
                                <input type="text" class="form-control" id="cardName">
                            </div>
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
                        <div id="checkoutItems">
                            <p class="text-muted small">Your selected items will appear here.</p>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span id="checkoutSubtotal">P0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span id="checkoutShipping">P0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax:</span>
                            <span id="checkoutTax">P0</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong id="checkoutTotal">P0</strong>
                        </div>
                        <button type="button" class="btn btn-primary w-100">Complete Purchase</button>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h6><i class="fas fa-shield-alt me-2"></i>Secure Payment</h6>
                        <p class="small text-muted mb-0">
                            Your payment information is encrypted and secure. We do not store your credit card details.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
