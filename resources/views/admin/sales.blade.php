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
                <h3>₱342,458</h3>
                <p>Total Revenue</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #3498db;">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="stat-info">
                <h3>542</h3>
                <p>Total Orders</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #e74c3c;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-info">
                <h3>23</h3>
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
                    <tr>
                        <td class="supplier-id">ORD001</td>
                        <td class="supplier-name">Maria Clara Santos</td>
                        <td>Oct 02, 2024</td>
                        <td>3 items</td>
                        <td class="transaction-amount">₱2,450.00</td>
                        <td>Cash</td>
                        <td><span class="payment-badge status-completed">Completed</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="supplier-id">ORD002</td>
                        <td class="supplier-name">Juan Paolo Reyes</td>
                        <td>Oct 02, 2024</td>
                        <td>2 items</td>
                        <td class="transaction-amount">₱1,800.00</td>
                        <td>GCash</td>
                        <td><span class="payment-badge status-completed">Completed</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="supplier-id">ORD003</td>
                        <td class="supplier-name">Anna Marie Cruz</td>
                        <td>Oct 01, 2024</td>
                        <td>5 items</td>
                        <td class="transaction-amount">₱4,200.00</td>
                        <td>Credit Card</td>
                        <td><span class="payment-badge status-completed">Completed</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="supplier-id">ORD004</td>
                        <td class="supplier-name">Carlos Miguel Torres</td>
                        <td>Oct 01, 2024</td>
                        <td>1 item</td>
                        <td class="transaction-amount">₱950.00</td>
                        <td>Cash</td>
                        <td><span class="payment-badge status-completed">Completed</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="supplier-id">ORD005</td>
                        <td class="supplier-name">Isabella Garcia</td>
                        <td>Sep 30, 2024</td>
                        <td>4 items</td>
                        <td class="transaction-amount">₱3,650.00</td>
                        <td>GCash</td>
                        <td><span class="payment-badge status-cancelled">Cancelled</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="supplier-id">ORD006</td>
                        <td class="supplier-name">Sofia Angelica Mendoza</td>
                        <td>Sep 30, 2024</td>
                        <td>2 items</td>
                        <td class="transaction-amount">₱1,500.00</td>
                        <td>Cash</td>
                        <td><span class="payment-badge status-completed">Completed</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="supplier-id">ORD007</td>
                        <td class="supplier-name">Miguel Antonio Ramos</td>
                        <td>Sep 29, 2024</td>
                        <td>3 items</td>
                        <td class="transaction-amount">₱2,890.00</td>
                        <td>Credit Card</td>
                        <td><span class="payment-badge status-completed">Completed</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="supplier-id">ORD008</td>
                        <td class="supplier-name">Patricia Nicole Flores</td>
                        <td>Sep 29, 2024</td>
                        <td>6 items</td>
                        <td class="transaction-amount">₱5,120.00</td>
                        <td>GCash</td>
                        <td><span class="payment-badge status-completed">Completed</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="supplier-id">ORD009</td>
                        <td class="supplier-name">Gabriel Lorenzo Diaz</td>
                        <td>Sep 28, 2024</td>
                        <td>2 items</td>
                        <td class="transaction-amount">₱1,200.00</td>
                        <td>Cash</td>
                        <td><span class="payment-badge status-completed">Completed</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="supplier-id">ORD010</td>
                        <td class="supplier-name">Samantha Joy Rivera</td>
                        <td>Sep 28, 2024</td>
                        <td>4 items</td>
                        <td class="transaction-amount">₱3,780.00</td>
                        <td>Credit Card</td>
                        <td><span class="payment-badge status-completed">Completed</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="showing-info">
                Showing <strong>1-10</strong> of <strong>542</strong>
            </div>

            <div class="pagination">
                <button class="page-btn page-prev" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn">4</button>
                <button class="page-btn">5</button>
                <button class="page-btn page-next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
