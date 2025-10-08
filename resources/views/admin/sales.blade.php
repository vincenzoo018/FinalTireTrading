@extends('layouts.admin.app')

@section('title', 'Sales Analytics')

@section('styles')
<style>
    .filter-controls {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .filter-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filter-label {
        font-weight: 600;
        color: #1e293b;
    }
    
    .date-input {
        padding: 0.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        background-color: #fff;
    }
    
    .filter-btn {
        padding: 0.5rem 1rem;
        background-color: #3b82f6;
        color: white;
        border: none;
        border-radius: 0.375rem;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.2s;
    }
    
    .filter-btn:hover {
        background-color: #2563eb;
    }
    
    .chart-container {
        width: 100%;
        height: 350px;
        position: relative;
    }
    
    .top-products-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .top-product-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .top-product-item:last-child {
        border-bottom: none;
    }
    
    .product-name {
        font-weight: 500;
        color: #1e293b;
    }
    
    .product-quantity {
        font-weight: 600;
        color: #3b82f6;
    }
</style>
@endsection

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Sales Analytics</h1>
        <div class="filter-wrapper">
            <form id="filterForm" action="{{ route('admin.sales') }}" method="GET">
                <div class="filter-controls">
                    <div class="filter-group">
                        <span class="filter-label">Filter Type:</span>
                        <select name="filter_type" id="filterType" class="btn-filter" style="padding-right: 2rem;"> 
                            <option value="day" {{ (isset($filterType) && $filterType == 'day') ? 'selected' : '' }}>Day</option>
                            <option value="month" {{ (isset($filterType) && $filterType == 'month') ? 'selected' : '' }}>Month</option>
                            <option value="year" {{ (isset($filterType) && $filterType == 'year') ? 'selected' : '' }}>Year</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <span class="filter-label">Date:</span>
                        <input type="date" name="filter_date" id="filterDate" class="date-input" value="{{ $filterDate ?? now()->format('Y-m-d') }}">
                    </div>
                    <button type="submit" class="filter-btn">Apply Filter</button>
                </div>
            </form>
            <form method="POST" action="{{ route('admin.sales.generate') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-success" onclick="return confirm('Generate sales records for all completed orders and bookings?')" style="margin-left: 10px;">
                    <i class="fas fa-sync-alt me-1"></i>Generate Sales
                </button>
            </form>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #27ae60;">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h3>₱{{ number_format($totalRevenue ?? 0, 2) }}</h3>
                <p>Total Revenue</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #3498db;">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $totalOrders ?? 0 }}</h3>
                <p>Total Orders</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #e74c3c;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $cancelledOrders ?? 0 }}</h3>
                <p>Cancelled Orders</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #f39c12;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $totalBookings ?? 0 }}</h3>
                <p>Total Bookings</p>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div class="content-card">
            <div class="card-header">
                <h3>Sales Overview</h3>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header">
                <h3>Top Products</h3>
            </div>
            <div class="card-body">
                @if(isset($topProducts) && count($topProducts) > 0)
                    <ul class="top-products-list">
                        @foreach($topProducts as $product)
                            <li class="top-product-item">
                                <span class="product-name">{{ $product->product_name }}</span>
                                <span class="product-quantity">{{ $product->total_quantity }} sold</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="list-placeholder">
                        <i class="fas fa-trophy" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                        <p>No product data available for the selected period</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="table-controls" style="border-bottom: 1px solid #e2e8f0;">
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #1e293b; margin: 0;">Recent Sales</h3>
            <div class="search-wrapper" style="max-width: 300px;">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search orders...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="supplier-table">
                <thead>
                    <tr>
                        <th class="sortable">
                            ID
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Type
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Customer
                            <i class="fas fa-sort"></i>
                        </th>
                        <th>Date</th>
                        <th>Details</th>
                        <th>Total Amount</th>
                        <th>Payment Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($sales ?? []) as $sale)
                        <tr>
                            <td class="supplier-id">
                                @if($sale->order_id)
                                    #ORD-{{ $sale->order_id }}
                                @elseif($sale->booking_id)
                                    #BKG-{{ $sale->booking_id }}
                                @else
                                    #{{ $sale->sale_id }}
                                @endif
                            </td>
                            <td>
                                @if($sale->order_id)
                                    <span class="badge bg-primary">
                                        <i class="fas fa-shopping-cart me-1"></i>Order
                                    </span>
                                @elseif($sale->booking_id)
                                    <span class="badge bg-success">
                                        <i class="fas fa-calendar-check me-1"></i>Booking
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Other</span>
                                @endif
                            </td>
                            <td class="supplier-name">
                                @if($sale->order_id)
                                    {{ optional($sale->order->user)->fname }} {{ optional($sale->order->user)->lname }}
                                @elseif($sale->booking_id && $sale->booking)
                                    {{ optional($sale->booking->user)->fname }} {{ optional($sale->booking->user)->lname }}
                                @else
                                    {{ optional($sale->user)->fname }} {{ optional($sale->user)->lname }}
                                @endif
                            </td>
                            <td>{{ optional($sale->created_at)->format('M d, Y') }}</td>
                            <td>
                                @if($sale->order_id && $sale->order)
                                    {{ $sale->order->items->sum('quantity') ?? 0 }} items
                                @elseif($sale->booking_id && $sale->booking && $sale->booking->service)
                                    {{ $sale->booking->service->service_name }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="transaction-amount">₱{{ number_format($sale->total_amount, 2) }}</td>
                            <td>{{ $sale->payment_method ?? '-' }}</td>
                            <td class="actions-cell">
                                @if($sale->order_id)
                                    <a href="{{ route('admin.orders') }}" class="btn-icon btn-view" title="View Order">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @elseif($sale->booking_id)
                                    <a href="{{ route('admin.bookings') }}" class="btn-icon btn-view" title="View Booking">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:1rem; color:#64748b;">No sales yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="showing-info">
                @if(isset($sales) && $sales->total() > 0)
                    Showing <strong>{{ $sales->firstItem() }}-{{ $sales->lastItem() }}</strong> of <strong>{{ $sales->total() }}</strong>
                @else
                    Showing <strong>0-0</strong> of <strong>0</strong>
                @endif
            </div>

            <div class="pagination">
                @if(isset($sales) && $sales->hasPages())
                    {{ $sales->links() }}
                @endif
            </div>
        </div>
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="showing-info">
                Showing <strong>1-10</strong> of <strong>542</strong>
            </div>

            <div class="pagination">
                @if(isset($sales) && $sales->hasPages())
                    {{ $sales->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the chart data from PHP
    const chartData = @json($chartData ?? ['labels' => [], 'orderData' => [], 'bookingData' => []]);
    
    // Create the chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [
                {
                    label: 'Orders',
                    data: chartData.orderData,
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                    pointRadius: 4
                },
                {
                    label: 'Bookings',
                    data: chartData.bookingData,
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                    pointRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += '₱' + context.parsed.y.toFixed(2);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₱' + value;
                        }
                    }
                }
            }
        }
    });
    
    // Update filter date input based on filter type
    const filterTypeSelect = document.getElementById('filterType');
    const filterDateInput = document.getElementById('filterDate');
    
    filterTypeSelect.addEventListener('change', function() {
        const filterType = this.value;
        
        if (filterType === 'month') {
            filterDateInput.type = 'month';
        } else if (filterType === 'year') {
            filterDateInput.type = 'number';
            filterDateInput.min = '2000';
            filterDateInput.max = new Date().getFullYear().toString();
            filterDateInput.value = new Date().getFullYear();
        } else {
            filterDateInput.type = 'date';
        }
    });
    
    // Initialize the date input type based on current filter
    if (filterTypeSelect.value === 'month') {
        filterDateInput.type = 'month';
    } else if (filterTypeSelect.value === 'year') {
        filterDateInput.type = 'number';
        filterDateInput.min = '2000';
        filterDateInput.max = new Date().getFullYear().toString();
    }
});
</script>
@endsection
