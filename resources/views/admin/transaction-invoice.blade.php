<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Invoice - {{ $transaction->reference_num }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            padding: 2rem;
            color: #1e293b;
        }

        .invoice-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .invoice-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .company-info h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .company-info p {
            opacity: 0.9;
            font-size: 0.9375rem;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .invoice-title .invoice-number {
            font-size: 1.125rem;
            opacity: 0.9;
        }

        .header-details {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .detail-label {
            font-size: 0.75rem;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .detail-value {
            font-size: 1rem;
            font-weight: 600;
        }

        .invoice-body {
            padding: 2rem;
        }

        .info-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .info-card {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 0.5rem;
            border-left: 4px solid #667eea;
        }

        .info-card h3 {
            font-size: 0.875rem;
            text-transform: uppercase;
            color: #667eea;
            margin-bottom: 1rem;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            font-size: 0.9375rem;
        }

        .info-label {
            color: #64748b;
            font-weight: 500;
        }

        .info-value {
            color: #1e293b;
            font-weight: 600;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-received {
            background: #d1fae5;
            color: #065f46;
        }

        .status-pending {
            background: #fed7aa;
            color: #92400e;
        }

        .products-section h3 {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        .products-table thead {
            background: #f1f5f9;
        }

        .products-table th {
            text-align: left;
            padding: 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #e2e8f0;
        }

        .products-table th:last-child,
        .products-table td:last-child {
            text-align: right;
        }

        .products-table tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: background 0.2s;
        }

        .products-table tbody tr:hover {
            background: #f8fafc;
        }

        .products-table td {
            padding: 1rem;
            vertical-align: middle;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .product-image {
            width: 60px;
            height: 60px;
            border-radius: 0.5rem;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            background: #f1f5f9;
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .product-category {
            font-size: 0.875rem;
            color: #64748b;
        }

        .quantity-badge {
            background: #e0e7ff;
            color: #3730a3;
            padding: 0.375rem 0.875rem;
            border-radius: 0.375rem;
            font-weight: 600;
            display: inline-block;
        }

        .totals-section {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-left: auto;
            max-width: 400px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            font-size: 1rem;
        }

        .total-row.subtotal {
            border-bottom: 1px solid #cbd5e1;
        }

        .total-row.grand-total {
            border-top: 2px solid #667eea;
            margin-top: 0.5rem;
            padding-top: 1rem;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .total-row.grand-total .total-value {
            color: #667eea;
        }

        .invoice-footer {
            background: #f8fafc;
            padding: 2rem;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .footer-note {
            color: #64748b;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .footer-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-print {
            background: #667eea;
            color: white;
        }

        .btn-print:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-close {
            background: #e2e8f0;
            color: #475569;
        }

        .btn-close:hover {
            background: #cbd5e1;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .footer-actions {
                display: none;
            }

            .invoice-container {
                box-shadow: none;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .header-top {
                flex-direction: column;
                gap: 1.5rem;
            }

            .invoice-title {
                text-align: left;
            }

            .header-details {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .info-section {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .products-table {
                font-size: 0.875rem;
            }

            .product-image {
                width: 50px;
                height: 50px;
            }

            .totals-section {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="header-top">
                <div class="company-info">
                    <h1><i class="fas fa-store"></i>KS PLY TIRE TRADING</h1>
                    <p>Maa, Davao City</p>
                    <p>Phone: (123) 456-7890 | Email: ksply@company.com</p>
                </div>
                <div class="invoice-title">
                    <h2>INVOICE</h2>
                    <p class="invoice-number">{{ $transaction->invoice->invoice_number ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="header-details">
                <div class="detail-item">
                    <span class="detail-label">Invoice Number</span>
                    <span class="detail-value">{{ $transaction->invoice->invoice_number ?? 'N/A' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Invoice Date</span>
                    <span class="detail-value">{{ $transaction->invoice ? \Carbon\Carbon::parse($transaction->invoice->invoice_date)->format('M d, Y') : \Carbon\Carbon::parse($transaction->order_date)->format('M d, Y') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Due Date</span>
                    <span class="detail-value">{{ $transaction->invoice && $transaction->invoice->due_date ? \Carbon\Carbon::parse($transaction->invoice->due_date)->format('M d, Y') : '-' }}</span>
                </div>
            </div>
            <div class="header-details">
                <div class="detail-item">
                    <span class="detail-label">Reference #</span>
                    <span class="detail-value">{{ $transaction->reference_num }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Order Date</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($transaction->order_date)->format('M d, Y') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Status</span>
                    <span class="detail-value">
                        @if($transaction->delivery_received)
                            <span class="status-badge status-received">
                                <i class="fas fa-check-circle"></i> Received
                            </span>
                        @else
                            <span class="status-badge status-pending">
                                <i class="fas fa-clock"></i> Pending
                            </span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="invoice-body">
            <!-- Supplier & Transaction Info -->
            <div class="info-section">
                <div class="info-card">
                    <h3><i class="fas fa-truck"></i> Supplier Information</h3>
                    <div class="info-row">
                        <span class="info-label">Supplier Name:</span>
                        <span class="info-value">{{ $transaction->supplier->supplier_name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Company:</span>
                        <span class="info-value">{{ $transaction->supplier->company_name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Contact Person:</span>
                        <span class="info-value">{{ $transaction->supplier->contact_person }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Phone:</span>
                        <span class="info-value">{{ $transaction->supplier->contact_number }}</span>
                    </div>
                </div>

                <div class="info-card">
                    <h3><i class="fas fa-info-circle"></i> Delivery Information</h3>
                    <div class="info-row">
                        <span class="info-label">Delivery Status:</span>
                        <span class="info-value">
                            @if($transaction->delivery_received)
                                <span style="color: #059669; font-weight: 700;">✓ Received</span>
                            @else
                                <span style="color: #f59e0b; font-weight: 700;">⏳ Pending</span>
                            @endif
                        </span>
                    </div>
                    @if($transaction->delivery_received && $transaction->delivery_date)
                        <div class="info-row">
                            <span class="info-label">Delivery Date:</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($transaction->delivery_date)->format('M d, Y') }}</span>
                        </div>
                    @endif
                    @if(!$transaction->delivery_received && $transaction->estimated_date)
                        <div class="info-row">
                            <span class="info-label">Estimated Date:</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($transaction->estimated_date)->format('M d, Y') }}</span>
                        </div>
                    @endif
                    <div class="info-row">
                        <span class="info-label">Delivery Fee:</span>
                        <span class="info-value">₱{{ number_format($transaction->delivery_fee, 2) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tax (VAT 12%):</span>
                        <span class="info-value">₱{{ number_format($transaction->tax, 2) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Payment Terms:</span>
                        <span class="info-value">{{ $transaction->supplier->payment_terms ?? 'Net 30' }}</span>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="products-section">
                <h3>
                    <i class="fas fa-boxes"></i>
                    Products Ordered ({{ $transaction->suppOrderProds->count() }} items)
                </h3>

                <table class="products-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Product</th>
                            <th style="width: 150px;">Category</th>
                            <th style="width: 120px; text-align: center;">Quantity</th>
                            <th style="width: 150px; text-align: right;">Unit Price</th>
                            <th style="width: 150px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->suppOrderProds as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="product-info">
                                    @php
                                        $imagePath = '';
                                        if ($item->product->image) {
                                            // Check if image exists
                                            if (file_exists(public_path('storage/' . $item->product->image))) {
                                                $imagePath = asset('storage/' . $item->product->image);
                                            } elseif (file_exists(public_path($item->product->image))) {
                                                $imagePath = asset($item->product->image);
                                            }
                                        }
                                        
                                        // Fallback image
                                        if (empty($imagePath)) {
                                            $imagePath = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60"%3E%3Crect fill="%23f1f5f9" width="60" height="60"/%3E%3Ctext x="50%25" y="50%25" dominant-baseline="middle" text-anchor="middle" font-family="sans-serif" font-size="14" fill="%2394a3b8"%3ENo Image%3C/text%3E%3C/svg%3E';
                                        }
                                    @endphp
                                    <img src="{{ $imagePath }}" alt="{{ $item->product->product_name }}" class="product-image" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22 viewBox=%220 0 60 60%22%3E%3Crect fill=%22%23f1f5f9%22 width=%2260%22 height=%2260%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2214%22 fill=%22%2394a3b8%22%3ENo Image%3C/text%3E%3C/svg%3E'">
                                    <div class="product-details">
                                        <div class="product-name">{{ $item->product->product_name }}</div>
                                        <div class="product-category">
                                            <i class="fas fa-tag"></i> {{ $item->product->category->category_name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="background: #f1f5f9; padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-size: 0.875rem; color: #475569;">
                                    {{ $item->product->category->category_name ?? 'N/A' }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <span class="quantity-badge">{{ $item->quantity }}</span>
                            </td>
                            <td style="text-align: right;">
                                ₱{{ number_format($item->quantity > 0 ? $item->total / $item->quantity : 0, 2) }}
                            </td>
                            <td style="text-align: right;">
                                <strong style="color: #667eea; font-size: 1.0625rem;">₱{{ number_format($item->total, 2) }}</strong>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Totals -->
                <div class="totals-section">
                    <div class="total-row subtotal">
                        <span><i class="fas fa-boxes"></i> Subtotal:</span>
                        <span class="total-value">₱{{ number_format($transaction->sub_total, 2) }}</span>
                    </div>
                    <div class="total-row">
                        <span><i class="fas fa-truck"></i> Delivery Fee:</span>
                        <span class="total-value">₱{{ number_format($transaction->delivery_fee, 2) }}</span>
                    </div>
                    <div class="total-row">
                        <span><i class="fas fa-receipt"></i> Tax (VAT):</span>
                        <span class="total-value">₱{{ number_format($transaction->tax, 2) }}</span>
                    </div>
                    <div class="total-row grand-total">
                        <span><i class="fas fa-calculator"></i> Grand Total:</span>
                        <span class="total-value">₱{{ number_format($transaction->overall_total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <p class="footer-note">
                <i class="fas fa-info-circle"></i>
                This is a computer-generated document. Generated on {{ \Carbon\Carbon::now()->format('M d, Y h:i A') }}
            </p>
            <p class="footer-note">
                Thank you for your business!
            </p>
            <div class="footer-actions">
                <button class="btn btn-print" onclick="window.print()">
                    <i class="fas fa-print"></i>
                    Print Invoice
                </button>
                <button class="btn btn-close" onclick="window.close()">
                    <i class="fas fa-times"></i>
                    Close
                </button>
            </div>
        </div>
    </div>
</body>
</html>
