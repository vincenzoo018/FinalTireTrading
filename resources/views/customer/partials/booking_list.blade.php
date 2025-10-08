@foreach($list as $booking)
    <div class="card order-card mb-4 border-0 shadow-sm" @if(session('highlight_booking_id') == $booking->booking_id) style="border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,0.1)" @endif>
        <div class="card-header border-0">
            <div class="booking-header">
                <div class="booking-id">
                    Booking #{{ $booking->booking_id }}
                </div>
                @php
                    $status = strtolower($booking->status);
                    $statusClass = match($status) {
                        'pending' => 'status-pending',
                        'confirmed' => 'status-confirmed',
                        'completed' => 'status-completed',
                        'cancelled' => 'status-cancelled',
                        default => 'status-pending'
                    };
                @endphp
                <span class="booking-status {{ $statusClass }}">{{ ucfirst($booking->status) }}</span>
            </div>
            
            <div class="booking-details">
                <div class="detail-item">
                    <span class="detail-label">Booking Date</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('F d, Y') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Time</span>
                    <span class="detail-value">{{ $booking->booking_time }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Payment Method</span>
                    <span class="detail-value">{{ $booking->payment_method ?? 'Cash' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Service Price</span>
                    <span class="detail-value">₱{{ number_format($booking->service->service_price ?? 0, 2) }}</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h6 class="mb-3 fw-bold text-primary">
                <i class="fas fa-cogs me-2"></i>Service Details
            </h6>
            
            <div class="order-item-card mb-3 p-3 border rounded-3 bg-light">
                <div class="row align-items-center g-3">
                    <div class="col-auto">
                        <div class="service-icon-wrapper">
                            <div class="service-icon rounded-3 shadow-sm d-flex align-items-center justify-content-center">
                                <i class="fas fa-tools fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="service-details">
                            <h6 class="service-name mb-2 fw-bold text-dark">{{ $booking->service->service_name ?? 'Service' }}</h6>
                            <div class="service-specs d-flex flex-wrap gap-3 mb-2">
                                <span class="spec-item">
                                    <i class="fas fa-calendar text-primary me-1"></i>
                                    <small class="text-muted">Date: <strong>{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</strong></small>
                                </span>
                                <span class="spec-item">
                                    <i class="fas fa-clock text-success me-1"></i>
                                    <small class="text-muted">Time: <strong>{{ $booking->booking_time }}</strong></small>
                                </span>
                                <span class="spec-item">
                                    <i class="fas fa-credit-card text-info me-1"></i>
                                    <small class="text-muted">Payment: <strong>{{ $booking->payment_method ?? 'Cash' }}</strong></small>
                                </span>
                            </div>
                            <p class="service-description mb-0">
                                <small class="text-muted">{{ $booking->service->description ?? 'Professional tire service' }}</small>
                            </p>
                            @if($booking->notes)
                                <div class="mt-2 p-2 bg-warning bg-opacity-10 rounded">
                                    <small><strong>Special Notes:</strong> {{ $booking->notes }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-auto text-end">
                        <div class="pricing-info">
                            <div class="service-price">
                                <small class="text-muted">Service Price:</small>
                                <div class="fw-bold text-success fs-4">₱{{ number_format($booking->service->service_price ?? 0, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3 flex-wrap">
                <!-- View Receipt Button - Always Show -->
                <a href="{{ route('customer.booking.receipt', $booking->booking_id) }}" 
                   class="btn btn-outline-success" target="_blank">
                    <i class="fas fa-receipt me-1"></i>View Receipt
                </a>

                @if(strtolower($booking->status) === 'pending')
                    <form method="POST" action="{{ route('customer.booking.cancel', $booking) }}" 
                          onsubmit="return confirm('Cancel this pending booking?')" class="d-flex gap-2 flex-grow-1">
                        @csrf
                        <input type="text" name="cancelled_reason" class="form-control" placeholder="Optional reason">
                        <button class="btn btn-outline-danger">
                            <i class="fas fa-times me-1"></i>Cancel Booking
                        </button>
                    </form>
                @elseif(strtolower($booking->status) === 'confirmed')
                    <form method="POST" action="{{ route('customer.booking.completed', $booking) }}" 
                          onsubmit="return confirm('Mark this booking as completed?')">
                        @csrf
                        <button class="btn btn-success">
                            <i class="fas fa-check me-1"></i>Mark as Completed
                        </button>
                    </form>
                @elseif(strtolower($booking->status) === 'completed')
                    <div class="alert alert-success d-flex align-items-center mb-0 flex-grow-1">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>
                            <strong>Service Completed!</strong>
                            @if($booking->sale()->exists())
                                <small class="d-block text-muted">
                                    <i class="fas fa-receipt me-1"></i>Sale Record: #{{ $booking->sale->sale_id }} (₱{{ number_format($booking->sale->total_amount, 2) }})
                                </small>
                            @else
                                <small class="d-block text-muted">Sale record will be generated automatically</small>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach

@if(($list ?? collect())->isEmpty())
    <div class="empty-state">
        <i class="far fa-calendar-times"></i>
        <h3>No Bookings Found</h3>
        <p>You don't have any bookings in this section.</p>
    </div>
@endif


