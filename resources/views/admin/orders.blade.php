@extends('layouts.admin.app')

@section('title', 'Orders Management')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Orders Management</h1>
        <button class="btn-add-supplier">
            <i class="fas fa-plus"></i>
            New Order
        </button>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #3498db;">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3>542</h3>
                <p>Total Orders</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #2ecc71;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>489</h3>
                <p>Completed</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #f39c12;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>42</h3>
                <p>Pending</p>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="table-controls">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search orders...">
            </div>

            <div class="filter-wrapper">
                <select class="btn-filter" style="padding-right: 2rem;">
                    <option>All Status</option>
                    <option>Pending</option>
                    <option>Processing</option>
                    <option>Completed</option>
                    <option>Cancelled</option>
                </select>
                <button class="btn-filter">
                    <i class="fas fa-filter"></i>
                    Filters
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="supplier-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="checkbox-all">
                        </th>
                        <th class="sortable">
                            Order ID
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Customer Name
                            <i class="fas fa-sort"></i>
                        </th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Discount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th class="actions-header">
                            Actions
                            <i class="fas fa-info-circle tooltip-icon"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">ORD001</td>
                        <td class="supplier-name">Maria Clara Santos</td>
                        <td>Oct 02, 2024</td>
                        <td class="transaction-amount">₱2,450.00</td>
                        <td>10%</td>
                        <td>Cash</td>
                        <td><span class="payment-badge status-completed">Completed</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">ORD002</td>
                        <td class="supplier-name">Juan Paolo Reyes</td>
                        <td>Oct 02, 2024</td>
                        <td class="transaction-amount">₱1,800.00</td>
                        <td>5%</td>
                        <td>GCash</td>
                        <td><span class="payment-badge status-completed">Completed</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">ORD003</td>
                        <td class="supplier-name">Anna Marie Cruz</td>
                        <td>Oct 01, 2024</td>
                        <td class="transaction-amount">₱4,200.00</td>
                        <td>15%</td>
                        <td>Credit Card</td>
                        <td><span class="payment-badge status-completed">Completed</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">ORD004</td>
                        <td class="supplier-name">Carlos Miguel Torres</td>
                        <td>Oct 01, 2024</td>
                        <td class="transaction-amount">₱950.00</td>
                        <td>0%</td>
                        <td>Cash</td>
                        <td><span class="payment-badge status-pending">Pending</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">ORD005</td>
                        <td class="supplier-name">Isabella Garcia</td>
                        <td>Sep 30, 2024</td>
                        <td class="transaction-amount">₱3,650.00</td>
                        <td>10%</td>
                        <td>GCash</td>
                        <td><span class="payment-badge status-cancelled">Cancelled</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">ORD006</td>
                        <td class="supplier-name">Sofia Angelica Mendoza</td>
                        <td>Sep 30, 2024</td>
                        <td class="transaction-amount">₱1,500.00</td>
                        <td>5%</td>
                        <td>Cash</td>
                        <td><span class="payment-badge status-completed">Completed</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">ORD007</td>
                        <td class="supplier-name">Miguel Antonio Ramos</td>
                        <td>Sep 29, 2024</td>
                        <td class="transaction-amount">₱2,890.00</td>
                        <td>0%</td>
                        <td>Credit Card</td>
                        <td><span class="payment-badge status-processing">Processing</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">ORD008</td>
                        <td class="supplier-name">Patricia Nicole Flores</td>
                        <td>Sep 29, 2024</td>
                        <td class="transaction-amount">₱5,120.00</td>
                        <td>20%</td>
                        <td>GCash</td>
                        <td><span class="payment-badge status-completed">Completed</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">ORD009</td>
                        <td class="supplier-name">Gabriel Lorenzo Diaz</td>
                        <td>Sep 28, 2024</td>
                        <td class="transaction-amount">₱1,200.00</td>
                        <td>5%</td>
                        <td>Cash</td>
                        <td><span class="payment-badge status-completed">Completed</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">ORD010</td>
                        <td class="supplier-name">Samantha Joy Rivera</td>
                        <td>Sep 28, 2024</td>
                        <td class="transaction-amount">₱3,780.00</td>
                        <td>10%</td>
                        <td>Credit Card</td>
                        <td><span class="payment-badge status-completed">Completed</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
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
