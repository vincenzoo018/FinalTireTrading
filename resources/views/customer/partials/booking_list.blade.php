@foreach($list as $booking)
    <div class="booking-card" @if(session('highlight_booking_id') == $booking->booking_id) style="border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,0.1)" @endif>
        <div class="booking-header">
            <div class="booking-id">Booking #{{ $booking->booking_id }}</div>
            <div class="booking-status status-{{ strtolower($booking->status) }}">{{ ucfirst($booking->status) }}</div>
        </div>

        <div class="booking-details">
            <div class="detail-item">
                <div class="detail-label">Booking Date</div>
                <div class="detail-value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Time</div>
                <div class="detail-value">{{ $booking->booking_time }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Payment</div>
                <div class="detail-value">{{ $booking->payment_method }}</div>
            </div>
        </div>

        <div class="service-info">
            <div class="service-name">{{ $booking->service->service_name ?? 'Service' }}</div>
            <div class="service-description">{{ $booking->service->description ?? '' }}</div>
            <div class="service-price">P{{ number_format($booking->service->service_price ?? 0, 2) }}</div>
            @if($booking->notes)
                <div class="mt-2"><strong>Notes:</strong> {{ $booking->notes }}</div>
            @endif
        </div>

        @if(strtolower($booking->status) === 'pending')
            <form method="POST" action="{{ route('customer.booking.cancel', $booking) }}" onsubmit="return confirm('Cancel this pending booking?')" class="booking-actions">
                @csrf
                <button type="submit" class="btn btn-danger">Cancel</button>
            </form>
        @elseif(strtolower($booking->status) === 'confirmed')
            <form method="POST" action="{{ route('customer.booking.completed', $booking) }}" onsubmit="return confirm('Mark this booking as completed?')" class="booking-actions">
                @csrf
                <button type="submit" class="btn btn-primary">Mark as Completed</button>
            </form>
        @endif
    </div>
@endforeach

@if(($list ?? collect())->isEmpty())
    <div class="empty-state">
        <i class="far fa-calendar-times"></i>
        <h3>No Bookings Found</h3>
        <p>You don't have any bookings in this section.</p>
    </div>
@endif


