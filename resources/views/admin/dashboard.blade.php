@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <div class="filter-wrapper">
            <select class="btn-filter" style="padding-right: 2rem;">
                <option>Today</option>
                <option>This Week</option>
                <option>This Month</option>
                <option>This Year</option>
            </select>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #3498db;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>1,254</h3>
                <p>Total Customers</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #2ecc71;">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3>542</h3>
                <p>Total Orders</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #27ae60;">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h3>₱342,458</h3>
                <p>Total Revenue</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #e67e22;">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-info">
                <h3>1,847</h3>
                <p>Products in Stock</p>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div class="content-card">
            <div class="card-header">
                <h3>Recent Orders</h3>
                <a href="#" style="color: #3498db; text-decoration: none; font-size: 0.875rem;">View All</a>
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
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="supplier-id">ORD001</td>
                                <td class="supplier-name">Maria Clara Santos</td>
                                <td class="transaction-amount">₱2,450.00</td>
                                <td><span class="payment-badge status-completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td class="supplier-id">ORD002</td>
                                <td class="supplier-name">Juan Paolo Reyes</td>
                                <td class="transaction-amount">₱1,800.00</td>
                                <td><span class="payment-badge status-completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td class="supplier-id">ORD003</td>
                                <td class="supplier-name">Anna Marie Cruz</td>
                                <td class="transaction-amount">₱4,200.00</td>
                                <td><span class="payment-badge status-completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td class="supplier-id">ORD004</td>
                                <td class="supplier-name">Carlos Miguel Torres</td>
                                <td class="transaction-amount">₱950.00</td>
                                <td><span class="payment-badge status-pending">Pending</span></td>
                            </tr>
                            <tr>
                                <td class="supplier-id">ORD005</td>
                                <td class="supplier-name">Isabella Garcia</td>
                                <td class="transaction-amount">₱3,650.00</td>
                                <td><span class="payment-badge status-processing">Processing</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header">
                <h3>Sales Overview</h3>
                <div class="filter-wrapper">
                    <select class="btn-filter" style="padding-right: 2rem; font-size: 0.875rem;">
                        <option>Last 7 Days</option>
                        <option>Last 30 Days</option>
                        <option>Last 3 Months</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-placeholder">
                    <i class="fas fa-chart-area" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                    <p style="color: #64748b;">Sales chart will be displayed here</p>
                </div>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <div class="content-card">
            <div class="card-header">
                <h3>Low Stock Alert</h3>
                <a href="#" style="color: #e74c3c; text-decoration: none; font-size: 0.875rem;">View All</a>
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
                            <tr>
                                <td class="supplier-name">Cetaphil Gentle Cleanser</td>
                                <td>Skin Care</td>
                                <td><span class="stock-badge stock-low">8</span></td>
                                <td><span class="payment-badge status-pending">Low Stock</span></td>
                            </tr>
                            <tr>
                                <td class="supplier-name">Moroccan Oil Treatment</td>
                                <td>Hair Care</td>
                                <td><span class="stock-badge stock-medium">12</span></td>
                                <td><span class="payment-badge status-pending">Low Stock</span></td>
                            </tr>
                            <tr>
                                <td class="supplier-name">Kerastase Hair Mask</td>
                                <td>Hair Care</td>
                                <td><span class="stock-badge stock-medium">15</span></td>
                                <td><span class="payment-badge status-pending">Low Stock</span></td>
                            </tr>
                            <tr>
                                <td class="supplier-name">Maybelline Mascara</td>
                                <td>Makeup</td>
                                <td><span class="stock-badge stock-out">0</span></td>
                                <td><span class="payment-badge status-inactive">Out of Stock</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header">
                <h3>Top Selling Products</h3>
                <a href="#" style="color: #3498db; text-decoration: none; font-size: 0.875rem;">View All</a>
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
                            <tr>
                                <td style="font-weight: 600; color: #f39c12;">1</td>
                                <td class="supplier-name">L'Oréal Professional Shampoo</td>
                                <td>156</td>
                                <td class="transaction-amount">₱101,400</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #95a5a6;">2</td>
                                <td class="supplier-name">Kerastase Hair Mask</td>
                                <td>142</td>
                                <td class="transaction-amount">₱255,600</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #cd7f32;">3</td>
                                <td class="supplier-name">OPI Nail Polish</td>
                                <td>128</td>
                                <td class="transaction-amount">₱57,600</td>
                            </tr>
                            <tr>
                                <td style="font-weight: 600; color: #7f8c8d;">4</td>
                                <td class="supplier-name">Moroccan Oil Treatment</td>
                                <td>98</td>
                                <td class="transaction-amount">₱215,600</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
