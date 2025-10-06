@extends('layouts.admin.app')

@section('title', 'Sales Analytics')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Sales Analytics</h1>
        <div class="filter-wrapper">
            <select class="btn-filter" style="padding-right: 2rem;">
                <option>This Month</option>
                <option>Last Month</option>
                <option>Last 3 Months</option>
                <option>This Year</option>
            </select>
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
                <i class="fas fa-percentage"></i>
            </div>
            <div class="stat-info">
                <h3>15.2%</h3>
                <p>Growth Rate</p>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div class="content-card">
            <div class="card-header">
                <h3>Sales Overview</h3>
            </div>
            <div class="card-body">
                <div class="chart-placeholder">
                    <i class="fas fa-chart-area" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                    <p>Sales chart will be displayed here</p>
                </div>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header">
                <h3>Top Products</h3>
            </div>
            <div class="card-body">
                <div class="list-placeholder">
                    <i class="fas fa-trophy" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                    <p>Top products list will be displayed here</p>
                </div>
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
                            Order ID
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Customer
                            <i class="fas fa-sort"></i>
                        </th>
                        <th>Order Date</th>
                        <th>Products</th>
                        <th>Total Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($sales ?? []) as $sale)
                        <tr>
                            <td class="supplier-id">{{ $sale->order_id }}</td>
                            <td class="supplier-name">{{ optional($sale->order->user)->fname }} {{ optional($sale->order->user)->lname }}</td>
                            <td>{{ optional($sale->created_at)->format('M d, Y') }}</td>
                            <td>{{ $sale->order ? $sale->order->items->sum('quantity') : 0 }} items</td>
                            <td class="transaction-amount">₱{{ number_format($sale->total_amount, 2) }}</td>
                            <td>{{ $sale->payment_method ?? '-' }}</td>
                            <td><span class="payment-badge status-completed">Completed</span></td>
                            <td class="actions-cell">
                                <a href="{{ route('admin.orders') }}" class="btn-icon btn-view" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
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
