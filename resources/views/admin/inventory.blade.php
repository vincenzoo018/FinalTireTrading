@extends('layouts.admin.app')

@section('title', 'Inventory Management')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Inventory Management</h1>
        <button class="btn-add-supplier" onclick="openStockModal()">
            <i class="fas fa-plus"></i>
            Stock Update
        </button>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #e74c3c;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h3>12</h3>
                <p>Low Stock Items</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #f39c12;">
                <i class="fas fa-box-open"></i>
            </div>
            <div class="stat-info">
                <h3>45</h3>
                <p>Out of Stock</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #27ae60;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>1,245</h3>
                <p>In Stock Items</p>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="table-controls">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search inventory...">
            </div>

            <div class="filter-wrapper">
                <select class="btn-filter" style="padding-right: 2rem;">
                    <option>All Status</option>
                    <option>In Stock</option>
                    <option>Low Stock</option>
                    <option>Out of Stock</option>
                </select>
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
                            Inventory ID
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Product Name
                            <i class="fas fa-sort"></i>
                        </th>
                        <th>Category</th>
                        <th>Quantity On Hand</th>
                        <th>Last Updated</th>
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
                        <td class="supplier-id">INV001</td>
                        <td class="supplier-name">L'Oréal Professional Shampoo</td>
                        <td>Hair Care</td>
                        <td><span class="stock-badge stock-high">48</span></td>
                        <td>Oct 01, 2024</td>
                        <td><span class="payment-badge status-active">In Stock</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Update Stock">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View History">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">INV002</td>
                        <td class="supplier-name">Kerastase Hair Mask</td>
                        <td>Hair Care</td>
                        <td><span class="stock-badge stock-medium">15</span></td>
                        <td>Oct 02, 2024</td>
                        <td><span class="payment-badge status-pending">Low Stock</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Update Stock">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View History">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">INV003</td>
                        <td class="supplier-name">OPI Nail Polish</td>
                        <td>Nail Care</td>
                        <td><span class="stock-badge stock-high">72</span></td>
                        <td>Sep 30, 2024</td>
                        <td><span class="payment-badge status-active">In Stock</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Update Stock">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View History">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">INV004</td>
                        <td class="supplier-name">Cetaphil Gentle Cleanser</td>
                        <td>Skin Care</td>
                        <td><span class="stock-badge stock-low">8</span></td>
                        <td>Oct 01, 2024</td>
                        <td><span class="payment-badge status-pending">Low Stock</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Update Stock">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View History">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">INV005</td>
                        <td class="supplier-name">Revlon ColorStay Foundation</td>
                        <td>Makeup</td>
                        <td><span class="stock-badge stock-medium">22</span></td>
                        <td>Sep 28, 2024</td>
                        <td><span class="payment-badge status-active">In Stock</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Update Stock">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View History">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">INV006</td>
                        <td class="supplier-name">Wella Koleston Hair Color</td>
                        <td>Hair Color</td>
                        <td><span class="stock-badge stock-high">56</span></td>
                        <td>Oct 02, 2024</td>
                        <td><span class="payment-badge status-active">In Stock</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Update Stock">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View History">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">INV007</td>
                        <td class="supplier-name">Bioderma Micellar Water</td>
                        <td>Skin Care</td>
                        <td><span class="stock-badge stock-medium">18</span></td>
                        <td>Sep 29, 2024</td>
                        <td><span class="payment-badge status-active">In Stock</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Update Stock">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View History">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">INV008</td>
                        <td class="supplier-name">Maybelline Mascara</td>
                        <td>Makeup</td>
                        <td><span class="stock-badge stock-out">0</span></td>
                        <td>Sep 25, 2024</td>
                        <td><span class="payment-badge status-inactive">Out of Stock</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Update Stock">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View History">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">INV009</td>
                        <td class="supplier-name">Moroccan Oil Treatment</td>
                        <td>Hair Care</td>
                        <td><span class="stock-badge stock-medium">12</span></td>
                        <td>Oct 01, 2024</td>
                        <td><span class="payment-badge status-pending">Low Stock</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Update Stock">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View History">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">INV010</td>
                        <td class="supplier-name">The Ordinary Niacinamide</td>
                        <td>Skin Care</td>
                        <td><span class="stock-badge stock-high">34</span></td>
                        <td>Sep 30, 2024</td>
                        <td><span class="payment-badge status-active">In Stock</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-edit" title="Update Stock">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View History">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="showing-info">
                Showing <strong>1-10</strong> of <strong>1,302</strong>
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

