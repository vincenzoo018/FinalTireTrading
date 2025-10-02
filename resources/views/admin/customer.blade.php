@extends('layouts.admin.app')

@section('title', 'Customers Management')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Customers Management</h1>
        <button class="btn-add-supplier">
            <i class="fas fa-plus"></i>
            Add Customer
        </button>
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
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info">
                <h3>1,089</h3>
                <p>Active Customers</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #f39c12;">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="stat-info">
                <h3>45</h3>
                <p>New This Month</p>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="table-controls">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search customers...">
            </div>

            <div class="filter-wrapper">
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
                            Customer ID
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Full Name
                            <i class="fas fa-sort"></i>
                        </th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>Address</th>
                        <th>Total Orders</th>
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
                        <td class="supplier-id">CUST001</td>
                        <td class="supplier-name">Maria Clara Santos</td>
                        <td>maria.santos@gmail.com</td>
                        <td>+63 917 234 5678</td>
                        <td>123 Rizal St., Davao City</td>
                        <td><span class="order-count">28</span></td>
                        <td><span class="payment-badge status-active">Active</span></td>
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
                        <td class="supplier-id">CUST002</td>
                        <td class="supplier-name">Juan Paolo Reyes</td>
                        <td>juan.reyes@yahoo.com</td>
                        <td>+63 918 345 6789</td>
                        <td>456 Bonifacio Ave., Davao City</td>
                        <td><span class="order-count">15</span></td>
                        <td><span class="payment-badge status-active">Active</span></td>
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
                        <td class="supplier-id">CUST003</td>
                        <td class="supplier-name">Anna Marie Cruz</td>
                        <td>anna.cruz@hotmail.com</td>
                        <td>+63 919 456 7890</td>
                        <td>789 Luna St., Davao City</td>
                        <td><span class="order-count">42</span></td>
                        <td><span class="payment-badge status-active">Active</span></td>
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
                        <td class="supplier-id">CUST004</td>
                        <td class="supplier-name">Carlos Miguel Torres</td>
                        <td>carlos.torres@gmail.com</td>
                        <td>+63 920 567 8901</td>
                        <td>321 Quezon Blvd., Davao City</td>
                        <td><span class="order-count">8</span></td>
                        <td><span class="payment-badge status-active">Active</span></td>
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
                        <td class="supplier-id">CUST005</td>
                        <td class="supplier-name">Isabella Garcia</td>
                        <td>bella.garcia@outlook.com</td>
                        <td>+63 921 678 9012</td>
                        <td>567 Mabini St., Davao City</td>
                        <td><span class="order-count">22</span></td>
                        <td><span class="payment-badge status-inactive">Inactive</span></td>
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
                        <td class="supplier-id">CUST006</td>
                        <td class="supplier-name">Sofia Angelica Mendoza</td>
                        <td>sofia.mendoza@gmail.com</td>
                        <td>+63 922 789 0123</td>
                        <td>890 Del Pilar St., Davao City</td>
                        <td><span class="order-count">35</span></td>
                        <td><span class="payment-badge status-active">Active</span></td>
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
                        <td class="supplier-id">CUST007</td>
                        <td class="supplier-name">Miguel Antonio Ramos</td>
                        <td>miguel.ramos@yahoo.com</td>
                        <td>+63 923 890 1234</td>
                        <td>234 Osmeña St., Davao City</td>
                        <td><span class="order-count">12</span></td>
                        <td><span class="payment-badge status-active">Active</span></td>
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
                        <td class="supplier-id">CUST008</td>
                        <td class="supplier-name">Patricia Nicole Flores</td>
                        <td>patricia.flores@gmail.com</td>
                        <td>+63 924 901 2345</td>
                        <td>678 Jacinto St., Davao City</td>
                        <td><span class="order-count">19</span></td>
                        <td><span class="payment-badge status-active">Active</span></td>
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
                        <td class="supplier-id">CUST009</td>
                        <td class="supplier-name">Gabriel Lorenzo Diaz</td>
                        <td>gabe.diaz@hotmail.com</td>
                        <td>+63 925 012 3456</td>
                        <td>901 Aguinaldo Ave., Davao City</td>
                        <td><span class="order-count">5</span></td>
                        <td><span class="payment-badge status-active">Active</span></td>
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
                        <td class="supplier-id">CUST010</td>
                        <td class="supplier-name">Samantha Joy Rivera</td>
                        <td>sam.rivera@outlook.com</td>
                        <td>+63 926 123 4567</td>
                        <td>345 Roxas Blvd., Davao City</td>
                        <td><span class="order-count">31</span></td>
                        <td><span class="payment-badge status-active">Active</span></td>
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
                Showing <strong>1-10</strong> of <strong>1,254</strong>
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
