@extends('layouts.customer.app')

@section('content')
<!-- Services Header -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">Our Services</h1>
        <p class="lead">Professional automotive services to keep your vehicle in top condition</p>
    </div>
</section>

<!-- Services Section -->
<section class="py-5">
    <div class="container">
        <!-- Filter Form -->
        <form method="GET" action="#" class="row mb-4 g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search services...">
            </div>
            <div class="col-md-4">
                <select name="sort" class="form-select">
                    <option value="">Sort by: Featured</option>
                    <option value="price_asc">Price: Low to High</option>
                    <option value="price_desc">Price: High to Low</option>
                    <option value="name_asc">Name: A to Z</option>
                    <option value="name_desc">Name: Z to A</option>
                </select>
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary w-100" type="submit">Filter</button>
            </div>
        </form>

        <!-- Static Services Grid -->
        <div class="row">
            <!-- Example Service Card -->
            <div class="col-md-4 mb-4">
                <div class="card service-card text-center h-100">
                    <div class="card-body">
                        <div class="service-icon mb-2">
                            <i class="fas fa-car-side fa-2x"></i>
                        </div>
                        <h5 class="card-title">Wheel Alignment</h5>
                        <p class="card-text">Ensure your wheels are properly aligned for smooth driving.</p>
                        <p class="price">P1,200.00</p>
                        <div class="mb-2">
                            <span class="badge bg-success">Available</span>
                        </div>
                        <button class="btn btn-primary book-btn" 
                            data-id="1"
                            data-name="Wheel Alignment"
                            data-price="1200"
                            data-description="Ensure your wheels are properly aligned for smooth driving.">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>

            <!-- Another Example Service Card -->
            <div class="col-md-4 mb-4">
                <div class="card service-card text-center h-100">
                    <div class="card-body">
                        <div class="service-icon mb-2">
                            <i class="fas fa-oil-can fa-2x"></i>
                        </div>
                        <h5 class="card-title">Oil Change</h5>
                        <p class="card-text">Keep your engine running smoothly with fresh oil.</p>
                        <p class="price">P800.00</p>
                        <div class="mb-2">
                            <span class="badge bg-success">Available</span>
                        </div>
                        <button class="btn btn-primary book-btn" 
                            data-id="2"
                            data-name="Oil Change"
                            data-price="800"
                            data-description="Keep your engine running smoothly with fresh oil.">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>

            <!-- Another Example Service Card -->
            <div class="col-md-4 mb-4">
                <div class="card service-card text-center h-100">
                    <div class="card-body">
                        <div class="service-icon mb-2">
                            <i class="fas fa-cogs fa-2x"></i>
                        </div>
                        <h5 class="card-title">Brake Inspection</h5>
                        <p class="card-text">Ensure safety with our complete brake system inspection.</p>
                        <p class="price">P1,500.00</p>
                        <div class="mb-2">
                            <span class="badge bg-secondary">Not Available</span>
                        </div>
                        <button class="btn btn-primary disabled" tabindex="-1" aria-disabled="true">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Modal -->
        <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="bookingForm" method="POST" action="#">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bookingModalLabel">Book Service</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="service_id" id="modalServiceId">
                            <div class="mb-3">
                                <label for="modalServiceName" class="form-label">Service</label>
                                <input type="text" class="form-control" id="modalServiceName" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="modalServicePrice" class="form-label">Price</label>
                                <input type="text" class="form-control" id="modalServicePrice" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="modalServiceDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="modalServiceDescription" rows="2" readonly></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="customerName" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="customerName" name="customer_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="customerContact" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="customerContact" name="customer_contact" required>
                            </div>
                            <div class="mb-3">
                                <label for="bookingDate" class="form-label">Preferred Date</label>
                                <input type="date" class="form-control" id="bookingDate" name="booking_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="vehicleInfo" class="form-label">Vehicle Info</label>
                                <input type="text" class="form-control" id="vehicleInfo" name="vehicle_info" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit Booking</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.book-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    document.getElementById('modalServiceId').value = this.getAttribute('data-id');
                    document.getElementById('modalServiceName').value = this.getAttribute('data-name');
                    document.getElementById('modalServicePrice').value = 'P' + parseFloat(this.getAttribute('data-price')).toFixed(2);
                    document.getElementById('modalServiceDescription').value = this.getAttribute('data-description');
                    var modal = new bootstrap.Modal(document.getElementById('bookingModal'));
                    modal.show();
                });
            });
        });
        </script>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center">Why Choose Our Services?</h2>
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-certificate fa-3x text-primary"></i>
                </div>
                <h5>Certified Technicians</h5>
                <p>Our team consists of certified and experienced automotive technicians.</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-tools fa-3x text-primary"></i>
                </div>
                <h5>Quality Equipment</h5>
                <p>We use state-of-the-art equipment for all our services.</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-shield-alt fa-3x text-primary"></i>
                </div>
                <h5>Warranty Included</h5>
                <p>All our services come with a comprehensive warranty.</p>
            </div>
        </div>
    </div>
</section>
@endsection
