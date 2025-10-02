@extends('layouts.admin.app')

@section('title', 'Supplier Transactions')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Supplier Transactions</h1>
        <button class="btn-add-supplier">
            <i class="fas fa-plus"></i>
            New Transaction
        </button>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #9b59b6;">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-info">
                <h3>₱945,678</h3>
                <p>Total Transactions</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #3498db;">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div class="stat-info">
                <h3>₱123,450</h3>
                <p>This Month</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #2ecc71;">
                <i class="fas fa-check-double"></i>
            </div>
            <div class="stat-info">
                <h3>156</h3>
                <p>Completed Orders</p>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="table-controls">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search transactions...">
            </div>

            <div class="filter-wrapper">
                <select class="btn-filter" style="padding-right: 2rem;">
                    <option>All Status</option>
                    <option>Pending</option>
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
                            Transaction ID
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Supplier Name
                            <i class="fas fa-sort"></i>
                        </th>
                        <th>Reference Number</th>
                        <th>Order Date</th>
                        <th>Delivery Date</th>
                        <th>Total Amount</th>
                        <th>Tax</th>
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
                        <td class="supplier-id">TXN001</td>
                        <td class="supplier-name">PrimeSource Suppliers</td>
                        <td>REF-2024-001</td>
                        <td>Oct 01, 2024</td>
                        <td>Oct 03, 2024</td>
                        <td class="transaction-amount">₱15,450.00</td>
                        <td>₱1,854.00</td>
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
                        <td class="supplier-id">TXN002</td>
                        <td class="supplier-name">BlueSky Distributors</td>
                        <td>REF-2024-002</td>
                        <td>Oct 02, 2024</td>
                        <td>Oct 05, 2024</td>
                        <td class="transaction-amount">₱28,900.00</td>
                        <td>₱3,468.00</td>
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
                        <td class="supplier-id">TXN003</td>
                        <td class="supplier-name">EdgePro Procurement</td>
                        <td>REF-2024-003</td>
                        <td>Sep 28, 2024</td>
                        <td>Sep 30, 2024</td>
                        <td class="transaction-amount">₱42,350.00</td>
                        <td>₱5,082.00</td>
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
                        <td class="supplier-id">TXN004</td>
                        <td class="supplier-name">SwiftLine Solutions</td>
                        <td>REF-2024-004</td>
                        <td>Sep 25, 2024</td>
                        <td>Sep 27, 2024</td>
                        <td class="transaction-amount">₱18,750.00</td>
                        <td>₱2,250.00</td>
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
                        <td class="supplier-id">TXN005</td>
                        <td class="supplier-name">NexEra Resources</td>
                        <td>REF-2024-005</td>
                        <td>Sep 30, 2024</td>
                        <td>Oct 02, 2024</td>
                        <td class="transaction-amount">₱35,680.00</td>
                        <td>₱4,281.60</td>
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
                        <td class="supplier-id">TXN006</td>
                        <td class="supplier-name">Elevate Supply Co.</td>
                        <td>REF-2024-006</td>
                        <td>Sep 20, 2024</td>
                        <td>Sep 22, 2024</td>
                        <td class="transaction-amount">₱52,100.00</td>
                        <td>₱6,252.00</td>
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
                        <td class="supplier-id">TXN007</td>
                        <td class="supplier-name">TruePath Suppliers</td>
                        <td>REF-2024-007</td>
                        <td>Sep 18, 2024</td>
                        <td>Sep 20, 2024</td>
                        <td class="transaction-amount">₱24,890.00</td>
                        <td>₱2,986.80</td>
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
                        <td class="supplier-id">TXN008</td>
                        <td class="supplier-name">SummitFlow Enterprise</td>
                        <td>REF-2024-008</td>
                        <td>Oct 01, 2024</td>
                        <td>Oct 04, 2024</td>
                        <td class="transaction-amount">₱19,200.00</td>
                        <td>₱2,304.00</td>
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
                        <td class="supplier-id">TXN009</td>
                        <td class="supplier-name">ZenithSource Partners</td>
                        <td>REF-2024-009</td>
                        <td>Sep 15, 2024</td>
                        <td>Sep 17, 2024</td>
                        <td class="transaction-amount">₱38,550.00</td>
                        <td>₱4,626.00</td>
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
                        <td class="supplier-id">TXN010</td>
                        <td class="supplier-name">PulseWave Systems</td>
                        <td>REF-2024-010</td>
                        <td>Sep 12, 2024</td>
                        <td>Sep 14, 2024</td>
                        <td class="transaction-amount">₱31,470.00</td>
                        <td>₱3,776.40</td>
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
                Showing <strong>1-10</strong> of <strong>156</strong>
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
