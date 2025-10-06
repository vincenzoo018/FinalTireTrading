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
        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif
        <h2 class="section-title text-center mb-5">My Bookings</h2>
        <div class="bookings-section">
            <div class="section-header">
                <div class="section-title">Service Appointments</div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-all" type="button" role="tab">
                                <i class="fas fa-list me-2"></i>All
                                <span class="badge bg-primary ms-2">{{ ($bookings ?? collect())->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-pending" type="button" role="tab">
                                <i class="fas fa-clock me-2"></i>Pending
                                <span class="badge bg-warning ms-2">{{ ($bookings ?? collect())->where('status','pending')->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-confirmed" type="button" role="tab">
                                <i class="fas fa-check-circle me-2"></i>Confirmed
                                <span class="badge bg-info ms-2">{{ ($bookings ?? collect())->where('status','confirmed')->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-completed" type="button" role="tab">
                                <i class="fas fa-history me-2"></i>Completed
                                <span class="badge bg-success ms-2">{{ ($bookings ?? collect())->where('status','completed')->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-cancelled" type="button" role="tab">
                                <i class="fas fa-times-circle me-2"></i>Cancelled
                                <span class="badge bg-danger ms-2">{{ ($bookings ?? collect())->where('status','cancelled')->count() }}</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content mt-4">
                <div class="tab-pane fade show active" id="tab-all" role="tabpanel">
                    <div class="bookings-list">
                        @include('customer.partials.booking_list', ['list' => $bookings ?? collect()])
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-pending" role="tabpanel">
                    <div class="bookings-list">
                        @include('customer.partials.booking_list', ['list' => ($bookings ?? collect())->where('status','pending')])
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-confirmed" role="tabpanel">
                    <div class="bookings-list">
                        @include('customer.partials.booking_list', ['list' => ($bookings ?? collect())->where('status','confirmed')])
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-completed" role="tabpanel">
                    <div class="bookings-list">
                        @include('customer.partials.booking_list', ['list' => ($bookings ?? collect())->where('status','completed')])
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-cancelled" role="tabpanel">
                    <div class="bookings-list">
                        @include('customer.partials.booking_list', ['list' => ($bookings ?? collect())->where('status','cancelled')])
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Removed filler sections to focus on actual bookings -->
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

    // Removed sample bookings JS; server-rendered bookings are shown above
</script>
@endsection
