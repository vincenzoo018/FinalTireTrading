@extends('layouts.admin.app')

@section('title', 'Employee Management')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Employee Management</h1>
        <button class="btn-add-supplier">
            <i class="fas fa-plus"></i> Add Employee
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="content-card">
        <div class="table-controls">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search employees...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="supplier-table">
                <thead>
                    <tr>
                        <th><input type="checkbox" class="checkbox-all"></th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Contact</th>

                        <th>Join Date</th>
                        <th>Status</th>
                        <th class="actions-header">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $employee)
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td>EMP{{ str_pad($employee->employee_id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $employee->employee_name }}</td>
                        <td>{{ $employee->position }}</td>
                        <td>{{ $employee->contact_number }}</td>

                        <td>{{ $employee->created_at->format('M d, Y') }}</td>
                        <td><span class="payment-badge status-active">Active</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn-icon btn-view" title="View"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center;">No employees found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Employee Modal -->
<div id="addEmployeeModal" class="modal-overlay" style="display: none;">
    <div class="modal">
        <h2>Add New Employee</h2>
        <form method="POST" action="{{ route('admin.employee.store') }}">
            @csrf
            <div class="form-group">
                <label for="employee_name">Employee Name *</label>
                <input type="text" name="employee_name" required>
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number *</label>
                <input type="text" name="contact_number" required>
            </div>
            <div class="form-group">
                <label for="position">Position *</label>
                <input type="text" name="position" required>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Employee</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Styling -->
<style>
    .modal-overlay {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5);
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

    .form-group {
        margin-bottom: 15px;
    }

    .form-group input, .form-group select {
        width: 100%;
        padding: 8px;
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
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
    }

    .btn.btn-secondary {
        background-color: #e5e7eb;
        color: black;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        padding: 10px 15px;
        border-radius: 4px;
        margin: 10px 0;
    }
</style>

<!-- Modal Script -->
<script>
    const modal = document.getElementById("addEmployeeModal");

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
