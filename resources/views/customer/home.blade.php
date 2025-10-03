@extends('layouts.customer.app')

@section('styles')
<style>
    .stats-counter {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1rem;
        padding: 2rem;
        color: white;
        text-align: center;
        margin-bottom: 2rem;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        display: block;
    }

    .stat-label {
        font-size: 1.1rem;
        opacity: 0.9;
    }
</style>
@endsection

@section('content')
<!-- Enhanced Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="hero-title">Quality Tires & Professional Services</h1>
                <p class="hero-subtitle">Your trusted partner for all your automotive needs. Experience excellence in every mile.</p>
                <div class="mt-4">
                    <a href="{{ route('customer.products') }}" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-shopping-cart me-2"></i>Shop Tires
                    </a>
                    <a href="{{ route('customer.booking') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-calendar-check me-2"></i>Book Service
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Stats -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="stats-counter fade-in">
                    <span class="stat-number" data-count="5000">0</span>
                    <span class="stat-label">Happy Customers</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-counter fade-in" style="animation-delay: 0.2s">
                    <span class="stat-number" data-count="100">0</span>
                    <span class="stat-label">Quality Products</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-counter fade-in" style="animation-delay: 0.4s">
                    <span class="stat-number" data-count="50">0</span>
                    <span class="stat-label">Expert Services</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-counter fade-in" style="animation-delay: 0.6s">
                    <span class="stat-number" data-count="15">0</span>
                    <span class="stat-label">Years Experience</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">Featured Products</h2>
        <p class="lead text-center mb-5">Discover our premium selection of tires for ultimate performance</p>
        <div class="row">
            @foreach([1, 2, 3] as $product)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card product-card">
                    <span class="featured-badge">BEST SELLER</span>
                    <img src="/images/tire-{{ $product }}.jpg" class="card-img-top product-img" alt="Premium Tire">
                    <div class="card-body">
                        <h5 class="product-title">Premium Performance Tire</h5>
                        <p class="card-text text-muted">Engineered for superior grip, durability, and smooth riding experience in all conditions.</p>
                        <div class="product-features mb-3">
                            <small class="text-muted"><i class="fas fa-check text-success me-1"></i> All-Weather Traction</small><br>
                            <small class="text-muted"><i class="fas fa-check text-success me-1"></i> 60,000 km Warranty</small><br>
                            <small class="text-muted"><i class="fas fa-check text-success me-1"></i> Fuel Efficient</small>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="product-price">P{{ number_format(2500 + ($product * 700), 2) }}</span>
                                <small class="text-muted d-block">per tire</small>
                            </div>
                            <button class="btn btn-primary btn-sm" onclick="addToCart({{ $product }}, 'Premium Tire {{ $product }}', {{ 2500 + ($product * 700) }})">
                                <i class="fas fa-cart-plus me-1"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('customer.products') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-arrow-right me-2"></i>View All Products
            </a>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title">Our Services</h2>
        <p class="lead text-center mb-5">Professional automotive services to keep your vehicle in perfect condition</p>
        <div class="row">
            @foreach([
                ['icon' => 'fa-cogs', 'title' => 'Wheel Alignment', 'desc' => 'Precision alignment for better handling', 'price' => 800],
                ['icon' => 'fa-tools', 'title' => 'Tire Replacement', 'desc' => 'Professional mounting and balancing', 'price' => 200],
                ['icon' => 'fa-car', 'title' => 'Brake Service', 'desc' => 'Complete inspection and repair', 'price' => 1200]
            ] as $service)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card service-card text-center h-100">
                    <div class="card-body">
                        <div class="service-icon mb-3">
                            <i class="fas {{ $service['icon'] }}"></i>
                        </div>
                        <h5 class="card-title">{{ $service['title'] }}</h5>
                        <p class="card-text text-muted">{{ $service['desc'] }} and extended vehicle life.</p>
                        <p class="price">Starting at P{{ number_format($service['price'], 2) }}</p>
                        <div class="mb-3">
                            <span class="badge bg-success">
                                <i class="fas fa-clock me-1"></i>30-45 mins
                            </span>
                        </div>
                        <a href="{{ route('customer.booking') }}" class="btn btn-primary">
                            <i class="fas fa-calendar-plus me-1"></i>Book Now
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">What Our Customers Say</h2>
        <p class="lead text-center mb-5">Don't just take our word for it - hear from our satisfied customers</p>
        <div class="row">
            @foreach([
                ['name' => 'Juan Dela Cruz', 'text' => 'The best tire shop in town! Their prices are competitive and their service is exceptional. My car has never driven better.'],
                ['name' => 'Maria Santos', 'text' => 'I\'ve been coming here for years. Their mechanics are knowledgeable and honest. They always explain what needs to be done and why.'],
                ['name' => 'Pedro Reyes', 'text' => 'Quick service and quality work. I recommend 8PLY to all my friends and family. The team is professional and courteous.']
            ] as $testimonial)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card testimonial-card h-100">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            @for($i = 0; $i < 5; $i++)
                            <i class="fas fa-star text-warning"></i>
                            @endfor
                        </div>
                        <p class="card-text">"{{ $testimonial['text'] }}"</p>
                        <div class="customer-name">
                            <strong>{{ $testimonial['name'] }}</strong>
                            <small class="d-block text-muted">Regular Customer</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-dark text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="mb-3">Ready to Experience the Difference?</h3>
                <p class="mb-0">Join thousands of satisfied customers who trust 8PLY for their automotive needs.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('customer.booking') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-phone-alt me-2"></i>Contact Us Today
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Animate stats counter
    function animateStats() {
        const counters = document.querySelectorAll('.stat-number');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-count');
            const increment = target / 100;
            let current = 0;

            const updateCounter = () => {
                if (current < target) {
                    current += increment;
                    counter.innerText = Math.ceil(current);
                    setTimeout(updateCounter, 20);
                } else {
                    counter.innerText = target;
                }
            };

            updateCounter();
        });
    }

    // Intersection Observer for stats animation
    const statsSection = document.querySelector('.stats-counter');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateStats();
                observer.unobserve(entry.target);
            }
        });
    });

    if (statsSection) {
        observer.observe(statsSection);
    }
</script>
@endsection
