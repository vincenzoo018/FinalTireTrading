@extends('layouts.customer.app')

@section('content')
<!-- Feedback Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="section-title text-start mb-2">Customer Feedback</h1>
                <p class="lead mb-0">Share your experience with us. Your feedback helps us improve our products and services.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <span class="badge bg-success fs-6">
                    <i class="fas fa-star me-1"></i>4.8/5 Average Rating
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Feedback Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Feedback Form -->
            <div class="col-lg-8">
                <div class="card feedback-form-card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-comment-dots me-2"></i>Submit Your Feedback
                        </h4>
                    </div>
                    <div class="card-body">
                        <form id="feedbackForm">
                            <!-- Feedback Type -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label for="feedbackType" class="form-label">
                                        <i class="fas fa-tag me-1 text-primary"></i>Feedback Type
                                    </label>
                                    <div class="feedback-type-selector">
                                        <div class="row g-2">
                                            <div class="col-md-3 col-6">
                                                <input type="radio" name="feedbackType" id="compliment" value="compliment" class="d-none">
                                                <label for="compliment" class="feedback-type-card">
                                                    <i class="fas fa-heart fa-2x text-success mb-2"></i>
                                                    <span>Compliment</span>
                                                </label>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <input type="radio" name="feedbackType" id="suggestion" value="suggestion" class="d-none">
                                                <label for="suggestion" class="feedback-type-card">
                                                    <i class="fas fa-lightbulb fa-2x text-warning mb-2"></i>
                                                    <span>Suggestion</span>
                                                </label>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <input type="radio" name="feedbackType" id="complaint" value="complaint" class="d-none">
                                                <label for="complaint" class="feedback-type-card">
                                                    <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                                                    <span>Complaint</span>
                                                </label>
                                            </div>
                                            <div class="col-md-3 col-6">
                                                <input type="radio" name="feedbackType" id="general" value="general" class="d-none" checked>
                                                <label for="general" class="feedback-type-card">
                                                    <i class="fas fa-comments fa-2x text-primary mb-2"></i>
                                                    <span>General</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Reference -->
                            <div class="mb-4">
                                <label for="orderReference" class="form-label">
                                    <i class="fas fa-shopping-bag me-1 text-primary"></i>Order Reference (Optional)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white">#</span>
                                    <input type="text" class="form-control" id="orderReference" placeholder="ORD-00123">
                                    <button type="button" class="btn btn-outline-primary" onclick="fetchOrderDetails()">
                                        <i class="fas fa-search me-1"></i>Find Order
                                    </button>
                                </div>
                                <div id="orderDetails" class="mt-2" style="display: none;">
                                    <div class="alert alert-info p-2">
                                        <small>
                                            <i class="fas fa-check-circle me-1 text-success"></i>
                                            Order found: 2x Premium Tires - P5,800 (Dec 4, 2023)
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Rating -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-star me-1 text-primary"></i>Overall Rating
                                </label>
                                <div class="rating-container text-center">
                                    <div class="rating-stars mb-2">
                                        <input type="radio" id="star5" name="rating" value="5" class="d-none">
                                        <label for="star5" class="star-label">
                                            <i class="fas fa-star"></i>
                                        </label>
                                        <input type="radio" id="star4" name="rating" value="4" class="d-none">
                                        <label for="star4" class="star-label">
                                            <i class="fas fa-star"></i>
                                        </label>
                                        <input type="radio" id="star3" name="rating" value="3" class="d-none">
                                        <label for="star3" class="star-label">
                                            <i class="fas fa-star"></i>
                                        </label>
                                        <input type="radio" id="star2" name="rating" value="2" class="d-none">
                                        <label for="star2" class="star-label">
                                            <i class="fas fa-star"></i>
                                        </label>
                                        <input type="radio" id="star1" name="rating" value="1" class="d-none">
                                        <label for="star1" class="star-label">
                                            <i class="fas fa-star"></i>
                                        </label>
                                    </div>
                                    <small class="text-muted" id="ratingText">Tap to rate your experience</small>
                                </div>
                            </div>

                            <!-- Category Ratings -->
                            <div class="mb-4">
                                <label class="form-label">Category Ratings</label>
                                <div class="category-ratings">
                                    <div class="category-rating-item d-flex justify-content-between align-items-center mb-3">
                                        <span>Product Quality</span>
                                        <div class="category-stars">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                            <input type="radio" name="quality" value="<?= $i ?>" id="quality<?= $i ?>" class="d-none">
                                            <label for="quality<?= $i ?>" class="category-star">
                                                <i class="fas fa-star"></i>
                                            </label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <div class="category-rating-item d-flex justify-content-between align-items-center mb-3">
                                        <span>Service Experience</span>
                                        <div class="category-stars">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                            <input type="radio" name="service" value="<?= $i ?>" id="service<?= $i ?>" class="d-none">
                                            <label for="service<?= $i ?>" class="category-star">
                                                <i class="fas fa-star"></i>
                                            </label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <div class="category-rating-item d-flex justify-content-between align-items-center mb-3">
                                        <span>Delivery Speed</span>
                                        <div class="category-stars">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                            <input type="radio" name="delivery" value="<?= $i ?>" id="delivery<?= $i ?>" class="d-none">
                                            <label for="delivery<?= $i ?>" class="category-star">
                                                <i class="fas fa-star"></i>
                                            </label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <div class="category-rating-item d-flex justify-content-between align-items-center">
                                        <span>Customer Support</span>
                                        <div class="category-stars">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                            <input type="radio" name="support" value="<?= $i ?>" id="support<?= $i ?>" class="d-none">
                                            <label for="support<?= $i ?>" class="category-star">
                                                <i class="fas fa-star"></i>
                                            </label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Feedback Message -->
                            <div class="mb-4">
                                <label for="feedbackMessage" class="form-label">
                                    <i class="fas fa-edit me-1 text-primary"></i>Your Feedback
                                </label>
                                <textarea class="form-control" id="feedbackMessage" rows="6" placeholder="Please share your detailed experience with our products or services. What did you like? What can we improve?"></textarea>
                                <div class="form-text">
                                    <span id="charCount">0</span>/500 characters
                                </div>
                            </div>

                            <!-- Upload Photos -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-camera me-1 text-primary"></i>Upload Photos (Optional)
                                </label>
                                <div class="file-upload-area border rounded p-4 text-center">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-2">Drag & drop photos here or click to browse</p>
                                    <p class="small text-muted mb-3">Maximum 5 photos, 5MB each</p>
                                    <input type="file" class="form-control d-none" id="photoUpload" multiple accept="image/*">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('photoUpload').click()">
                                        <i class="fas fa-folder-open me-1"></i>Choose Files
                                    </button>
                                    <div id="photoPreview" class="mt-3 row g-2"></div>
                                </div>
                            </div>

                            <!-- Anonymous Feedback -->
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="anonymousFeedback">
                                    <label class="form-check-label" for="anonymousFeedback">
                                        Submit feedback anonymously
                                    </label>
                                </div>
                                <small class="text-muted">Your personal information will not be shared with the feedback.</small>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Feedback
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Recent Feedback -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-history me-2 text-primary"></i>Your Recent Feedback
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="feedback-history">
                            <div class="feedback-item mb-3 p-3 border rounded">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">Great Service Experience</h6>
                                        <div class="rating-small text-warning mb-1">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                    <small class="text-muted">Dec 4, 2023</small>
                                </div>
                                <p class="mb-2">The wheel alignment service was excellent. Professional technicians and quick service.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-success">
                                        <i class="fas fa-check-circle me-1"></i>Published
                                    </small>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>View
                                    </button>
                                </div>
                            </div>

                            <div class="feedback-item p-3 border rounded">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">Product Suggestion</h6>
                                        <div class="rating-small text-warning mb-1">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                    </div>
                                    <small class="text-muted">Nov 28, 2023</small>
                                </div>
                                <p class="mb-2">Would love to see more eco-friendly tire options in your inventory.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-info">
                                        <i class="fas fa-clock me-1"></i>Under Review
                                    </small>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i>View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Why Feedback Matters -->
                <div class="card sidebar-card mb-4">
                    <div class="card-body text-center">
                        <div class="sidebar-icon mb-3">
                            <i class="fas fa-comments fa-2x text-primary"></i>
                        </div>
                        <h5>Why Your Feedback Matters</h5>
                        <p class="text-muted small">
                            Your feedback helps us improve our products and services. We appreciate every comment and suggestion from our valued customers.
                        </p>
                        <div class="feature-list text-start">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span class="small">Quick response to issues</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span class="small">Continuous improvement</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span class="small">Better customer experience</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span class="small">New feature development</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Response Time -->
                <div class="card sidebar-card mb-4">
                    <div class="card-body text-center">
                        <div class="sidebar-icon mb-3">
                            <i class="fas fa-clock fa-2x text-primary"></i>
                        </div>
                        <h5>Quick Response</h5>
                        <p class="text-muted small mb-3">
                            We typically respond to feedback within 24 hours and implement changes based on customer suggestions.
                        </p>
                        <div class="response-stats">
                            <div class="row text-center">
                                <div class="col-6">
                                    <h4 class="text-primary mb-1">24h</h4>
                                    <small class="text-muted">Avg. Response</small>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-success mb-1">98%</h4>
                                    <small class="text-muted">Satisfaction</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Support -->
                <div class="card sidebar-card">
                    <div class="card-body text-center">
                        <div class="sidebar-icon mb-3">
                            <i class="fas fa-headset fa-2x text-primary"></i>
                        </div>
                        <h5>Need Immediate Help?</h5>
                        <p class="text-muted small mb-3">
                            Contact our support team for urgent issues or questions.
                        </p>
                        <div class="contact-info">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <i class="fas fa-phone text-primary me-2"></i>
                                <span class="small">(082) 123-4567</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <span class="small">support@8plytire.com</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <span class="small">Available 24/7</span>
                            </div>
                        </div>
                        <div class="contact-actions">
                            <button class="btn btn-outline-primary btn-sm w-100 mb-2">
                                <i class="fas fa-comment-dots me-1"></i>Live Chat
                            </button>
                            <a href="mailto:support@8plytire.com" class="btn btn-outline-primary btn-sm w-100">
                                <i class="fas fa-envelope me-1"></i>Send Email
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Feedback Impact -->
                <div class="card sidebar-card mt-4">
                    <div class="card-body">
                        <h6 class="mb-3">
                            <i class="fas fa-chart-line text-primary me-1"></i>Your Feedback Impact
                        </h6>
                        <div class="impact-stats">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small">Feedback Submitted</span>
                                <strong class="text-primary">12</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small">Responses Received</span>
                                <strong class="text-success">10</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small">Suggestions Implemented</span>
                                <strong class="text-info">3</strong>
                            </div>
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
    // Character counter for feedback message
    const feedbackMessage = document.getElementById('feedbackMessage');
    const charCount = document.getElementById('charCount');

    feedbackMessage.addEventListener('input', function() {
        charCount.textContent = this.value.length;

        if (this.value.length > 500) {
            charCount.classList.add('text-danger');
        } else {
            charCount.classList.remove('text-danger');
        }
    });

    // Rating stars interaction
    const ratingStars = document.querySelectorAll('.rating-stars input');
    const ratingText = document.getElementById('ratingText');

    ratingStars.forEach(star => {
        star.addEventListener('change', function() {
            const rating = this.value;
            const texts = {
                1: 'Poor - We apologize for the bad experience',
                2: 'Fair - We appreciate your honest feedback',
                3: 'Good - Thank you for your feedback',
                4: 'Very Good - We\'re glad you had a good experience',
                5: 'Excellent - Thank you for the perfect rating!'
            };
            ratingText.textContent = texts[rating] || 'Tap to rate your experience';
        });
    });

    // Category stars interaction
    document.querySelectorAll('.category-stars input').forEach(star => {
        star.addEventListener('change', function() {
            const stars = this.parentElement.querySelectorAll('.category-star');
            const value = parseInt(this.value);

            stars.forEach((starLabel, index) => {
                if (index < value) {
                    starLabel.classList.add('active');
                } else {
                    starLabel.classList.remove('active');
                }
            });
        });
    });

    // Feedback type selection
    document.querySelectorAll('.feedback-type-card').forEach(card => {
        card.addEventListener('click', function() {
            document.querySelectorAll('.feedback-type-card').forEach(c => {
                c.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    // Photo upload preview
    document.getElementById('photoUpload').addEventListener('change', function(e) {
        const preview = document.getElementById('photoPreview');
        preview.innerHTML = '';

        Array.from(e.target.files).forEach((file, index) => {
            if (index < 5) { // Limit to 5 files
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-4';
                    col.innerHTML = `
                        <div class="photo-preview position-relative">
                            <img src="${e.target.result}" class="img-fluid rounded" alt="Preview">
                            <button type="button" class="btn-remove-photo btn btn-sm btn-danger position-absolute top-0 end-0" onclick="removePhoto(${index})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    preview.appendChild(col);
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Form submission
    document.getElementById('feedbackForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
        submitBtn.disabled = true;

        // Simulate API call
        setTimeout(() => {
            // Show success message
            alert('Thank you for your feedback! We appreciate you taking the time to share your experience with us.');

            // Reset form
            this.reset();
            document.getElementById('photoPreview').innerHTML = '';
            document.getElementById('orderDetails').style.display = 'none';
            document.getElementById('ratingText').textContent = 'Tap to rate your experience';
            document.querySelectorAll('.feedback-type-card').forEach(card => {
                card.classList.remove('active');
            });
            document.getElementById('general').checked = true;
            document.querySelector('.feedback-type-card[for="general"]').classList.add('active');

            // Reset category stars
            document.querySelectorAll('.category-star').forEach(star => {
                star.classList.remove('active');
            });

            // Restore button
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 2000);
    });
});

function fetchOrderDetails() {
    const orderRef = document.getElementById('orderReference').value;
    if (orderRef) {
        const orderDetails = document.getElementById('orderDetails');
        orderDetails.style.display = 'block';

        // Simulate API call
        setTimeout(() => {
            orderDetails.innerHTML = `
                <div class="alert alert-info p-2">
                    <small>
                        <i class="fas fa-check-circle me-1 text-success"></i>
                        Order found: 2x Premium Tires - P5,800 (Dec 4, 2023)
                    </small>
                </div>
            `;
        }, 500);
    }
}

function removePhoto(index) {
    // This would remove the photo from the file input and preview
    const fileInput = document.getElementById('photoUpload');
    const dt = new DataTransfer();
    const files = Array.from(fileInput.files);

    files.splice(index, 1);
    files.forEach(file => dt.items.add(file));
    fileInput.files = dt.files;

    // Update preview
    document.getElementById('photoPreview').innerHTML = '';
    Array.from(fileInput.files).forEach((file, newIndex) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const col = document.createElement('div');
            col.className = 'col-4';
            col.innerHTML = `
                <div class="photo-preview position-relative">
                    <img src="${e.target.result}" class="img-fluid rounded" alt="Preview">
                    <button type="button" class="btn-remove-photo btn btn-sm btn-danger position-absolute top-0 end-0" onclick="removePhoto(${newIndex})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            document.getElementById('photoPreview').appendChild(col);
        };
        reader.readAsDataURL(file);
    });
}
</script>

<style>
.feedback-form-card, .sidebar-card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.feedback-type-card {
    border: 2px solid #e9ecef;
    border-radius: 0.75rem;
    padding: 1.5rem 0.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    display: block;
}

.feedback-type-card:hover,
.feedback-type-card.active {
    border-color: #3498db;
    background: rgba(52, 152, 219, 0.05);
    transform: translateY(-2px);
}

.feedback-type-card.active {
    border-color: #3498db;
    background: rgba(52, 152, 219, 0.1);
}

.rating-stars {
    direction: ltr;
    display: flex;
    justify-content: center;
    gap: 0.5rem;
}

.star-label {
    font-size: 2.5rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.3s ease;
}

.star-label:hover,
.rating-stars input:checked ~ .star-label,
.rating-stars input:checked + .star-label {
    color: #ffc107;
}

.star-label:hover ~ .star-label {
    color: #ffc107;
}

.category-stars {
    display: flex;
    gap: 0.25rem;
}

.category-star {
    color: #ddd;
    cursor: pointer;
    transition: color 0.3s ease;
}

.category-star.active,
.category-star:hover,
.category-stars input:checked ~ .category-star {
    color: #ffc107;
}

.category-rating-item {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.category-rating-item:last-child {
    border-bottom: none;
}

.file-upload-area {
    border: 2px dashed #dee2e6 !important;
    transition: all 0.3s ease;
    cursor: pointer;
}

.file-upload-area:hover {
    border-color: #3498db !important;
    background: rgba(52, 152, 219, 0.05);
}

.photo-preview {
    margin-bottom: 0.5rem;
}

.photo-preview img {
    width: 100%;
    height: 80px;
    object-fit: cover;
}

.btn-remove-photo {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.6rem;
}

.sidebar-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #3498db, #2980b9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin: 0 auto;
}

.feedback-item {
    transition: all 0.3s ease;
}

.feedback-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.rating-small {
    font-size: 0.8rem;
}

.impact-stats .d-flex {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.impact-stats .d-flex:last-child {
    border-bottom: none;
}

.form-check-input:checked {
    background-color: #3498db;
    border-color: #3498db;
}

@media (max-width: 768px) {
    .feedback-type-card {
        padding: 1rem 0.25rem;
    }

    .feedback-type-card i {
        font-size: 1.5rem !important;
    }

    .star-label {
        font-size: 2rem;
    }

    .sidebar-icon {
        width: 60px;
        height: 60px;
    }

    .category-rating-item {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 0.5rem;
    }

    .category-stars {
        align-self: flex-end;
    }
}
</style>
@endsection
