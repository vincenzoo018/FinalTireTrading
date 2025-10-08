<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt - #{{ $order->order_id }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f8fafc; padding: 2rem; }
        .receipt-container { max-width: 800px; margin: 0 auto; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-radius: 1rem; overflow: hidden; }
        .receipt-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; text-align: center; }
        .receipt-header h1 { font-size: 2rem; margin-bottom: 0.5rem; }
        .receipt-body { padding: 2rem; }
        .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 2rem; }
        .info-card { background: #f8fafc; padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid #667eea; }
        .info-card h3 { font-size: 0.875rem; text-transform: uppercase; color: #667eea; margin-bottom: 1rem; font-weight: 600; }
        .info-row { display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 0.9375rem; }
        .products-table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        .products-table thead { background: #f1f5f9; }
        .products-table th, .products-table td { padding: 1rem; text-align: left; }
        .products-table th { font-weight: 600; font-size: 0.875rem; color: #475569; text-transform: uppercase; }
        .products-table tbody tr { border-bottom: 1px solid #e2e8f0; }
        .product-image { width: 60px; height: 60px; border-radius: 0.5rem; object-fit: cover; border: 2px solid #e2e8f0; }
        .totals-section { background: #f8fafc; padding: 1.5rem; border-radius: 0.5rem; margin-left: auto; max-width: 400px; }
        .total-row { display: flex; justify-content: space-between; padding: 0.75rem 0; }
        .total-row.grand-total { border-top: 2px solid #667eea; margin-top: 0.5rem; padding-top: 1rem; font-size: 1.5rem; font-weight: 700; }
        .total-row.grand-total .total-value { color: #667eea; }
        .footer { background: #f8fafc; padding: 2rem; text-align: center; border-top: 1px solid #e2e8f0; }
        .btn { padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; margin: 0 0.5rem; }
        .btn-print { background: #667eea; color: white; }
        .btn-close { background: #e2e8f0; color: #475569; }
        @media print { body { background: white; padding: 0; } .footer .btn { display: none; } }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h1><i class="fas fa-receipt"></i> ORDER RECEIPT</h1>
            <p>Order #{{ $order->order_id }}</p>
            <p style="opacity: 0.9; margin-top: 0.5rem;">{{ \Carbon\Carbon::parse($order->created_at)->format('F d, Y h:i A') }}</p>
        </div>

        <div class="receipt-body">
            <div class="info-grid">
                <div class="info-card">
                    <h3><i class="fas fa-user"></i> Customer Information</h3>
                    <div class="info-row">
                        <span style="color: #64748b;">Name:</span>
                        <strong>{{ $order->user->name }}</strong>
                    </div>
                    <div class="info-row">
                        <span style="color: #64748b;">Email:</span>
                        <strong>{{ $order->user->email }}</strong>
                    </div>
                    <div class="info-row">
                        <span style="color: #64748b;">Phone:</span>
                        <strong>{{ $order->user->phone ?? 'N/A' }}</strong>
                    </div>
                </div>

                <div class="info-card">
                    <h3><i class="fas fa-info-circle"></i> Order Details</h3>
                    <div class="info-row">
                        <span style="color: #64748b;">Order ID:</span>
                        <strong>#{{ $order->order_id }}</strong>
                    </div>
                    <div class="info-row">
                        <span style="color: #64748b;">Status:</span>
                        <strong style="color: 
                            {{ $order->status == 'completed' ? '#10b981' : ($order->status == 'cancelled' ? '#ef4444' : '#f59e0b') }};">
                            {{ ucfirst($order->status) }}
                        </strong>
                    </div>
                    <div class="info-row">
                        <span style="color: #64748b;">Payment:</span>
                        <strong>{{ $order->payment->payment_method ?? 'N/A' }}</strong>
                    </div>
                </div>
            </div>

            <h3 style="margin-bottom: 1rem;"><i class="fas fa-shopping-cart"></i> Order Items</h3>
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style="text-align: center;">Quantity</th>
                        <th style="text-align: right;">Price</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                @php
                                    $imagePath = '';
                                    if ($item->product->image) {
                                        if (file_exists(public_path('storage/' . $item->product->image))) {
                                            $imagePath = asset('storage/' . $item->product->image);
                                        } elseif (file_exists(public_path($item->product->image))) {
                                            $imagePath = asset($item->product->image);
                                        }
                                    }
                                    if (empty($imagePath)) {
                                        $imagePath = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="60" height="60"%3E%3Crect fill="%23f1f5f9" width="60" height="60"/%3E%3Ctext x="50%25" y="50%25" text-anchor="middle" dy=".3em" fill="%2394a3b8" font-size="12"%3ENo Image%3C/text%3E%3C/svg%3E';
                                    }
                                @endphp
                                <img src="{{ $imagePath }}" class="product-image">
                                <div>
                                    <strong>{{ $item->product->product_name }}</strong>
                                    <div style="font-size: 0.875rem; color: #64748b;">{{ $item->product->category->category_name ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="text-align: center;"><span style="background: #e0e7ff; padding: 0.375rem 0.875rem; border-radius: 0.375rem; font-weight: 600;">{{ $item->quantity }}</span></td>
                        <td style="text-align: right;">₱{{ number_format($item->price, 2) }}</td>
                        <td style="text-align: right;"><strong style="color: #667eea;">₱{{ number_format($item->quantity * $item->price, 2) }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="totals-section">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <strong>₱{{ number_format($order->items->sum(function($item) { return $item->quantity * $item->price; }), 2) }}</strong>
                </div>
                <div class="total-row">
                    <span>Shipping:</span>
                    <strong>₱{{ number_format($order->shipping_fee ?? 0, 2) }}</strong>
                </div>
                <div class="total-row grand-total">
                    <span>Total Amount:</span>
                    <span class="total-value">₱{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p style="color: #64748b; margin-bottom: 1rem;">Thank you for your purchase!</p>
            <button class="btn btn-print" onclick="window.print()"><i class="fas fa-print"></i> Print Receipt</button>
            <button class="btn btn-close" onclick="window.close()"><i class="fas fa-times"></i> Close</button>
        </div>
    </div>
</body>
</html>
