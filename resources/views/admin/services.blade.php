@extends('layouts.admin.app')

@section('title', 'Services Management')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Services Management</h1>
        <button class="btn-add-supplier">
            <i class="fas fa-plus"></i>
            Add Service
        </button>
    </div>

    <div class="content-card">
        <div class="table-controls">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search services...">
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
                            Service Name
                            <i class="fas fa-sort"></i>
                        </th>
                        <th>Category</th>
                        <th>Duration</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Bookings</th>
                        <th class="actions-header">
                            Actions
                            <i class="fas fa-info-circle tooltip-icon"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">1</td>
                        <td class="supplier-name">Hair Cut & Styling</td>
                        <td>Hair Services</td>
                        <td>45 mins</td>
                        <td>₱350.00</td>
                        <td><span class="payment-badge status-active">Active</span></td>
                        <td>127</td>
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
                        <td class="supplier-id">2</td>
                        <td class="supplier-name">Hair Coloring</td>
                        <td>Hair Services</td>
                        <td>90 mins</td>
                        <td>₱1,200.00</td>
                        <td><span class="payment-badge status-active">Active</span></td>
                        <td>89</td>
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
                        <td class="supplier-id">3</td>
                        <td class="supplier-name">Facial Treatment</td>
                        <td>Skin Care</td>
                        <td>60 mins</td>
                        <td>₱800.00</td>
                        <td><span class="payment-badge status-active">Active</span></td>
                        <td>56</td>
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
                        <td class="supplier-id">4</td>
                        <td class="supplier-name">Manicure & Pedicure</td>
                        <td>Nail Services</td>
                        <td>75 mins</td>
                        <td>₱450.00</td>
                        <td><span class="payment-badge">Inactive</span></td>
                        <td>43</td>
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
                        <td class="supplier-id">5</td>
                        <td class="supplier-name">Hair Rebonding</td>
                        <td>Hair Services</td>
                        <td>180 mins</td>
                        <td>₱2,500.00</td>
                        <td><span class="payment-badge status-active">Active</span></td>
                        <td>34</td>
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
                        <td class="supplier-id">6</td>
                        <td class="supplier-name">Makeup Services</td>
                        <td>Beauty Services</td>
                        <td>60 mins</td>
                        <td>₱1,500.00</td>
                        <td><span class="payment-badge status-active">Active</span></td>
                        <td>78</td>
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
                        <td class="supplier-id">7</td>
                        <td class="supplier-name">Spa Treatment</td>
                        <td>Wellness</td>
                        <td>120 mins</td>
                        <td>₱3,000.00</td>
                        <td><span class="payment-badge status-active">Active</span></td>
                        <td>92</td>
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
                        <td class="supplier-id">8</td>
                        <td class="supplier-name">Brazilian Blowout</td>
                        <td>Hair Services</td>
                        <td>150 mins</td>
                        <td>₱3,500.00</td>
                        <td><span class="payment-badge status-active">Active</span></td>
                        <td>28</td>
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
                        <td class="supplier-id">9</td>
                        <td class="supplier-name">Eyelash Extension</td>
                        <td>Beauty Services</td>
                        <td>90 mins</td>
                        <td>₱1,800.00</td>
                        <td><span class="payment-badge status-active">Active</span></td>
                        <td>65</td>
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
                        <td class="supplier-id">10</td>
                        <td class="supplier-name">Body Massage</td>
                        <td>Wellness</td>
                        <td>90 mins</td>
                        <td>₱1,200.00</td>
                        <td><span class="payment-badge status-active">Active</span></td>
                        <td>112</td>
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
                Showing <strong>1-10</strong> of <strong>45</strong>
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
