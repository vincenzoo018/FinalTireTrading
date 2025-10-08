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
                            <div class="action-buttons">
                                <button class="btn-action btn-view" title="View Supplier" 
                                        onclick="viewSupplier({{ $supplier->supplier_id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action btn-edit" title="Edit Supplier" 
                                        onclick="editSupplier({{ $supplier->supplier_id }}, '{{ addslashes($supplier->supplier_name) }}', '{{ addslashes($supplier->company_name) }}', '{{ addslashes($supplier->address) }}', '{{ addslashes($supplier->contact_person) }}', '{{ $supplier->contact_number }}', '{{ $supplier->email }}', '{{ addslashes($supplier->payment_terms) }}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete-action" title="Delete Supplier" 
                                        onclick="deleteSupplier({{ $supplier->supplier_id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
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

<!-- View Supplier Modal -->
<div id="viewSupplierModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 700px;">
        <div class="modal-header-view">
            <h2><i class="fas fa-eye"></i> Supplier Details</h2>
            <button class="modal-close-btn" onclick="closeViewSupplierModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body-view">
            <div class="view-details-supplier">
                <div class="detail-row">
                    <span class="detail-label">Supplier ID:</span>
                    <span class="detail-value" id="view_supplier_id"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Supplier Name:</span>
                    <span class="detail-value" id="view_supplier_name"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Company Name:</span>
                    <span class="detail-value" id="view_company_name"></span>
                </div>
                <div class="detail-row full-width">
                    <span class="detail-label">Address:</span>
                    <span class="detail-value" id="view_address"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Contact Person:</span>
                    <span class="detail-value" id="view_contact_person"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Contact Number:</span>
                    <span class="detail-value" id="view_contact_number"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value" id="view_email"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment Terms:</span>
                    <span class="detail-value" id="view_payment_terms"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Created At:</span>
                    <span class="detail-value" id="view_created_at"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Updated At:</span>
                    <span class="detail-value" id="view_updated_at"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeViewSupplierModal()" class="btn-cancel">Close</button>
            <button type="button" onclick="editFromView()" class="btn-save">
                <i class="fas fa-edit"></i> Edit Supplier
            </button>
        </div>
    </div>
</div>

<!-- Edit Supplier Modal -->
<div id="editSupplierModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h2><i class="fas fa-edit"></i> Edit Supplier</h2>
            <p class="required-text">Fields marked with an asterisk <span class="asterisk">(*)</span> are required.</p>
        </div>
        <form id="editSupplierForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_supplier_id" name="supplier_id">
            
            <div class="modal-body">
                <div class="form-grid" style="grid-template-columns: 1fr;">
                    <div class="form-group">
                        <label class="form-label">Supplier Name <span class="required">*</span></label>
                        <input type="text" id="edit_supplier_name" name="supplier_name" class="form-input" placeholder="Enter supplier name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Company Name <span class="required">*</span></label>
                        <input type="text" id="edit_company_name" name="company_name" class="form-input" placeholder="Enter company name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address <span class="required">*</span></label>
                        <input type="text" id="edit_address" name="address" class="form-input" placeholder="Enter address" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact Person <span class="required">*</span></label>
                        <input type="text" id="edit_contact_person" name="contact_person" class="form-input" placeholder="Enter contact person" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact Number <span class="required">*</span></label>
                        <input type="text" id="edit_contact_number" name="contact_number" class="form-input" placeholder="Enter contact number" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email <span class="required">*</span></label>
                        <input type="email" id="edit_email" name="email" class="form-input" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Payment Terms <span class="required">*</span></label>
                        <input type="text" id="edit_payment_terms" name="payment_terms" class="form-input" placeholder="Enter payment terms" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeEditSupplierModal()">Cancel</button>
                <button type="submit" class="btn-save">Update Supplier</button>
            </div>
        </form>
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

/* View Modal Styles */
.modal-header-view {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    border-bottom: 2px solid #f1f5f9;
}

.modal-header-view h2 {
    margin: 0;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.5rem;
    font-weight: 600;
}

.modal-header-view h2 i {
    color: #3b82f6;
}

.modal-close-btn {
    background: none;
    border: none;
    font-size: 20px;
    color: #64748b;
    cursor: pointer;
    padding: 5px;
    transition: all 0.2s;
}

.modal-close-btn:hover {
    color: #ef4444;
    transform: rotate(90deg);
}

.modal-body-view {
    padding: 2rem;
}

