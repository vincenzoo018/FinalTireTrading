@extends('layouts.customer.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section text-center py-5 bg-light">
    <div class="container">
        <h1 class="hero-title">Quality Tires & Professional Services</h1>
        <p class="hero-subtitle">Your trusted partner for all your automotive needs</p>
        <a href="{{ route('customer.products') }}" class="btn btn-primary btn-lg me-3">Shop Tires</a>
        <a href="{{ route('customer.booking') }}" class="btn btn-outline-primary btn-lg">Book Service</a>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Featured Products</h2>
        <div class="row">
            <!-- Product 1 -->
            <div class="col-md-4 mb-4">
                <div class="card product-card">
                    <span class="featured-badge">Featured</span>
                    <img src="/images/tire-1.jpg" class="card-img-top product-img" alt="All-Terrain Tire">
                    <div class="card-body">
                        <h5 class="product-title">All-Terrain Tire</h5>
                        <p class="card-text">Perfect for both on-road and off-road adventures.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="product-price">P2,500</span>
                            <button class="btn btn-primary btn-sm">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Product 2 -->
            <div class="col-md-4 mb-4">
                <div class="card product-card">
                    <span class="featured-badge">Featured</span>
                    <img src="/images/tire-2.jpg" class="card-img-top product-img" alt="Performance Tire">
                    <div class="card-body">
                        <h5 class="product-title">Performance Tire</h5>
                        <p class="card-text">Enhanced handling and superior traction for sports cars.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="product-price">P3,200</span>
                            <button class="btn btn-primary btn-sm">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Product 3 -->
            <div class="col-md-4 mb-4">
                <div class="card product-card">
                    <span class="featured-badge">Featured</span>
                    <img src="/images/tire-3.jpg" class="card-img-top product-img" alt="Winter Tire">
                    <div class="card-body">
                        <h5 class="product-title">Winter Tire</h5>
                        <p class="card-text">Specialized tread design for superior snow and ice traction.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="product-price">P3,800</span>
                            <button class="btn btn-primary btn-sm">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('customer.products') }}" class="btn btn-outline-primary">View All Products</a>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-5">Our Services</h2>
        <div class="row">
            <!-- Service 1 -->
            <div class="col-md-4 mb-4">
                <div class="card service-card text-center">
                    <div class="card-body">
                        <div class="service-icon mb-3">
                            <i class="fas fa-cogs fa-2x"></i>
                        </div>
                        <h5 class="card-title">Wheel Alignment</h5>
                        <p class="card-text">Precision alignment for better handling and extended tire life.</p>
                        <p class="price">Starting at P800</p>
                        <a href="{{ route('customer.booking') }}" class="btn btn-primary btn-sm">Book Now</a>
                    </div>
                </div>
            </div>
            <!-- Service 2 -->
            <div class="col-md-4 mb-4">
                <div class="card service-card text-center">
                    <div class="card-body">
                        <div class="service-icon mb-3">
                            <i class="fas fa-tools fa-2x"></i>
                        </div>
                        <h5 class="card-title">Tire Replacement</h5>
                        <p class="card-text">Professional tire mounting and balancing services.</p>
                        <p class="price">Starting at P200</p>
                        <a href="{{ route('customer.booking') }}" class="btn btn-primary btn-sm">Book Now</a>
                    </div>
                </div>
            </div>
            <!-- Service 3 -->
            <div class="col-md-4 mb-4">
                <div class="card service-card text-center">
                    <div class="card-body">
                        <div class="service-icon mb-3">
                            <i class="fas fa-car fa-2x"></i>
                        </div>
                        <h5 class="card-title">Brake Service</h5>
                        <p class="card-text">Complete brake inspection and repair services.</p>
                        <p class="price">Starting at P1,200</p>
                        <a href="{{ route('customer.booking') }}" class="btn btn-primary btn-sm">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">What Our Customers Say</h2>
        <div class="row">
            <!-- Testimonial 1 -->
            <div class="col-md-4 mb-4">
                <div class="card testimonial-card">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text">"The best tire shop in town! Their prices are competitive and their service is exceptional."</p>
                        <div class="customer-name">- Juan Dela Cruz</div>
                    </div>
                </div>
            </div>
            <!-- Testimonial 2 -->
            <div class="col-md-4 mb-4">
                <div class="card testimonial-card">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text">"I've been coming here for years. Their mechanics are knowledgeable and honest."</p>
                        <div class="customer-name">- Maria Santos</div>
                    </div>
                </div>
            </div>
            <!-- Testimonial 3 -->
            <div class="col-md-4 mb-4">
                <div class="card testimonial-card">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="card-text">"Quick service and quality work. I recommend 8PLY to all my friends and family."</p>
                        <div class="customer-name">- Pedro Reyes</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
