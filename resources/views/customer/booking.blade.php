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

    /* My Bookings Section Styles */
    .bookings-section {
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }

    .section-title {
        font-size: 20px;
        font-weight: 600;
    }

    .status-filters {
        display: flex;
        gap: 10px;
    }

    .status-filter {
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .status-filter.active {
        background-color: #6a11cb;
        color: white;
    }

    .status-filter:not(.active) {
        background-color: #f0f0f0;
        color: #666;
    }

    .bookings-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .booking-card {
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 20px;
        transition: all 0.3s ease;
    }

    .booking-card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        border-color: #ddd;
    }

    .booking-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .booking-id {
        font-weight: bold;
        font-size: 18px;
        color: #6a11cb;
    }

    .booking-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-pending {
        background-color: #fff3e0;
        color: #ff9800;
    }

    .status-confirmed {
        background-color: #e3f2fd;
        color: #2196f3;
    }

    .status-completed {
        background-color: #e8f5e9;
        color: #4caf50;
    }

    .status-cancelled {
        background-color: #ffebee;
        color: #f44336;
    }

    .booking-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
    }

    .detail-label {
        font-size: 12px;
        color: #888;
        margin-bottom: 5px;
    }

    .detail-value {
        font-size: 14px;
        font-weight: 500;
    }

    .service-info {
        margin-top: 15px;
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 8px;
    }

    .service-name {
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .service-description {
        font-size: 14px;
        color: #666;
        margin-bottom: 10px;
    }

    .service-price {
        font-weight: 600;
        color: #6a11cb;
        font-size: 16px;
    }

    .booking-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-primary {
        background-color: #6a11cb;
        color: white;
    }

    .btn-outline {
        background-color: transparent;
        border: 1px solid #ddd;
        color: #666;
    }

    .btn-danger {
        background-color: #f44336;
        color: white;
    }

    .btn-primary:hover {
        background-color: #5a0db6;
    }

    .btn-outline:hover {
        background-color: #f5f5f5;
    }

    .btn-danger:hover {
        background-color: #d32f2f;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #888;
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        color: #ddd;
    }

    .empty-state h3 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #666;
    }

    .empty-state p {
        font-size: 16px;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .status-filters {
            flex-wrap: wrap;
            justify-content: center;
        }

        .booking-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .booking-actions {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<!-- Enhanced Hero Section -->




<!-- My Bookings Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">My Bookings</h2>
        <div class="bookings-section">
            <div class="section-header">
                <div class="section-title">Service Appointments</div>
                <div class="status-filters">
                    <div class="status-filter active">All</div>
                    <div class="status-filter">Pending</div>
                    <div class="status-filter">Confirmed</div>
                    <div class="status-filter">Completed</div>
                    <div class="status-filter">Cancelled</div>
                </div>
            </div>

            <div class="bookings-list" id="bookingsList">
                <!-- Bookings will be dynamically added here -->
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

    // My Bookings Functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Sample booking data
        const bookings = [
            {
                id: "BKG-00123",
                serviceName: "Wheel Alignment Service",
                serviceDescription: "Professional wheel alignment service to ensure your vehicle drives straight and true.",
                price: "P800",
                status: "completed",
                bookingDate: "2023-12-04",
                serviceDate: "2023-12-06",
                serviceTime: "10:00 AM",
                technician: "Michael Rodriguez"
            },
            {
                id: "BKG-00122",
                serviceName: "Oil Change Service",
                serviceDescription: "Complete oil and filter change with premium synthetic oil.",
                price: "P1,200",
                status: "pending",
                bookingDate: "2023-12-10",
                serviceDate: "2023-12-12",
                serviceTime: "2:00 PM",
                technician: "Sarah Johnson"
            },
            {
                id: "BKG-00119",
                serviceName: "Brake Service",
                serviceDescription: "Inspection and repair of brake system for optimal safety.",
                price: "P2,500",
                status: "confirmed",
                bookingDate: "2023-12-05",
                serviceDate: "2023-12-08",
                serviceTime: "9:00 AM",
                technician: "Robert Chen"
            }
        ];

        // Function to format date
        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('en-US', options);
        }

        // Function to render bookings
        function renderBookings(bookingsToRender = bookings) {
            const bookingsList = document.getElementById('bookingsList');

            if (bookingsToRender.length === 0) {
                bookingsList.innerHTML = `
                    <div class="empty-state">
                        <i class="far fa-calendar-times"></i>
                        <h3>No Bookings Found</h3>
                        <p>You don't have any bookings matching your current filter.</p>
                    </div>
                `;
                return;
            }

            bookingsList.innerHTML = bookingsToRender.map(booking => `
                <div class="booking-card">
                    <div class="booking-header">
                        <div class="booking-id">${booking.id}</div>
                        <div class="booking-status status-${booking.status}">${booking.status}</div>
                    </div>

                    <div class="booking-details">
                        <div class="detail-item">
                            <div class="detail-label">Booking Date</div>
                            <div class="detail-value">${formatDate(booking.bookingDate)}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Service Date</div>
                            <div class="detail-value">${formatDate(booking.serviceDate)}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Service Time</div>
                            <div class="detail-value">${booking.serviceTime}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Technician</div>
                            <div class="detail-value">${booking.technician}</div>
                        </div>
                    </div>

                    <div class="service-info">
                        <div class="service-name">${booking.serviceName}</div>
                        <div class="service-description">${booking.serviceDescription}</div>
                        <div class="service-price">${booking.price}</div>
                    </div>

                    <div class="booking-actions">
                        ${booking.status === 'pending' ? `
                            <button class="btn btn-danger" onclick="cancelBooking('${booking.id}')">Cancel</button>
                            <button class="btn btn-outline" onclick="rescheduleBooking('${booking.id}')">Reschedule</button>
                        ` : ''}
                        ${booking.status === 'confirmed' ? `
                            <button class="btn btn-danger" onclick="cancelBooking('${booking.id}')">Cancel</button>
                            <button class="btn btn-outline" onclick="rescheduleBooking('${booking.id}')">Reschedule</button>
                        ` : ''}
                        ${booking.status === 'completed' ? `
                            <button class="btn btn-outline">View Details</button>
                            <button class="btn btn-primary">Book Again</button>
                        ` : ''}
                    </div>
                </div>
            `).join('');
        }

        // Function to cancel a booking
        window.cancelBooking = function(bookingId) {
            if (confirm(`Are you sure you want to cancel booking ${bookingId}?`)) {
                // In a real app, this would make an API call
                alert(`Booking ${bookingId} has been cancelled.`);
                // Update the UI to reflect the cancellation
                const booking = bookings.find(b => b.id === bookingId);
                if (booking) {
                    booking.status = 'cancelled';
                    renderBookings();
                }
            }
        }

        // Function to reschedule a booking
        window.rescheduleBooking = function(bookingId) {
            // In a real app, this would open a rescheduling modal
            alert(`Rescheduling functionality for ${bookingId} would open here.`);
        }

        // Initialize bookings
        renderBookings();

        // Add filter functionality
        document.querySelectorAll('.status-filter').forEach(filter => {
            filter.addEventListener('click', function() {
                // Remove active class from all filters
                document.querySelectorAll('.status-filter').forEach(f => f.classList.remove('active'));
                // Add active class to clicked filter
                this.classList.add('active');

                const status = this.textContent.toLowerCase();
                let filteredBookings;

                if (status === 'all') {
                    filteredBookings = bookings;
                } else {
                    filteredBookings = bookings.filter(booking => booking.status === status);
                }

                renderBookings(filteredBookings);
            });
        });
    });
</script>
@endsection
