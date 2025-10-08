@extends('layouts.admin.app')

@section('title', 'Product Categories')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Product Categories</h1>
        <button class="btn-add-supplier" onclick="openCategoryModal()">
            <i class="fas fa-plus"></i>
            Add Category
        </button>
    </div>

    <div class="content-card">
        <div class="table-controls">
            <div class="search-wrapper" style="display: flex; align-items: center;">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="liveSearchInput" name="search" class="search-input" placeholder="Search categories..." value="{{ request('search') }}" autocomplete="off">
            </div>
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
                            Category ID
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Category Name
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Status
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Date
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="actions-header">
                            Actions
                            <i class="fas fa-info-circle tooltip-icon"></i>
                        </th>
                    </tr>
                </thead>
                <tbody id="categoriesTableBody">
    @forelse($categories as $category)
        <tr>
            <td><input type="checkbox" class="row-checkbox"></td>
            <td class="supplier-id">{{ $category->category_id }}</td>
            <td class="supplier-name">{{ $category->category_name }}</td>
            <td>
                <span class="payment-badge {{ $category->status === 'active' ? 'status-active' : 'status-inactive' }}">
                    {{ ucfirst($category->status) }}
                </span>
            </td>
            <td>
    {{ $category->created_at ? $category->created_at->format('M d, Y') : 'N/A' }}
</td>
            <td class="actions-cell">
                <div class="action-buttons">
                    <button class="btn-action btn-view" title="View Category" 
                            onclick="viewCategory({{ $category->category_id }})">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn-action btn-edit" title="Edit Category" 
                            onclick="editCategory({{ $category->category_id }}, '{{ addslashes($category->category_name) }}', '{{ $category->status }}')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action btn-delete-action" title="Delete Category" 
                            onclick="deleteCategory({{ $category->category_id }})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center">No categories found.</td>
        </tr>
    @endforelse
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

<!-- View Category Modal -->
<div id="viewCategoryModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header-view">
            <h2><i class="fas fa-eye"></i> Category Details</h2>
            <button class="modal-close-btn" onclick="closeViewCategoryModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body-view">
            <div class="view-details-supplier">
                <div class="detail-row">
                    <span class="detail-label">Category ID:</span>
                    <span class="detail-value" id="view_category_id"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Category Name:</span>
                    <span class="detail-value" id="view_category_name"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value" id="view_category_status"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Created At:</span>
                    <span class="detail-value" id="view_category_created_at"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Updated At:</span>
                    <span class="detail-value" id="view_category_updated_at"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeViewCategoryModal()" class="btn-cancel">Close</button>
            <button type="button" onclick="editFromViewCategory()" class="btn-save">
                <i class="fas fa-edit"></i> Edit Category
            </button>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div id="editCategoryModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h2><i class="fas fa-edit"></i> Edit Category</h2>
            <p class="required-text">Fields marked with an asterisk <span class="asterisk">(*)</span> are required.</p>
        </div>
        <form id="editCategoryForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_category_id" name="category_id">
            
            <div class="modal-body">
                <div class="form-grid" style="grid-template-columns: 1fr;">
                    <div class="form-group">
                        <label class="form-label">Category Name <span class="required">*</span></label>
                        <input type="text" id="edit_category_name" name="category_name" class="form-input" placeholder="Enter category name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status <span class="required">*</span></label>
                        <select id="edit_category_status" name="status" class="form-select" required>
                            <option value="">Select status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeEditCategoryModal()">Cancel</button>
                <button type="submit" class="btn-save">Update Category</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal-overlay" id="categoryModal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h2>Add New Category</h2>
            <p class="required-text">Fields marked with an asterisk <span class="asterisk">(*)</span> are required.</p>
        </div>

        <form id="categoryForm" method="POST" action="{{ route('admin.categories.store') }}">
    @csrf

    <div class="modal-body">
        <div class="form-grid" style="grid-template-columns: 1fr;">
            <div class="form-group">
                <label class="form-label">
                    Category Name <span class="required">*</span>
                </label>
                <input type="text" name="category_name" class="form-input" placeholder="Enter category name" required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    Status <span class="required">*</span>
                </label>
                <select name="status" class="form-select" required>
                    <option value="">Select status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn-cancel" onclick="closeCategoryModal()">Cancel</button>
        <button type="submit" class="btn-save">Save Category</button>
    </div>
</form>

    </div>
</div>

<style>
/* Modal Styles */
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

.form-select {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1.25rem;
    padding-right: 2.5rem;
}

.form-textarea {
    min-height: 120px;
    resize: vertical;
    font-family: inherit;
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
function openCategoryModal() {
    document.getElementById('categoryModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeCategoryModal() {
    document.getElementById('categoryModal').classList.remove('active');
    document.body.style.overflow = '';
    document.getElementById('categoryForm').reset();
}

// Close modal when clicking outside
document.getElementById('categoryModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCategoryModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCategoryModal();
        closeViewCategoryModal();
        closeEditCategoryModal();
    }
});

// View Category Function
function viewCategory(id) {
    fetch(`/admin/categories/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('view_category_id').textContent = '#' + data.category_id;
            document.getElementById('view_category_name').textContent = data.category_name;
            document.getElementById('view_category_status').textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
            document.getElementById('view_category_created_at').textContent = new Date(data.created_at).toLocaleDateString('en-US', {year: 'numeric', month: 'long', day: 'numeric'});
            document.getElementById('view_category_updated_at').textContent = new Date(data.updated_at).toLocaleDateString('en-US', {year: 'numeric', month: 'long', day: 'numeric'});
            
            window.currentCategoryData = data;
            document.getElementById('viewCategoryModal').style.display = 'flex';
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error loading category details', 'error');
        });
}

function closeViewCategoryModal() {
    document.getElementById('viewCategoryModal').style.display = 'none';
}

// Edit Category Function
function editCategory(id, categoryName, status) {
    document.getElementById('editCategoryModal').style.display = 'flex';
    
    document.getElementById('editCategoryForm').action = `/admin/categories/${id}`;
    document.getElementById('edit_category_id').value = id;
    document.getElementById('edit_category_name').value = categoryName;
    document.getElementById('edit_category_status').value = status;
}

function closeEditCategoryModal() {
    document.getElementById('editCategoryModal').style.display = 'none';
    document.getElementById('editCategoryForm').reset();
}

function editFromViewCategory() {
    closeViewCategoryModal();
    if (window.currentCategoryData) {
        const data = window.currentCategoryData;
        editCategory(data.category_id, data.category_name, data.status);
    }
}

// Delete Category Function
function deleteCategory(id) {
    if (confirm('⚠️ Are you sure you want to delete this category?\n\nThis action cannot be undone!')) {
        fetch(`/admin/categories/${id}`, {
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
                showToast('Category deleted successfully', 'success');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showToast('Error deleting category', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error deleting category', 'error');
        });
    }
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
document.getElementById('viewCategoryModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeViewCategoryModal();
    }
});

document.getElementById('editCategoryModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditCategoryModal();
    }
});

// Live search for categories
document.getElementById('liveSearchInput').addEventListener('input', function() {
    var search = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '{{ route('admin.categories.index') }}?search=' + encodeURIComponent(search), true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Extract only the table body from the response
            var parser = new DOMParser();
            var doc = parser.parseFromString(xhr.responseText, 'text/html');
            var newTbody = doc.getElementById('categoriesTableBody');
            if (newTbody) {
                document.getElementById('categoriesTableBody').innerHTML = newTbody.innerHTML;
            }
        }
    };
    xhr.send();
});
</script>
@endsection