.view-details-supplier {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.detail-row {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.detail-row.full-width {
    grid-column: span 2;
}

.detail-label {
    font-size: 12px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-value {
    font-size: 15px;
    color: #1e293b;
    font-weight: 500;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    padding: 0.5rem;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
}

.btn-action i {
    font-size: 14px;
}

.btn-view {
    background: #eff6ff;
    color: #2563eb;
}

.btn-view:hover {
    background: #dbeafe;
    color: #1e40af;
}

.btn-edit {
    background: #fef3c7;
    color: #d97706;
}

.btn-edit:hover {
    background: #fde68a;
    color: #b45309;
}

.btn-delete-action {
    background: #fee2e2;
    color: #dc2626;
}

.btn-delete-action:hover {
    background: #fecaca;
    color: #b91c1c;
}

@media (max-width: 768px) {
    .view-details-supplier {
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
        closeViewSupplierModal();
        closeEditSupplierModal();
    }
});

// View Supplier Function
function viewSupplier(id) {
    fetch(`/admin/suppliers/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('view_supplier_id').textContent = '#' + data.supplier_id;
            document.getElementById('view_supplier_name').textContent = data.supplier_name;
            document.getElementById('view_company_name').textContent = data.company_name;
            document.getElementById('view_address').textContent = data.address;
            document.getElementById('view_contact_person').textContent = data.contact_person;
            document.getElementById('view_contact_number').textContent = data.contact_number;
            document.getElementById('view_email').textContent = data.email;
            document.getElementById('view_payment_terms').textContent = data.payment_terms;
            document.getElementById('view_created_at').textContent = new Date(data.created_at).toLocaleDateString('en-US', {year: 'numeric', month: 'long', day: 'numeric'});
            document.getElementById('view_updated_at').textContent = new Date(data.updated_at).toLocaleDateString('en-US', {year: 'numeric', month: 'long', day: 'numeric'});
            
            window.currentSupplierData = data;
            document.getElementById('viewSupplierModal').style.display = 'flex';
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error loading supplier details', 'error');
        });
}

function closeViewSupplierModal() {
    document.getElementById('viewSupplierModal').style.display = 'none';
}

// Edit Supplier Function
function editSupplier(id, supplierName, companyName, address, contactPerson, contactNumber, email, paymentTerms) {
    document.getElementById('editSupplierModal').style.display = 'flex';
    
    document.getElementById('editSupplierForm').action = `/admin/suppliers/${id}`;
    document.getElementById('edit_supplier_id').value = id;
    document.getElementById('edit_supplier_name').value = supplierName;
    document.getElementById('edit_company_name').value = companyName;
    document.getElementById('edit_address').value = address;
    document.getElementById('edit_contact_person').value = contactPerson;
    document.getElementById('edit_contact_number').value = contactNumber;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_payment_terms').value = paymentTerms;
    
    showToast('Supplier loaded for editing', 'info');
}

function closeEditSupplierModal() {
    document.getElementById('editSupplierModal').style.display = 'none';
    document.getElementById('editSupplierForm').reset();
}

function editFromView() {
    closeViewSupplierModal();
    if (window.currentSupplierData) {
        const data = window.currentSupplierData;
        editSupplier(
            data.supplier_id, 
            data.supplier_name, 
            data.company_name, 
            data.address, 
            data.contact_person, 
            data.contact_number, 
            data.email, 
            data.payment_terms
        );
    }
}

// Delete Supplier Function
function deleteSupplier(id) {
    if (confirm('⚠️ Are you sure you want to delete this supplier?\n\nThis action cannot be undone!')) {
        fetch(`/admin/suppliers/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Supplier deleted successfully', 'success');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showToast('Error deleting supplier', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error deleting supplier', 'error');
        });
    }
}

// Search Functionality
let searchTimeout;
const searchInput = document.querySelector('.search-input');
if (searchInput) {
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const searchValue = e.target.value;
        
        searchTimeout = setTimeout(() => {
            if (searchValue.length >= 2 || searchValue.length === 0) {
                fetch(`/admin/suppliers?search=${encodeURIComponent(searchValue)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(suppliers => {
                    updateSupplierTable(suppliers);
                })
                .catch(error => {
                    console.error('Search error:', error);
                });
            }
        }, 300);
    });
}

function updateSupplierTable(suppliers) {
    const tbody = document.querySelector('.supplier-table tbody');
    
    if (suppliers.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center">No suppliers found.</td></tr>';
        return;
    }
    
    tbody.innerHTML = suppliers.map(supplier => `
        <tr>
            <td><input type="checkbox" class="row-checkbox"></td>
            <td class="supplier-id">${supplier.supplier_id}</td>
            <td class="supplier-name">${supplier.supplier_name}</td>
            <td>${supplier.contact_person}</td>
            <td>${supplier.contact_number}</td>
            <td>${supplier.email}</td>
            <td><span class="payment-badge">${supplier.payment_terms}</span></td>
            <td class="actions-cell">
                <div class="action-buttons">
                    <button class="btn-action btn-view" title="View Supplier" 
                            onclick="viewSupplier(${supplier.supplier_id})">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-action btn-edit" title="Edit Supplier" 
                            onclick="editSupplier(${supplier.supplier_id}, '${supplier.supplier_name.replace(/'/g, "\\'")}', '${supplier.company_name.replace(/'/g, "\\'")}', '${supplier.address.replace(/'/g, "\\'")}', '${supplier.contact_person.replace(/'/g, "\\'")}', '${supplier.contact_number}', '${supplier.email}', '${supplier.payment_terms.replace(/'/g, "\\'")}')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action btn-delete-action" title="Delete Supplier" 
                            onclick="deleteSupplier(${supplier.supplier_id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

// Toast notification function
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 24px;
        background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        z-index: 10000;
        animation: slideIn 0.3s ease-out;
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Modal click outside to close
document.getElementById('viewSupplierModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeViewSupplierModal();
    }
});

document.getElementById('editSupplierModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditSupplierModal();
    }
});
</script>
@endsection