<!-- Stock Update Modal -->
<div class="modal-overlay" id="stockModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Update Stock</h2>
            <p class="required-text">Fields marked with an asterisk <span class="asterisk">(*)</span> are required.</p>
        </div>

        <form id="stockForm">
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            Product Name <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <i class="fas fa-search input-icon"></i>
                            <input type="text" class="form-input" placeholder="Search product..." required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Product Category <span class="required">*</span>
                        </label>
                        <select class="form-select" required>
                            <option value="">Select category</option>
                            <option value="hair-care">Hair Care</option>
                            <option value="skin-care">Skin Care</option>
                            <option value="makeup">Makeup</option>
                            <option value="nail-care">Nail Care</option>
                            <option value="hair-color">Hair Color</option>
                            <option value="hair-styling">Hair Styling</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Current Quantity
                            <i class="fas fa-info-circle info-icon" title="Current stock on hand"></i>
                        </label>
                        <input type="number" class="form-input" placeholder="0" readonly style="background: #f8fafc;">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Quantity <span class="required">*</span>
                            <i class="fas fa-info-circle info-icon" title="Amount to add or subtract"></i>
                        </label>
                        <select class="form-select" required>
                            <option value="">Select quantity</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="250">250</option>
                            <option value="500">500</option>
                            <option value="999">999</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Unit of Measure <span class="required">*</span>
                        </label>
                        <select class="form-select" required>
                            <option value="">Select unit</option>
                            <option value="pcs">pcs (pieces)</option>
                            <option value="ml">ml (milliliters)</option>
                            <option value="g">g (grams)</option>
                            <option value="oz">oz (ounces)</option>
                            <option value="kg">kg (kilograms)</option>
                            <option value="l">l (liters)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Unit Price <span class="required">*</span>
                            <i class="fas fa-info-circle info-icon" title="Price per unit"></i>
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-input" placeholder="500" step="0.01" min="0" required>
                            <div class="input-addon">PHP</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Supplier Company Name <span class="required">*</span>
                        </label>
                        <select class="form-select" required>
                            <option value="">Select supplier</option>
                            <option value="loreal">L'Oréal Professional</option>
                            <option value="kerastase">Kérastase</option>
                            <option value="wella">Wella</option>
                            <option value="moroccanoil">Moroccanoil</option>
                            <option value="opi">OPI</option>
                            <option value="cetaphil">Cetaphil</option>
                            <option value="bioderma">Bioderma</option>
                            <option value="ordinary">The Ordinary</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Serial Number <span class="required">*</span>
                        </label>
                        <input type="text" class="form-input" placeholder="XXXXXXXXX" required>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">
                            Notes
                        </label>
                        <textarea class="form-textarea" placeholder="Add any notes about this stock update (optional)"></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeStockModal()">Cancel</button>
                <button type="submit" class="btn-save">Save Stock</button>
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

.input-with-icon {
    position: relative;
}

.input-with-icon .input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.875rem;
}

.input-with-icon .form-input {
    padding-left: 2.5rem;
}

.input-group {
    display: flex;
    gap: 0.5rem;
}

.input-group .form-input {
    flex: 1;
}

.input-addon {
    padding: 0.75rem 1rem;
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    color: #64748b;
    min-width: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
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
function openStockModal() {
    document.getElementById('stockModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeStockModal() {
    document.getElementById('stockModal').classList.remove('active');
    document.body.style.overflow = '';
    document.getElementById('stockForm').reset();
}

// Close modal when clicking outside
document.getElementById('stockModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeStockModal();
    }
});

// Handle form submission
document.getElementById('stockForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // You can add your AJAX submission here
    alert('Stock updated successfully!');
    closeStockModal();
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeStockModal();
    }
});
</script>
@endsection
