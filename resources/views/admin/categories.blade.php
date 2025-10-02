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
            <td>{{ $category->created_at->format('M d, Y') }}</td>
            <td class="actions-cell">
                <form method="POST" action="{{ route('admin.categories.destroy', $category->category_id) }}" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-icon btn-delete" title="Delete" onclick="return confirm('Mark this category as inactive?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                <button type="button" class="btn-icon btn-edit" title="Edit" data-id="{{ $category->category_id }}" data-name="{{ $category->category_name }}" data-status="{{ $category->status }}" onclick="openEditCategoryModal(this)">
                    <i class="fas fa-edit"></i>
                </button>
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
