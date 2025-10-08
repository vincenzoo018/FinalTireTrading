@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Dashboard Overview</h1>
        <div class="filter-wrapper">
            <form method="GET" action="{{ route('admin.dashboard') }}" id="filterForm">
                <select name="filter" class="btn-filter" style="padding-right: 2rem;" onchange="this.form.submit()">
                    <option value="today" {{ $filterPeriod == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="week" {{ $filterPeriod == 'week' ? 'selected' : '' }}>This Week</option>
                    <option value="month" {{ $filterPeriod == 'month' ? 'selected' : '' }}>This Month</option>
                    <option value="year" {{ $filterPeriod == 'year' ? 'selected' : '' }}>This Year</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Main Stats (Top 4) -->
    <div class="stats-grid">
        @if(Auth::user()->role_id == 1)
        <!-- Total Revenue - ONLY for Admin (role_id = 1) -->
        <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="stat-icon" style="background: rgba(255,255,255,0.2);">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h3 style="color: white;">₱{{ number_format($stats['total_revenue'], 2) }}</h3>
                <p style="color: rgba(255,255,255,0.9);">Total Revenue</p>
                <small style="color: rgba(255,255,255,0.7); font-size: 0.75rem;">
                    Orders: ₱{{ number_format($stats['order_revenue'], 2) }} | 
                    Bookings: ₱{{ number_format($stats['booking_revenue'], 2) }}
                </small>
            </div>
        </div>
        @endif

        <!-- Total Orders with Pending Badge -->
        <div class="stat-card">
            <div class="stat-icon" style="background: #3498db;">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['total_orders'] }}</h3>
                <p>Total Orders</p>
                @if($stats['pending_orders'] > 0)
                    <span class="badge bg-warning text-dark" style="position: absolute; top: 10px; right: 10px; font-size: 0.75rem;">
                        {{ $stats['pending_orders'] }} Pending
                    </span>
                @endif
            </div>
        </div>

        <!-- Total Bookings with Pending Badge -->
        <div class="stat-card">
            <div class="stat-icon" style="background: #2ecc71;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['total_bookings'] }}</h3>
                <p>Total Bookings</p>
                @if($stats['pending_bookings'] > 0)
                    <span class="badge bg-warning text-dark" style="position: absolute; top: 10px; right: 10px; font-size: 0.75rem;">
                        {{ $stats['pending_bookings'] }} Pending
                    </span>
                @endif
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="stat-card" style="{{ $stats['low_stock_count'] > 0 ? 'border: 2px solid #e74c3c;' : '' }}">
            <div class="stat-icon" style="background: {{ $stats['low_stock_count'] > 0 ? '#e74c3c' : '#f39c12' }};">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h3 style="{{ $stats['low_stock_count'] > 0 ? 'color: #e74c3c;' : '' }}">{{ $stats['low_stock_count'] }}</h3>
                <p>Low Stock Alert</p>
                <small class="text-muted" style="font-size: 0.75rem;">{{ $stats['out_of_stock_count'] }} Out of Stock</small>
            </div>
        </div>
    </div>

    <!-- Sales Chart Section -->
    <div class="content-card mb-4">
        <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem;">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h3 style="margin: 0; color: white; font-size: 1.3rem; font-weight: 700;">
                        <i class="fas fa-chart-line me-2"></i>Sales Analytics
                    </h3>
                    <small style="opacity: 0.9;">Revenue from Orders & Bookings</small>
                </div>
                <div class="chart-filter-group">
                    <button class="chart-filter-btn active" data-period="day">
                        <i class="fas fa-calendar-day me-1"></i>Day
                    </button>
                    <button class="chart-filter-btn" data-period="week">
                        <i class="fas fa-calendar-week me-1"></i>Week
                    </button>
                    <button class="chart-filter-btn" data-period="month">
                        <i class="fas fa-calendar-alt me-1"></i>Month
                    </button>
                    <button class="chart-filter-btn" data-period="year">
                        <i class="fas fa-calendar me-1"></i>Year
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body" style="padding: 2rem;">
            <div class="chart-container" style="position: relative; height: 400px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Status Overview Box Section -->
    <div class="content-card mb-4">
        <div class="card-header" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 1.25rem;">
            <h3 style="margin: 0; color: #2c3e50; font-size: 1.1rem; font-weight: 700;">
                <i class="fas fa-chart-bar me-2"></i>Status Overview
            </h3>
            <small style="color: #6c757d;">Real-time status breakdown across all operations</small>
        </div>
        <div class="card-body" style="padding: 1.5rem;">
            <div class="row">
                <!-- Orders Mini Card -->
                <div class="col-xl-4 col-md-6 mb-3">
                    <div class="mini-status-card">
                        <div class="mini-card-header">
                            <div class="mini-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <span class="mini-title">Orders</span>
                        </div>
                        <div class="mini-stats">
                            <div class="mini-stat">
                                <i class="fas fa-clock text-warning"></i>
                                <span>{{ $stats['pending_orders'] }}</span>
                                <small>Pending</small>
                            </div>
                            <div class="mini-stat">
                                <i class="fas fa-check text-success"></i>
                                <span>{{ $stats['completed_orders'] }}</span>
                                <small>Done</small>
                            </div>
                            <div class="mini-stat">
                                <i class="fas fa-times text-danger"></i>
                                <span>{{ $stats['cancelled_orders'] }}</span>
                                <small>Cancel</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bookings Mini Card -->
                <div class="col-xl-4 col-md-6 mb-3">
                    <div class="mini-status-card">
                        <div class="mini-card-header">
                            <div class="mini-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <span class="mini-title">Bookings</span>
                        </div>
                        <div class="mini-stats">
                            <div class="mini-stat">
                                <i class="fas fa-hourglass-half text-warning"></i>
                                <span>{{ $stats['pending_bookings'] }}</span>
                                <small>Pending</small>
                            </div>
                            <div class="mini-stat">
                                <i class="fas fa-clipboard-check text-info"></i>
                                <span>{{ $stats['confirmed_bookings'] }}</span>
                                <small>Confirm</small>
                            </div>
                            <div class="mini-stat">
                                <i class="fas fa-check-double text-success"></i>
                                <span>{{ $stats['completed_bookings'] }}</span>
                                <small>Done</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inventory Mini Card -->
                <div class="col-xl-4 col-md-6 mb-3">
                    <div class="mini-status-card">
                        <div class="mini-card-header">
                            <div class="mini-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                <i class="fas fa-boxes"></i>
                            </div>
                            <span class="mini-title">Inventory</span>
                        </div>
                        <div class="mini-stats">
                            <div class="mini-stat">
                                <i class="fas fa-check-circle text-success"></i>
                                <span>{{ $stats['in_stock_count'] }}</span>
                                <small>In Stock</small>
                            </div>
                            <div class="mini-stat">
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                <span>{{ $stats['low_stock_count'] }}</span>
                                <small>Low</small>
                            </div>
                            <div class="mini-stat">
                                <i class="fas fa-times-circle text-danger"></i>
                                <span>{{ $stats['out_of_stock_count'] }}</span>
                                <small>Out</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Section -->\n    <div class="content-grid">
        <!-- Recent Orders Table -->
        <div class="content-card">
            <div class="card-header">
                <h3><i class="fas fa-shopping-cart me-2"></i>Recent Orders</h3>
                <a href="{{ route('admin.orders') }}" style="color: #3498db; text-decoration: none; font-size: 0.875rem;">
                    <i class="fas fa-arrow-right me-1"></i>View All
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="supplier-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders->take(5) as $order)
                            <tr>
                                <td class="supplier-id">#{{ $order->order_id }}</td>
                                <td class="supplier-name">{{ $order->user->fname ?? 'N/A' }} {{ $order->user->lname ?? '' }}</td>
                                <td class="transaction-amount">₱{{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="payment-badge status-{{ strtolower($order->status) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No recent orders</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Bookings Table -->
        <div class="content-card">
            <div class="card-header">
                <h3><i class="fas fa-calendar-check me-2"></i>Recent Bookings</h3>
                <a href="{{ route('admin.bookings') }}" style="color: #3498db; text-decoration: none; font-size: 0.875rem;">
                    <i class="fas fa-arrow-right me-1"></i>View All
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="supplier-table">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Customer</th>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings->take(5) as $booking)
                            <tr>
                                <td class="supplier-id">#{{ $booking->booking_id }}</td>
                                <td class="supplier-name">{{ $booking->user->fname ?? 'N/A' }} {{ $booking->user->lname ?? '' }}</td>
                                <td>{{ $booking->service->service_name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</td>
                                <td>
                                    <span class="payment-badge status-{{ strtolower($booking->status) }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No recent bookings</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <!-- Low Stock Alert Table -->
        <div class="content-card">
            <div class="card-header">
                <h3><i class="fas fa-exclamation-triangle me-2 text-warning"></i>Low Stock Alert</h3>
                <a href="{{ route('admin.inventory.index') }}" style="color: #e74c3c; text-decoration: none; font-size: 0.875rem;">
                    <i class="fas fa-arrow-right me-1"></i>View All
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="supplier-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStockProducts->take(5) as $item)
                            <tr>
                                <td class="supplier-name">{{ $item->product->product_name ?? 'N/A' }}</td>
                                <td>{{ $item->product->category->category_name ?? 'N/A' }}</td>
                                <td>
                                    <span class="stock-badge {{ $item->quantity_on_hand == 0 ? 'stock-out' : ($item->quantity_on_hand < 5 ? 'stock-low' : 'stock-medium') }}">
                                        {{ $item->quantity_on_hand }}
                                    </span>
                                </td>
                                <td>
                                    @if($item->quantity_on_hand == 0)
                                        <span class="payment-badge status-inactive">Out of Stock</span>
                                    @else
                                        <span class="payment-badge status-pending">Low Stock</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-success">
                                    <i class="fas fa-check-circle me-2"></i>All products are well stocked!
                                </td>
                            </tr>
                            @endforelse
                            
                            @if($outOfStockProducts->count() > 0 && $lowStockProducts->count() < 5)
                                @foreach($outOfStockProducts->take(5 - $lowStockProducts->count()) as $item)
                                <tr class="table-danger">
                                    <td class="supplier-name">{{ $item->product->product_name ?? 'N/A' }}</td>
                                    <td>{{ $item->product->category->category_name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="stock-badge stock-out">0</span>
                                    </td>
                                    <td>
                                        <span class="payment-badge status-inactive">Out of Stock</span>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top Selling Products Table -->
        <div class="content-card">
            <div class="card-header">
                <h3><i class="fas fa-trophy me-2 text-warning"></i>Top Selling Products</h3>
                <a href="{{ route('admin.sales') }}" style="color: #3498db; text-decoration: none; font-size: 0.875rem;">
                    <i class="fas fa-arrow-right me-1"></i>View All
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="supplier-table">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Product</th>
                                <th>Sales</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $index => $product)
                            <tr>
                                <td style="font-weight: 600; color: {{ $index == 0 ? '#f39c12' : ($index == 1 ? '#95a5a6' : ($index == 2 ? '#cd7f32' : '#7f8c8d')) }};">
                                    @if($index == 0)
                                        <i class="fas fa-trophy"></i>
                                    @elseif($index == 1)
                                        <i class="fas fa-medal"></i>
                                    @elseif($index == 2)
                                        <i class="fas fa-award"></i>
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </td>
                                <td class="supplier-name">{{ $product->product_name }}</td>
                                <td><strong>{{ $product->total_quantity }}</strong> units</td>
                                <td class="transaction-amount">₱{{ number_format($product->total_revenue, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    <i class="fas fa-chart-line me-2"></i>No sales data yet for this period
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stat-card {
    position: relative;
}

.stock-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-weight: 600;
    font-size: 0.875rem;
}

.stock-badge.stock-low {
    background-color: #ffebee;
    color: #c62828;
}

.stock-badge.stock-medium {
    background-color: #fff3e0;
    color: #e65100;
}

.stock-badge.stock-out {
    background-color: #f44336;
    color: white;
}

/* Compact Mini Status Cards */
.mini-status-card {
    background: white;
    border-radius: 16px;
    padding: 1.25rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
    height: 100%;
}

.mini-status-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.mini-card-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #f0f0f0;
}

.mini-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.mini-title {
    font-size: 1rem;
    font-weight: 700;
    color: #2c3e50;
}

.mini-stats {
    display: flex;
    justify-content: space-around;
    gap: 0.5rem;
}

.mini-stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
    flex: 1;
}

.mini-stat i {
    font-size: 1.1rem;
}

.mini-stat span {
    font-size: 1.5rem;
    font-weight: 800;
    color: #2c3e50;
}

.mini-stat small {
    font-size: 0.7rem;
    color: #6c757d;
    font-weight: 600;
    text-transform: uppercase;
}

/* Chart Filter Buttons */
.chart-filter-group {
    display: flex;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem;
    border-radius: 12px;
}

.chart-filter-btn {
    background: transparent;
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.chart-filter-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-2px);
}

.chart-filter-btn.active {
    background: white;
    color: #667eea;
    border-color: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Chart Container */
.chart-container {
    position: relative;
    width: 100%;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.mini-status-card {
    animation: fadeInUp 0.5s ease-out;
    animation-fill-mode: both;
}

.mini-status-card:nth-child(1) {
    animation-delay: 0.1s;
}

.mini-status-card:nth-child(2) {
    animation-delay: 0.2s;
}

.mini-status-card:nth-child(3) {
    animation-delay: 0.3s;
}

/* Responsive */
@media (max-width: 768px) {
    .chart-filter-group {
        width: 100%;
        margin-top: 1rem;
    }
    
    .chart-filter-btn {
        flex: 1;
        font-size: 0.75rem;
        padding: 0.4rem 0.5rem;
    }
}
</style>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let salesChart = null;
    let currentPeriod = 'day';

    // Initialize chart with default data (day)
    initChart('day');

    // Chart filter buttons
    document.querySelectorAll('.chart-filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            document.querySelectorAll('.chart-filter-btn').forEach(b => b.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get period and update chart
            const period = this.getAttribute('data-period');
            currentPeriod = period;
            updateChart(period);
        });
    });

    function initChart(period) {
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        const data = getChartData(period);
        
        salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Orders Revenue',
                        data: data.ordersData,
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: '#667eea',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                    },
                    {
                        label: 'Bookings Revenue',
                        data: data.bookingsData,
                        borderColor: '#f5576c',
                        backgroundColor: 'rgba(245, 87, 108, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: '#f5576c',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 13,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += '₱' + context.parsed.y.toLocaleString('en-PH', {minimumFractionDigits: 2});
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false,
                        },
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            },
                            font: {
                                size: 12
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    }

    function updateChart(period) {
        const data = getChartData(period);
        
        salesChart.data.labels = data.labels;
        salesChart.data.datasets[0].data = data.ordersData;
        salesChart.data.datasets[1].data = data.bookingsData;
        salesChart.update('active');
    }

    function getChartData(period) {
        // This is sample data - you'll need to fetch real data from your backend
        const currentData = {
            day: {
                labels: ['12 AM', '4 AM', '8 AM', '12 PM', '4 PM', '8 PM'],
                ordersData: [0, 0, 0, 0, 0, 0],
                bookingsData: [0, 0, 600, 0, 0, 0]
            },
            week: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                ordersData: [0, 0, 0, 0, 0, 0, 0],
                bookingsData: [0, 0, 600, 0, 0, 0, 0]
            },
            month: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                ordersData: [0, 0, 0, 0],
                bookingsData: [600, 0, 0, 0]
            },
            year: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                ordersData: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                bookingsData: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 600, 0]
            }
        };

        return currentData[period] || currentData.day;
    }
});
</script>
@endsection
