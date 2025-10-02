@extends('layouts.admin.app')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Supplier List</h1>
        <button class="btn-add-supplier" onclick="openSupplierModal()">
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
                @forelse($suppliers as $supplier)
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">{{ $supplier->supplier_id }}</td>
                        <td class="supplier-name">{{ $supplier->supplier_name }}</td>
                        <td>{{ $supplier->contact_person }}</td>
                        <td>{{ $supplier->contact_number }}</td>
                        <td>{{ $supplier->email }}</td>
                        <td><span class="payment-badge">{{ $supplier->payment_terms }}</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No suppliers found.</td>
                    </tr>
                @endforelse
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

<!-- Add Supplier Modal -->
<div class="modal-overlay" id="supplierModal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h2>Add New Supplier</h2>
            <p class="required-text">Fields marked with an asterisk <span class="asterisk">(*)</span> are required.</p>
        </div>

        <form id="supplierForm" method="POST" action="{{ route('admin.suppliers.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-grid" style="grid-template-columns: 1fr;">
                    <div class="form-group">
                        <label class="form-label">Supplier Name <span class="required">*</span></label>
                        <input type="text" name="supplier_name" class="form-input" placeholder="Enter supplier name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Company Name <span class="required">*</span></label>
                        <input type="text" name="company_name" class="form-input" placeholder="Enter company name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address <span class="required">*</span></label>
                        <input type="text" name="address" class="form-input" placeholder="Enter address" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact Person <span class="required">*</span></label>
                        <input type="text" name="contact_person" class="form-input" placeholder="Enter contact person" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact Number <span class="required">*</span></label>
                        <input type="text" name="contact_number" class="form-input" placeholder="Enter contact number" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email <span class="required">*</span></label>
                        <input type="email" name="email" class="form-input" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Payment Terms <span class="required">*</span></label>
                        <input type="text" name="payment_terms" class="form-input" placeholder="Enter payment terms" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeSupplierModal()">Cancel</button>
                <button type="submit" class="btn-save">Save Supplier</button>
            </div>
        </form>
    </div>
</div>
</div>
<style>
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}
.modal-overlay.active {
    display: flex;
}
.modal-content {
    background: white;
    border-radius: 0.75rem;
    width: 100%;
    max-width: 900px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
.modal-header {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e2e8f0;
}
.modal-header h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.5rem;
}
.modal-header p {
    font-size: 0.875rem;
    color: #64748b;
}
.modal-header .required-text {
    color: #64748b;
}
.modal-header .asterisk {
    color: #ef4444;
}
.modal-body {
    padding: 2rem;
}
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}
.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}
.form-group.full-width {
    grid-column: 1 / -1;
}
.form-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #334155;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.form-label .required {
    color: #ef4444;
}
.form-label .info-icon {
    color: #94a3b8;
    font-size: 0.75rem;
    cursor: help;
}
.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #cbd5e1;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    color: #1e293b;
    background: white;
    transition: all 0.2s;
}
.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.form-input::placeholder {
    color: #94a3b8;
}
.modal-footer {
    padding: 1.5rem 2rem;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}
.btn-cancel {
    padding: 0.75rem 1.5rem;
    border: 1px solid #cbd5e1;
    background: white;
    color: #475569;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-cancel:hover {
    background: #f8fafc;
    border-color: #94a3b8;
}
.btn-save {
    padding: 0.75rem 1.5rem;
    border: none;
    background: #1e40af;
    color: white;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s;
}
.btn-save:hover {
    background: #1e3a8a;
}
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<script>
function openSupplierModal() {
    document.getElementById('supplierModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeSupplierModal() {
    document.getElementById('supplierModal').classList.remove('active');
    document.body.style.overflow = '';
    document.getElementById('supplierForm').reset();
}
document.getElementById('supplierModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeSupplierModal();
    }
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeSupplierModal();
    }
});
</script>
@endsection
