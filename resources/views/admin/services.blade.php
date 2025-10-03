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

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
                        <th><input type="checkbox" class="checkbox-all"></th>
                        <th class="sortable">ID <i class="fas fa-sort"></i></th>
                        <th class="sortable">Service Name <i class="fas fa-sort"></i></th>
                        <th>Description</th>
                        <th>Assigned Employee</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Bookings</th>
                        <th class="actions-header">Actions <i class="fas fa-info-circle tooltip-icon"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                        <tr>
                            <td><input type="checkbox" class="row-checkbox"></td>
                            <td>{{ $service->service_id }}</td>
                            <td>{{ $service->service_name }}</td>
                            <td>{{ $service->description ?? 'N/A' }}</td>
                            <td>{{ $service->employee->name ?? 'N/A' }}</td>
                            <td>₱{{ number_format($service->service_price, 2) }}</td>
                            <td><span class="payment-badge status-active">Active</span></td>
                            <td>{{ $service->bookings->count() }}</td>
                            <td class="actions-cell">
                                <button class="btn-icon btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-icon btn-view" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="showing-info">
                Showing <strong>1-{{ count($services) }}</strong> of <strong>{{ count($services) }}</strong>
            </div>

            <div class="pagination">
                <button class="page-btn page-prev" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn page-next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Service Modal -->
<div id="addServiceModal" class="modal-overlay" style="display: none;">
    <div class="modal">
        <h2>Add New Service</h2>
        <form action="{{ route('admin.services.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="service_name">Service Name *</label>
                <input type="text" name="service_name" required placeholder="Enter service name">
            </div>
            <div class="form-group">
                <label for="service_price">Service Price *</label>
                <input type="number" name="service_price" step="0.01" required placeholder="Enter price">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" placeholder="Enter description (optional)"></textarea>
            </div>
            <div class="form-group">
                <label for="employee_id">Assigned Employee *</label>
                <select name="employee_id" required>
                    <option value="">Select Employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->employee_id }}">{{ $employee->name ?? 'Employee #' . $employee->employee_id }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Service</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Styles -->
<style>
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .modal {
        background: white;
        padding: 30px;
        border-radius: 8px;
        width: 500px;
        max-width: 90%;
    }

    .modal h2 {
        margin-top: 0;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 8px;
        font-size: 14px;
        margin-top: 5px;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn.btn-primary {
        background-color: #1d4ed8;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
    }

    .btn.btn-secondary {
        background-color: #e5e7eb;
        color: black;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
    }
</style>

<!-- Modal Script -->
<script>
    const modal = document.getElementById("addServiceModal");

    document.querySelector(".btn-add-supplier").addEventListener("click", () => {
        modal.style.display = "flex";
    });

    function closeModal() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target === modal) {
            closeModal();
        }
    };
</script>
@endsection
