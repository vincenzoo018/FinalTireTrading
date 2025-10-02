@extends('layouts.admin.app')

@section('title', 'Employee Management')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Employee Management</h1>
        <button class="btn-add-supplier">
            <i class="fas fa-plus"></i>
            Add Employee
        </button>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #3498db;">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stat-info">
                <h3>48</h3>
                <p>Total Employees</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #2ecc71;">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info">
                <h3>42</h3>
                <p>Active</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #e74c3c;">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="stat-info">
                <h3>6</h3>
                <p>On Leave</p>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="table-controls">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search employees...">
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
                            Employee ID
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Name
                            <i class="fas fa-sort"></i>
                        </th>
                        <th>Position</th>
                        <th>Contact Number</th>
                        <th>Role</th>
                        <th>Join Date</th>
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
                        <td class="supplier-id">EMP001</td>
                        <td class="supplier-name">Maria Santos</td>
                        <td>Senior Stylist</td>
                        <td>+63 917 234 5678</td>
                        <td><span class="role-badge role-staff">Staff</span></td>
                        <td>Jan 15, 2022</td>
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
                        <td class="supplier-id">EMP002</td>
                        <td class="supplier-name">Juan Dela Cruz</td>
                        <td>Manager</td>
                        <td>+63 918 345 6789</td>
                        <td><span class="role-badge role-manager">Manager</span></td>
                        <td>Mar 20, 2021</td>
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
                        <td class="supplier-id">EMP003</td>
                        <td class="supplier-name">Anna Reyes</td>
                        <td>Nail Technician</td>
                        <td>+63 919 456 7890</td>
                        <td><span class="role-badge role-staff">Staff</span></td>
                        <td>Jun 10, 2022</td>
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
                        <td class="supplier-id">EMP004</td>
                        <td class="supplier-name">Carlos Garcia</td>
                        <td>Receptionist</td>
                        <td>+63 920 567 8901</td>
                        <td><span class="role-badge role-staff">Staff</span></td>
                        <td>Aug 05, 2023</td>
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
                        <td class="supplier-id">EMP005</td>
                        <td class="supplier-name">Lisa Mendoza</td>
                        <td>Makeup Artist</td>
                        <td>+63 921 678 9012</td>
                        <td><span class="role-badge role-staff">Staff</span></td>
                        <td>Feb 28, 2023</td>
                        <td><span class="payment-badge status-leave">On Leave</span></td>
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
                        <td class="supplier-id">EMP006</td>
                        <td class="supplier-name">Mark Gonzales</td>
                        <td>Assistant Manager</td>
                        <td>+63 922 789 0123</td>
                        <td><span class="role-badge role-manager">Manager</span></td>
                        <td>Nov 12, 2021</td>
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
                        <td class="supplier-id">EMP007</td>
                        <td class="supplier-name">Sarah Lopez</td>
                        <td>Junior Stylist</td>
                        <td>+63 923 890 1234</td>
                        <td><span class="role-badge role-staff">Staff</span></td>
                        <td>May 18, 2023</td>
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
                        <td class="supplier-id">EMP008</td>
                        <td class="supplier-name">Daniel Cruz</td>
                        <td>Spa Therapist</td>
                        <td>+63 924 901 2345</td>
                        <td><span class="role-badge role-staff">Staff</span></td>
                        <td>Jul 22, 2022</td>
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
                        <td class="supplier-id">EMP009</td>
                        <td class="supplier-name">Michelle Torres</td>
                        <td>Color Specialist</td>
                        <td>+63 925 012 3456</td>
                        <td><span class="role-badge role-staff">Staff</span></td>
                        <td>Dec 03, 2022</td>
                        <td><span class="payment-badge status-leave">On Leave</span></td>
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
                        <td class="supplier-id">EMP010</td>
                        <td class="supplier-name">Roberto Ramos</td>
                        <td>Inventory Clerk</td>
                        <td>+63 926 123 4567</td>
                        <td><span class="role-badge role-admin">Admin</span></td>
                        <td>Apr 14, 2023</td>
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
                Showing <strong>1-10</strong> of <strong>48</strong>
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
