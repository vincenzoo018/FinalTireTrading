@extends('layouts.customer.app')

@section('content')
<!-- Feedback Header -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">Customer Feedback</h1>
        <p class="lead">Share your experience with us</p>
    </div>
</section>

<!-- Feedback Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Feedback Form -->
            <div class="col-md-8">
                <div class="feedback-form">
                    <h3 class="mb-4">Submit Feedback</h3>
                    <form>
                        <!-- Feedback Type -->
                        <div class="mb-3">
                            <label for="feedbackType" class="form-label">Feedback Type</label>
                            <select class="form-select" id="feedbackType">
                                <option value="">Select Type</option>
                                <option value="compliment">Compliment</option>
                                <option value="suggestion">Suggestion</option>
                                <option value="complaint">Complaint</option>
                                <option value="general">General Feedback</option>
                            </select>
                        </div>

                        <!-- Order Reference -->
                        <div class="mb-3">
                            <label for="orderReference" class="form-label">Order Reference (Optional)</label>
                            <input type="text" class="form-control" id="orderReference" placeholder="e.g., #ORD-00123">
                        </div>

                        <!-- Rating -->
                        <div class="mb-3">
                            <label for="rating" class="form-label">Overall Rating</label>
                            <div class="rating-stars">
                                <input type="radio" id="star5" name="rating" value="5">
                                <label for="star5"><i class="fas fa-star"></i></label>
                                <input type="radio" id="star4" name="rating" value="4">
                                <label for="star4"><i class="fas fa-star"></i></label>
                                <input type="radio" id="star3" name="rating" value="3">
                                <label for="star3"><i class="fas fa-star"></i></label>
                                <input type="radio" id="star2" name="rating" value="2">
                                <label for="star2"><i class="fas fa-star"></i></label>
                                <input type="radio" id="star1" name="rating" value="1">
                                <label for="star1"><i class="fas fa-star"></i></label>
                            </div>
                        </div>

                        <!-- Feedback Message -->
                        <div class="mb-3">
                            <label for="feedbackMessage" class="form-label">Your Feedback</label>
                            <textarea class="form-control" id="feedbackMessage" rows="5" placeholder="Please share your experience with our products or services..."></textarea>
                        </div>

                        <!-- Upload Photos -->
                        <div class="mb-3">
                            <label class="form-label">Upload Photos (Optional)</label>
                            <input type="file" class="form-control" multiple>
                        </div>

                        <!-- Submit Button -->
                        <button type="button" class="btn btn-primary">Submit Feedback</button>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Why Feedback Matters -->
                <div class="card">
                    <div class="card-body">
                        <h5>Why Your Feedback Matters</h5>
                        <p class="small text-muted">
                            Your feedback helps us improve our products and services. We appreciate every comment and suggestion from our valued customers.
                        </p>
                        <div class="feature-list">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                <span>Quick response to issues</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                <span>Continuous improvement</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                <span>Better customer experience</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Support -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5>Contact Support</h5>
                        <p class="small mb-2"><i class="fas fa-phone me-2"></i> (082) 123-4567</p>
                        <p class="small mb-2"><i class="fas fa-envelope me-2"></i> support@8plytire.com</p>
                        <p class="small mb-0"><i class="fas fa-clock me-2"></i> Available 24/7</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Inline Style for Stars -->
<style>
.rating-stars {
    direction: rtl;
    display: inline-block;
}

.rating-stars input {
    display: none;
}

.rating-stars label {
    color: #ddd;
    font-size: 24px;
    padding: 0 2px;
    cursor: pointer;
    transition: color 0.3s;
}

.rating-stars input:checked ~ label,
.rating-stars label:hover,
.rating-stars label:hover ~ label {
    color: #ffc107;
}

.rating-stars input:checked + label {
    color: #ffc107;
}
</style>
@endsection
