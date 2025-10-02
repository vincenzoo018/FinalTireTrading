@extends('layouts.customer.app')

@section('content')
<!-- Booking Header -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">Book a Service</h1>
        <p class="lead">Schedule your vehicle service with our professional technicians</p>
    </div>
</section>

<!-- Booking Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="booking-form">
                    <h3 class="mb-4">Service Information</h3>
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="serviceType" class="form-label">Service Type</label>
                                <select class="form-select" id="serviceType" required>
                                    <option value="">Select Service</option>
                                    <option value="alignment">Wheel Alignment</option>
                                    <option value="tire_replacement">Tire Replacement</option>
                                    <option value="brake_service">Brake Service</option>
                                    <option value="oil_change">Oil Change</option>
                                    <option value="battery">Battery Replacement</option>
                                    <option value="filter">Filter Replacement</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="vehicleType" class="form-label">Vehicle Type</label>
                                <select class="form-select" id="vehicleType" required>
                                    <option value="">Select Vehicle Type</option>
                                    <option value="sedan">Sedan</option>
                                    <option value="suv">SUV</option>
                                    <option value="truck">Truck</option>
                                    <option value="van">Van</option>
                                    <option value="motorcycle">Motorcycle</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="date" class="form-label">Preferred Date</label>
                                <input type="date" class="form-control" id="date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="time" class="form-label">Preferred Time</label>
                                <select class="form-select" id="time" required>
                                    <option value="">Select Time</option>
                                    <option value="08:00">8:00 AM</option>
                                    <option value="09:00">9:00 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="13:00">1:00 PM</option>
                                    <option value="14:00">2:00 PM</option>
                                    <option value="15:00">3:00 PM</option>
                                    <option value="16:00">4:00 PM</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="comments" class="form-label">Additional Comments</label>
                            <textarea class="form-control" id="comments" rows="3" placeholder="Any special requests or details about your vehicle..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Vehicle Photos (Optional)</label>
                            <input type="file" class="form-control" multiple>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg">Confirm Booking</button>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Booking Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Service:</span>
                            <span id="selectedService">Not selected</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Vehicle:</span>
                            <span id="selectedVehicle">Not selected</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Date:</span>
                            <span id="selectedDate">Not selected</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Time:</span>
                            <span id="selectedTime">Not selected</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <strong>Estimated Cost:</strong>
                            <strong id="estimatedCost">P0</strong>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h6>Need Assistance?</h6>
                        <p class="small mb-2"><i class="fas fa-phone me-2"></i> (082) 123-4567</p>
                        <p class="small mb-2"><i class="fas fa-envelope me-2"></i> service@8plytire.com</p>
                        <p class="small mb-0"><i class="fas fa-clock me-2"></i> Mon-Fri: 8AM-6PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('scripts')
<!-- No scripts: all functions removed, design only -->
@endsection
@endsection
