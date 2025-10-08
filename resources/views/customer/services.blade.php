@extends('layouts.customer.app')

@section('content')
<!-- Services Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="section-title text-start mb-2">Our Services</h1>
                <p class="lead mb-0">Professional automotive services to keep your vehicle in top condition and ensure your safety on the road</p>
                <div class="mt-3">
                    <span class="badge bg-success me-2">
                        <i class="fas fa-check-circle me-1"></i>All Services Available for Booking
                    </span>
                    <span class="badge bg-info">
                        <i class="fas fa-users me-1"></i>{{ Auth::user()->fname ?? 'Customer' }}, Book Your Service Now!
                    </span>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('customer.booking') }}" class="btn btn-primary btn-lg pulse-animation">
                    <i class="fas fa-calendar-plus me-2"></i>View My Bookings
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5">
    <div class="container">
        <!-- Enhanced Filter Form -->
        <div class="card mb-5">
            <div class="card-body">
                <form method="GET" action="#" class="row g-3">
                    <div class="col-lg-5 col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Search services...">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <select name="sort" class="form-select">
                            <option value="">Sort by: Featured</option>
                            <option value="price_asc">Price: Low to High</option>
                            <option value="price_desc">Price: High to Low</option>
                            <option value="name_asc">Name: A to Z</option>
                            <option value="name_desc">Name: Z to A</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <button class="btn btn-primary w-100" type="submit">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Services Grid -->
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
                        
                        <!-- Availability Status -->
                        <div class="availability-status mb-2">
                            @if($service->is_available)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Available
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-times-circle me-1"></i>Not Available
                                </span>
                            @endif
                        </div>
                        
                        <div class="service-details mb-3">
                            <div class="row text-center">
                                <div class="col-12">
                                    <small class="text-muted d-block">Price</small>
                                    <strong class="text-primary">₱{{ number_format($service->service_price, 2) }}</strong>
                                </div>
                            </div>
                        </div>
                        
                        @if($service->is_available)
                            <button class="btn btn-success book-btn w-100"
                                    data-id="{{ $service->service_id }}"
                                    data-name="{{ $service->service_name }}"
                                    data-price="{{ $service->service_price }}"
                                    data-description="{{ $service->description }}"
                                    data-duration="N/A">
                                <i class="fas fa-calendar-check me-2"></i>Book This Service
                            </button>
                            <small class="text-success d-block mt-2">
                                <i class="fas fa-check-circle me-1"></i>Available for all customers
                            </small>
                        @else
                            <button class="btn btn-secondary w-100" disabled>
                                <i class="fas fa-ban me-2"></i>Temporarily Unavailable
                            </button>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle me-1"></i>Check back later
                            </small>
                        @endif
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

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="bookingForm" method="POST" action="{{ route('customer.booking.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">
                        <i class="fas fa-calendar-plus me-2"></i>Book Service
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Booking Error!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <input type="hidden" name="service_id" id="modalServiceId">

                    <!-- Service Summary -->
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="mb-1" id="modalServiceName">Service Name</h6>
                                    <p class="text-muted mb-0" id="modalServiceDescription">Service description</p>
                                    <small class="text-muted" id="modalServiceDuration">Duration: 30 mins</small>
                                </div>
                                <div class="col-md-4 text-end">
                                    <h4 class="text-primary mb-0" id="modalServicePrice">P0.00</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customerName" class="form-label">Your Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="customerName" name="customer_name" value="{{ auth()->user()->full_name ?? (auth()->user()->fname ?? '') }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customerContact" class="form-label">Contact Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="customerContact" name="customer_contact" value="{{ auth()->user()->phone ?? '' }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bookingDate" class="form-label">Preferred Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="bookingDate" name="booking_date" required min="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bookingTime" class="form-label">Preferred Time <span class="text-danger">*</span></label>
                                <select class="form-select" id="bookingTime" name="booking_time" required>
                                    <option value="">Select time</option>
                                    <option value="08:00">8:00 AM</option>
                                    <option value="09:00">9:00 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="13:00">1:00 PM</option>
                                    <option value="14:00">2:00 PM</option>
                                    <option value="15:00">3:00 PM</option>
                                    <option value="16:00">4:00 PM</option>
                                </select>
                                <small class="text-muted d-block mt-1" id="timeSlotHint">Select a date first to see available time slots</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="paymentMethod" class="form-label">Payment Method <span class="text-danger">*</span></label>
                                <select class="form-select" id="paymentMethod" name="payment_method" required>
                                    <option value="Cash">Cash</option>
                                    <option value="GCash">GCash</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Debit Card">Debit Card</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="specialRequests" class="form-label">Notes</label>
                                <input type="text" class="form-control" id="bookingNotes" name="notes" placeholder="What needs to be fixed?">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="specialRequests" class="form-label">Special Requests</label>
                        <textarea class="form-control" id="specialRequests" name="special_requests" rows="3" placeholder="Any additional information or special requirements..."></textarea>
                    </div>

                    <!-- Payment Details Section (Hidden by default) -->
                    <div id="bookingPaymentDetails" style="display: none;">
                        <hr>
                        <h6 class="mb-3"><i class="fas fa-credit-card me-2"></i>Payment Details</h6>
                        
                        <div class="mb-3">
                            <label for="bookingCardNumber" class="form-label">Card Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="bookingCardNumber" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bookingCardName" class="form-label">Cardholder Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="bookingCardName" name="card_name" placeholder="John Doe">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="bookingCardExpiry" class="form-label">Expiry <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="bookingCardExpiry" name="card_expiry" placeholder="MM/YY" maxlength="5">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="bookingCardCvv" class="form-label">CVV <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="bookingCardCvv" name="card_cvv" placeholder="123" maxlength="4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="confirmBookingBtn">
                        <i class="fas fa-calendar-check me-2"></i>Confirm Booking
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Why Choose Us Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center">Why Choose Our Services?</h2>
        <p class="lead text-center mb-5">We are committed to providing the highest quality automotive services</p>
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center mb-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-certificate"></i>
                </div>
                <h5>Certified Technicians</h5>
                <p class="text-muted">Our team consists of certified and experienced automotive technicians with years of expertise.</p>
            </div>
            <div class="col-lg-3 col-md-6 text-center mb-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-tools"></i>
                </div>
                <h5>Quality Equipment</h5>
                <p class="text-muted">We use state-of-the-art equipment and genuine parts for all our services and repairs.</p>
            </div>
            <div class="col-lg-3 col-md-6 text-center mb-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h5>Warranty Included</h5>
                <p class="text-muted">All our services come with a comprehensive warranty for your peace of mind.</p>
            </div>
            <div class="col-lg-3 col-md-6 text-center mb-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-clock"></i>
                </div>
                <h5>Quick Service</h5>
                <p class="text-muted">We value your time and strive to complete most services within 30-60 minutes.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="mb-3">Need Emergency Service?</h3>
                <p class="mb-0">We offer emergency repair services and roadside assistance. Contact us immediately!</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="tel:+1234567890" class="btn btn-light btn-lg">
                    <i class="fas fa-phone-alt me-2"></i>Call Now
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
.service-card {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    overflow: hidden;
}

.service-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 12px 35px rgba(52, 152, 219, 0.2);
}

.service-unavailable {
    opacity: 0.7;
    background-color: #f8f9fa;
}

.service-unavailable:hover {
    transform: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.service-icon {
    width: 90px;
    height: 90px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, #3498db, #2980b9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
    transition: all 0.3s ease;
}

.service-card:hover .service-icon {
    transform: rotate(15deg) scale(1.1);
}

.availability-status .badge {
    font-size: 0.8rem;
    padding: 0.6rem 1rem;
    border-radius: 50px;
    font-weight: 700;
}

.feature-icon {
    width: 90px;
    height: 90px;
    background: linear-gradient(135deg, #3498db, #2980b9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 2.5rem;
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
    transition: all 0.3s ease;
}

.feature-icon:hover {
    transform: rotate(15deg) scale(1.1);
}

/* Pulse Animation for CTA */
.pulse-animation {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 6px 25px rgba(52, 152, 219, 0.5);
    }
}

/* Book Button Enhancement */
.book-btn {
    font-weight: 700;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.book-btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.book-btn:hover::before {
    width: 300px;
    height: 300px;
}

.book-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
}

/* Badge Enhancements */
.badge {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 600;
}

.service-details {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 1.25rem;
    border-radius: 12px;
}

.service-details strong {
    font-size: 1.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #3498db, #2980b9);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Reopen modal if there are errors (from previous submission)
    @if($errors->any() && old('service_id'))
        const serviceId = "{{ old('service_id') }}";
        // Find the service button and trigger it
        const serviceBtn = document.querySelector(`[data-id="${serviceId}"]`);
        if (serviceBtn) {
            serviceBtn.click();
        }
    @endif

    // Initialize booking modal
    document.querySelectorAll('.book-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            document.getElementById('modalServiceId').value = this.getAttribute('data-id');
            document.getElementById('modalServiceName').textContent = this.getAttribute('data-name');
            document.getElementById('modalServicePrice').textContent = 'P' + parseFloat(this.getAttribute('data-price')).toLocaleString('en-PH', {minimumFractionDigits: 2});
            document.getElementById('modalServiceDescription').textContent = this.getAttribute('data-description');
            document.getElementById('modalServiceDuration').textContent = 'Duration: ' + this.getAttribute('data-duration');

            var modal = new bootstrap.Modal(document.getElementById('bookingModal'));
            modal.show();
        });
    });

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('bookingDate').min = today;

    // Current service ID being booked
    let currentServiceId = null;

    // Check time slot availability when date changes
    document.getElementById('bookingDate').addEventListener('change', function() {
        const selectedDate = this.value;
        const serviceId = document.getElementById('modalServiceId').value;
        
        if (!selectedDate || !serviceId) {
            return;
        }

        // Fetch booked time slots for this service and date
        fetch(`{{ route('customer.services.check-availability') }}?service_id=${serviceId}&date=${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                const timeSelect = document.getElementById('bookingTime');
                const timeOptions = timeSelect.querySelectorAll('option');
                const hint = document.getElementById('timeSlotHint');
                
                // Reset all options
                timeOptions.forEach(option => {
                    if (option.value) {
                        option.disabled = false;
                        option.textContent = option.textContent.replace(' (Booked)', '');
                    }
                });
                
                // Disable booked time slots
                if (data.booked_times && data.booked_times.length > 0) {
                    data.booked_times.forEach(bookedTime => {
                        timeOptions.forEach(option => {
                            if (option.value === bookedTime) {
                                option.disabled = true;
                                option.textContent += ' (Booked)';
                            }
                        });
                    });
                    hint.textContent = `${data.booked_times.length} time slot(s) already booked for this date`;
                    hint.classList.remove('text-muted');
                    hint.classList.add('text-warning');
                } else {
                    hint.textContent = 'All time slots are available for this date';
                    hint.classList.remove('text-warning');
                    hint.classList.add('text-success');
                }
            })
            .catch(error => {
                console.error('Error checking availability:', error);
            });
    });

    // Payment method change handler - show/hide card fields
    document.getElementById('paymentMethod').addEventListener('change', function() {
        const paymentDetails = document.getElementById('bookingPaymentDetails');
        const cardFields = ['bookingCardNumber', 'bookingCardName', 'bookingCardExpiry', 'bookingCardCvv'];
        
        if (this.value === 'Credit Card' || this.value === 'Debit Card') {
            paymentDetails.style.display = 'block';
            // Make card fields required
            cardFields.forEach(function(fieldId) {
                document.getElementById(fieldId).setAttribute('required', 'required');
            });
        } else {
            paymentDetails.style.display = 'none';
            // Remove required attribute
            cardFields.forEach(function(fieldId) {
                document.getElementById(fieldId).removeAttribute('required');
                document.getElementById(fieldId).value = '';
            });
        }
    });

    // Card number formatting for booking
    const bookingCardNumber = document.getElementById('bookingCardNumber');
    if (bookingCardNumber) {
        bookingCardNumber.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let matches = value.match(/\d{4,16}/g);
            let match = matches && matches[0] || '';
            let parts = [];

            for (let i = 0, len = match.length; i < len; i += 4) {
                parts.push(match.substring(i, i + 4));
            }

            if (parts.length) {
                e.target.value = parts.join(' ');
            } else {
                e.target.value = value;
            }
        });
    }

    // Expiry date formatting for booking
    const bookingCardExpiry = document.getElementById('bookingCardExpiry');
    if (bookingCardExpiry) {
        bookingCardExpiry.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });
    }

    // CVV formatting for booking
    const bookingCardCvv = document.getElementById('bookingCardCvv');
    if (bookingCardCvv) {
        bookingCardCvv.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    }

    // Form submission handler
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        const paymentMethod = document.getElementById('paymentMethod').value;
        
        // Validate card fields if credit/debit card
        if (paymentMethod === 'Credit Card' || paymentMethod === 'Debit Card') {
            const cardNumber = document.getElementById('bookingCardNumber').value;
            const cardName = document.getElementById('bookingCardName').value;
            const expiry = document.getElementById('bookingCardExpiry').value;
            const cvv = document.getElementById('bookingCardCvv').value;
            
            if (!cardNumber || !cardName || !expiry || !cvv) {
                e.preventDefault();
                alert('Please fill in all card details.');
                return;
            }
        }
        
        // Show processing state
        const btn = document.getElementById('confirmBookingBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
        btn.disabled = true;
    });
});
</script>
@endsection
