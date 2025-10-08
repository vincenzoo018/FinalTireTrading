<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Receipt - #{{ $booking->booking_id }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f8fafc; padding: 2rem; }
        .receipt-container { max-width: 800px; margin: 0 auto; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-radius: 1rem; overflow: hidden; }
        .receipt-header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 2rem; text-align: center; }
        .receipt-header h1 { font-size: 2rem; margin-bottom: 0.5rem; }
        .receipt-body { padding: 2rem; }
        .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 2rem; }
        .info-card { background: #f8fafc; padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid #10b981; }
        .info-card h3 { font-size: 0.875rem; text-transform: uppercase; color: #10b981; margin-bottom: 1rem; font-weight: 600; }
        .info-row { display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.9375rem; }
        .service-card { background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); padding: 2rem; border-radius: 0.75rem; margin-bottom: 2rem; border: 2px solid #10b981; }
        .service-card h2 { color: #065f46; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.75rem; }
        .service-details { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-top: 1rem; }
        .service-detail { background: white; padding: 1rem; border-radius: 0.5rem; }
        .totals-section { background: #f8fafc; padding: 1.5rem; border-radius: 0.5rem; max-width: 400px; margin-left: auto; }
        .total-row { display: flex; justify-content: space-between; padding: 0.75rem 0; }
        .total-row.grand-total { border-top: 2px solid #10b981; margin-top: 0.5rem; padding-top: 1rem; font-size: 1.5rem; font-weight: 700; }
        .total-row.grand-total .total-value { color: #10b981; }
        .footer { background: #f8fafc; padding: 2rem; text-align: center; border-top: 1px solid #e2e8f0; }
        .btn { padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; margin: 0 0.5rem; }
        .btn-print { background: #10b981; color: white; }
        .btn-close { background: #e2e8f0; color: #475569; }
        .status-badge { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; border-radius: 9999px; font-weight: 600; font-size: 0.875rem; }
        .status-confirmed { background: #dbeafe; color: #1e40af; }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-pending { background: #fed7aa; color: #92400e; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        @media print { body { background: white; padding: 0; } .footer .btn { display: none; } }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h1><i class="fas fa-calendar-check"></i> BOOKING RECEIPT</h1>
            <p>Booking #{{ $booking->booking_id }}</p>
            <p style="opacity: 0.9; margin-top: 0.5rem;">{{ \Carbon\Carbon::parse($booking->created_at)->format('F d, Y h:i A') }}</p>
        </div>

        <div class="receipt-body">
            <div class="info-grid">
                <div class="info-card">
                    <h3><i class="fas fa-user"></i> Customer Information</h3>
                    <div class="info-row">
                        <span style="color: #64748b;">Name:</span>
                        <strong>{{ $booking->user->name }}</strong>
                    </div>
                    <div class="info-row">
                        <span style="color: #64748b;">Email:</span>
                        <strong>{{ $booking->user->email }}</strong>
                    </div>
                    <div class="info-row">
                        <span style="color: #64748b;">Phone:</span>
                        <strong>{{ $booking->user->phone ?? 'N/A' }}</strong>
                    </div>
                </div>

                <div class="info-card">
                    <h3><i class="fas fa-info-circle"></i> Booking Details</h3>
                    <div class="info-row">
                        <span style="color: #64748b;">Booking ID:</span>
                        <strong>#{{ $booking->booking_id }}</strong>
                    </div>
                    <div class="info-row">
                        <span style="color: #64748b;">Status:</span>
                        <strong>
                            <span class="status-badge status-{{ $booking->status }}">
                                @if($booking->status == 'confirmed')
                                    <i class="fas fa-check-circle"></i>
                                @elseif($booking->status == 'completed')
                                    <i class="fas fa-check-double"></i>
                                @elseif($booking->status == 'pending')
                                    <i class="fas fa-clock"></i>
                                @else
                                    <i class="fas fa-times-circle"></i>
                                @endif
                                {{ ucfirst($booking->status) }}
                            </span>
                        </strong>
                    </div>
                    <div class="info-row">
                        <span style="color: #64748b;">Payment:</span>
                        <strong>{{ $payment->payment_method ?? $booking->payment_method ?? 'N/A' }}</strong>
                    </div>
                </div>
            </div>

            <div class="service-card">
                <h2><i class="fas fa-wrench"></i> Service Details</h2>
                <div style="font-size: 1.25rem; font-weight: 700; color: #065f46; margin-bottom: 0.5rem;">
                    {{ $booking->service->service_name }}
                </div>
                <p style="color: #047857; margin-bottom: 1.5rem;">{{ $booking->service->description }}</p>
                
                <div class="service-details">
                    <div class="service-detail">
                        <div style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.25rem;">
                            <i class="fas fa-calendar"></i> Booking Date
                        </div>
                        <strong style="color: #065f46; font-size: 1.125rem;">
                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                        </strong>
                    </div>
                    <div class="service-detail">
                        <div style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.25rem;">
                            <i class="fas fa-clock"></i> Booking Time
                        </div>
                        <strong style="color: #065f46; font-size: 1.125rem;">{{ $booking->booking_time }}</strong>
                    </div>
                    <div class="service-detail">
                        <div style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.25rem;">
                            <i class="fas fa-hourglass-half"></i> Duration
                        </div>
                        <strong style="color: #065f46; font-size: 1.125rem;">{{ $booking->service->duration ?? 'N/A' }}</strong>
                    </div>
                    <div class="service-detail">
                        <div style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.25rem;">
                            <i class="fas fa-dollar-sign"></i> Service Price
                        </div>
                        <strong style="color: #065f46; font-size: 1.125rem;">₱{{ number_format($booking->service->service_price, 2) }}</strong>
                    </div>
                </div>

                @if($booking->notes)
                <div style="margin-top: 1.5rem; background: white; padding: 1rem; border-radius: 0.5rem;">
                    <div style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.5rem;">
                        <i class="fas fa-sticky-note"></i> Notes
                    </div>
                    <p style="color: #1e293b;">{{ $booking->notes }}</p>
                </div>
                @endif
            </div>

            @if($payment)
            <div style="background: #eff6ff; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem; border-left: 4px solid #3b82f6;">
                <h3 style="color: #1e40af; margin-bottom: 1rem;"><i class="fas fa-credit-card"></i> Payment Information</h3>
                <div class="info-row">
                    <span style="color: #64748b;">Transaction ID:</span>
                    <strong>{{ $payment->transaction_id }}</strong>
                </div>
                <div class="info-row">
                    <span style="color: #64748b;">Payment Method:</span>
                    <strong>{{ $payment->payment_method }}</strong>
                </div>
                <div class="info-row">
                    <span style="color: #64748b;">Payment Date:</span>
                    <strong>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y h:i A') : 'N/A' }}</strong>
                </div>
                <div class="info-row">
                    <span style="color: #64748b;">Status:</span>
                    <strong style="color: #10b981;">{{ ucfirst($payment->payment_status) }}</strong>
                </div>
            </div>
            @endif

            <div class="totals-section">
                <div class="total-row">
                    <span>Service Fee:</span>
                    <strong>₱{{ number_format($booking->service->service_price, 2) }}</strong>
                </div>
                @if($payment && $payment->amount != $booking->service->service_price)
                <div class="total-row">
                    <span>Additional Charges:</span>
                    <strong>₱{{ number_format($payment->amount - $booking->service->service_price, 2) }}</strong>
                </div>
                @endif
                <div class="total-row grand-total">
                    <span>Total Amount:</span>
                    <span class="total-value">₱{{ number_format($payment ? $payment->amount : $booking->service->service_price, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p style="color: #64748b; margin-bottom: 1rem;">Thank you for booking with us!</p>
            <p style="color: #64748b; font-size: 0.875rem; margin-bottom: 1rem;">We look forward to serving you on {{ \Carbon\Carbon::parse($booking->booking_date)->format('F d, Y') }} at {{ $booking->booking_time }}</p>
            <button class="btn btn-print" onclick="window.print()"><i class="fas fa-print"></i> Print Receipt</button>
            <button class="btn btn-close" onclick="window.close()"><i class="fas fa-times"></i> Close</button>
        </div>
    </div>
</body>
</html>
