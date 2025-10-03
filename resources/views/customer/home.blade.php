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




<!-- Featured Products -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">Featured Products</h2>
        <p class="lead text-center mb-5">Discover our premium selection of tires for ultimate performance</p>
        <div class="row">
            @forelse($products as $product)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card product-card">
                    <span class="featured-badge">BEST SELLER</span>
                    <img src="{{ asset($product->image ?? 'images/default-product.png') }}" class="card-img-top product-img" alt="{{ $product->product_name }}">
                    <div class="card-body">
                        <h5 class="product-title">{{ $product->product_name }}</h5>
                        <p class="card-text text-muted">{{ $product->description }}</p>
                        <div class="product-features mb-3">
                            <small class="text-muted"><i class="fas fa-check text-success me-1"></i>{{ $product->brand }}</small>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="product-price">P{{ number_format($product->selling_price, 2) }}</span>
                                <small class="text-muted d-block">per tire</small>
                            </div>
                            <a href="{{ route('customer.products') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-cart-plus me-1"></i> View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">No featured products available.</div>
            </div>
            @endforelse
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
            @forelse($services as $service)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card service-card text-center h-100">
                    <div class="card-body">
                        <div class="service-icon mb-3">
                            @if($service->image)
                                <img src="{{ asset($service->image) }}" alt="{{ $service->service_name }}" style="width:60px;height:60px;object-fit:cover;border-radius:50%;">
                            @else
                                <i class="fas fa-cogs fa-2x"></i>
                            @endif
                        </div>
                        <h5 class="card-title">{{ $service->service_name }}</h5>
                        <p class="card-text text-muted">{{ $service->description }}</p>
                        <p class="price">Starting at P{{ number_format($service->service_price, 2) }}</p>
                        <div class="mb-3">
                            <span class="badge bg-success">
                                <i class="fas fa-user me-1"></i>{{ $service->employee->name ?? 'N/A' }}
                            </span>
                        </div>
                        <a href="{{ route('customer.booking') }}" class="btn btn-primary">
                            <i class="fas fa-calendar-plus me-1"></i>Book Now
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">No services available at the moment.</div>
            </div>
            @endforelse
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
