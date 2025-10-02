@extends('layouts.admin.app')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Supplier List</h1>
        <button class="btn-add-supplier">
            <i class="fas fa-plus"></i>
            Add Supplier
        </button>
    </div>

    <div class="content-card">
        <div class="table-controls">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search suppliers...">
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
                            ID
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Supplier Name
                            <i class="fas fa-sort"></i>
                        </th>
                        <th>Contact Person</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Payment Terms</th>
                        <th class="actions-header">
                            Actions
                            <i class="fas fa-info-circle tooltip-icon"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">478</td>
                        <td class="supplier-name">PrimeSource Sup...</td>
                        <td>Juan Miguel Dela Cruz</td>
                        <td>+63 917 123 4567</td>
                        <td>juan.delac@hotmail.com</td>
                        <td><span class="payment-badge">12 months</span></td>
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
                        <td class="supplier-id">693</td>
                        <td class="supplier-name">BlueSky Distribut...</td>
                        <td>Sophia Ann Velasquez</td>
                        <td>+63 912 234 5678</td>
                        <td>bluesky.sopha@gmail.com</td>
                        <td><span class="payment-badge">12 months</span></td>
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
                        <td class="supplier-id">403</td>
                        <td class="supplier-name">EdgePro Procure...</td>
                        <td>Carlos Eduardo Sant...</td>
                        <td>+63 922 345 6789</td>
                        <td>carlos.s@protonmail.com</td>
                        <td><span class="payment-badge">12 months</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Additional sample rows -->
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">179</td>
                        <td class="supplier-name">SwiftLine Solutions</td>
                        <td>Ariana Mae Paredes</td>
                        <td>+63 926 456 7890</td>
                        <td>swiftline_ari@mail.com</td>
                        <td><span class="payment-badge">12 months</span></td>
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
                Showing <strong>1-10</strong> of <strong>1000</strong>
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
                <button class="page-btn">6</button>
                <button class="page-btn">7</button>
                <button class="page-btn">8</button>
                <button class="page-btn">9</button>
                <button class="page-btn">10</button>
                <button class="page-btn page-next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
