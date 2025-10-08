@extends('layouts.admin.app')

@section('title', 'Inventory Management')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Inventory Management</h1>
        <button class="btn-add-supplier" onclick="openStockModal()">
            <i class="fas fa-plus"></i>
            Add Stock
        </button>
    </div>

    <div class="stats-grid">
        <!-- Your stat cards here -->
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
            <div class="search-wrapper" style="position: relative; flex: 1;">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="inventorySearchInput" class="search-input" placeholder="Search by product name, brand, or serial..." autocomplete="off">
                <div id="inventorySearchSuggestions" class="search-suggestions" style="display: none;"></div>
            </div>
            <div class="filter-wrapper">
                <select class="btn-filter" id="statusFilter" style="padding-right: 2rem;">
                    <option value="">All Status</option>
                    <option value="in_stock">In Stock</option>
                    <option value="low_stock">Low Stock</option>
                    <option value="out_of_stock">Out of Stock</option>
                </select>
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
                        <th class="sortable">
                            Supplier Name
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Category
                            <i class="fas fa-sort"></i>
                        </th>
                        <th>Brand</th>
                        <th>Base Price</th>
                        <th>Selling Price</th>
                        <th>Size</th>
                        <th>Quantity On Hand</th>
                        <th>Description</th>
                        <th>Last Updated</th>
                        <th>Status</th>
                        <th class="actions-header">
                            Actions
                            <i class="fas fa-info-circle tooltip-icon"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventories as $inv)
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">INV{{ str_pad($inv->inventory_id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="supplier-name">{{ $inv->product->product_name }}</td>
                        <td>{{ $inv->product->supplier ? $inv->product->supplier->company_name : 'N/A' }}</td>
                        <td>{{ $inv->product->category ? $inv->product->category->category_name : 'N/A' }}</td>
                        <td>{{ $inv->product->brand }}</td>
                        <td>₱{{ number_format($inv->product->base_price, 2) }}</td>
                        <td>₱{{ number_format($inv->product->selling_price, 2) }}</td>
                        <td>{{ $inv->product->size ?? '-' }}</td>
                        <td><span class="stock-badge">{{ $inv->quantity_on_hand }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($inv->last_updated)->format('M d, Y') }}</td>
                        <td>
                            @if($inv->quantity_on_hand < 10)
                                <span class="payment-badge status-pending">Low Stock</span>
                            @else
                                <span class="payment-badge status-active">In Stock</span>
                            @endif
                        </td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <button class="btn-action btn-view" title="View Details" 
                                        onclick="viewInventory({{ $inv->inventory_id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action btn-edit" title="Update Stock" 
                                        onclick="editInventory({{ $inv->inventory_id }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete-action" title="Delete Inventory" 
                                        onclick="deleteInventory({{ $inv->inventory_id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="showing-info">
                Showing <strong>{{ $inventories->total() }}</strong> items
            </div>
            <div class="pagination">
                {{ $inventories->links() }}
            </div>
        </div>
    </div>
</div>

<!-- View Inventory Modal -->
<div id="viewInventoryModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 800px;">
        <div class="modal-header-view">
            <h2><i class="fas fa-eye"></i> Inventory Details</h2>
            <button class="modal-close-btn" onclick="closeViewInventoryModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body-view">
            <div class="view-section-product">
                <div class="view-image-container" id="viewInventoryImage">
                    <!-- Image will be inserted here -->
                </div>
                <div class="view-details-product">
                    <div class="detail-row">
                        <span class="detail-label">Inventory ID:</span>
                        <span class="detail-value" id="view_inventory_id"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Product Name:</span>
                        <span class="detail-value" id="view_product_name"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Category:</span>
                        <span class="detail-value" id="view_category"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Supplier:</span>
                        <span class="detail-value" id="view_supplier"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Brand:</span>
                        <span class="detail-value" id="view_brand"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Size:</span>
                        <span class="detail-value" id="view_size"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Quantity On Hand:</span>
                        <span class="detail-value" id="view_quantity"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Last Updated:</span>
                        <span class="detail-value" id="view_last_updated"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeViewInventoryModal()" class="btn-cancel">Close</button>
            <button type="button" onclick="editFromViewInventory()" class="btn-save">
                <i class="fas fa-edit"></i> Update Stock
            </button>
        </div>
    </div>
</div>

<!-- Edit Inventory Modal -->
<div id="editInventoryModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h2><i class="fas fa-edit"></i> Update Inventory Stock</h2>
            <p class="required-text">Adjust the quantity on hand for this product</p>
        </div>
        <form id="editInventoryForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_inventory_id" name="inventory_id">
            
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Product Name</label>
                    <input type="text" id="edit_product_name_display" class="form-input" readonly style="background: #f8fafc;">
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Current Stock</label>
                        <input type="text" id="edit_current_stock" class="form-input" readonly style="background: #f8fafc;">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">New Quantity <span class="required">*</span></label>
                        <input type="number" id="edit_quantity_on_hand" name="quantity_on_hand" class="form-input" min="0" required>
                    </div>
                </div>
                
                <div class="review-note" style="margin-top: 1rem;">
                    <div class="note-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="note-content">
                        <strong>Note:</strong>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.875rem;">Enter the new total quantity. This will replace the current stock level.</p>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeEditInventoryModal()">Cancel</button>
                <button type="submit" class="btn-save">Update Stock</button>
            </div>
        </form>
    </div>
</div>

<!-- Stock Add Modal - REDESIGNED -->
<div class="modal-overlay" id="stockModal">
    <div class="modal-content" style="max-width: 1200px;">
        <div class="modal-header">
            <h2><i class="fas fa-boxes me-2"></i>Add Stock to Inventory</h2>
            <p class="required-text">
                Select a supplier to view their products, then adjust quantities using +/- buttons
            </p>
        </div>

        <form id="stockForm" method="POST" action="{{ route('admin.inventory.store') }}">
            @csrf
            <div class="modal-body">
                <!-- Supplier Selection & Reference Search -->
                <div class="form-grid" style="margin-bottom: 2rem;">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-truck me-1"></i>Select Supplier <span class="required">*</span>
                        </label>
                        <select name="supplier_id" id="supplier_id" class="form-select" required>
                            <option value="">Choose a supplier...</option>
                            @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->supplier_id }}">{{ $supplier->company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-barcode me-1"></i>Search by Reference Number
                        </label>
                        <div class="input-with-icon">
                            <i class="fas fa-search input-icon"></i>
                            <input type="text" id="reference_search" class="form-input" placeholder="Type reference/serial number...">
                        </div>
                        <small class="text-muted" style="font-size: 0.75rem;">Live search will highlight matching products</small>
                    </div>
                </div>

                <!-- Products Table -->
                <div id="products_table_container" style="display: none;">
                    <div style="margin-bottom: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 0.5rem;">
                        <h4 style="margin: 0; font-size: 1rem; color: #2c3e50;">
                            <i class="fas fa-list-ul me-2"></i>Products from Selected Supplier
                        </h4>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.875rem; color: #6c757d;">
                            Use the <strong>+</strong> and <strong>-</strong> buttons to adjust stock quantities for each product
                        </p>
                    </div>

                    <div class="table-responsive">
                        <table class="supplier-table" id="productsTable">
                            <thead>
                                <tr>
                                    <th style="width: 250px;">Product Name</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Size</th>
                                    <th>Base Price</th>
                                    <th>Selling Price</th>
                                    <th>Serial #</th>
                                    <th>Current Stock</th>
                                    <th style="width: 180px;">Quantity to Add</th>
                                </tr>
                            </thead>
                            <tbody id="productsTableBody">
                                <!-- Rows will be populated dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Empty State -->
                <div id="empty_state" style="text-align: center; padding: 3rem; color: #94a3b8;">
                    <i class="fas fa-box-open" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                    <p style="font-size: 1.1rem; margin: 0;">Select a supplier to view their products</p>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeStockModal()">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="submit" class="btn-save" id="saveStockBtn" disabled>
                    <i class="fas fa-save me-1"></i>Save Stock
                </button>
            </div>
            <input type="hidden" name="stock_data" id="stock_data">
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

/* Quantity Controls */
.quantity-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    justify-content: center;
}

.qty-btn {
    width: 32px;
    height: 32px;
    border: 2px solid #cbd5e1;
    background: white;
    color: #475569;
    border-radius: 0.375rem;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.qty-btn:hover {
    background: #f1f5f9;
    border-color: #94a3b8;
    transform: scale(1.1);
}

.qty-btn:active {
    transform: scale(0.95);
}

.qty-btn.minus {
    color: #ef4444;
    border-color: #fecaca;
}

.qty-btn.minus:hover {
    background: #fef2f2;
    border-color: #ef4444;
}

.qty-btn.plus {
    color: #10b981;
    border-color: #d1fae5;
}

.qty-btn.plus:hover {
    background: #f0fdf4;
    border-color: #10b981;
}

.qty-input {
    width: 60px;
    text-align: center;
    padding: 0.5rem;
    border: 2px solid #cbd5e1;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: #1e293b;
}

.qty-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Highlight row on search */
.highlight-row {
    background-color: #fef3c7 !important;
    animation: pulse-highlight 1.5s infinite;
}

@keyframes pulse-highlight {
    0%, 100% {
        background-color: #fef3c7;
    }
    50% {
        background-color: #fde68a;
    }
}

.text-muted {
    color: #6c757d;
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

.view-section-product {
    display: flex;
    gap: 20px;
}

.view-image-container {
    flex-shrink: 0;
    width: 200px;
    height: 200px;
    border-radius: 12px;
    overflow: hidden;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #e2e8f0;
}

.view-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.view-details-product {
    flex: 1;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
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

/* Search Suggestions */
.search-suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    margin-top: 0.25rem;
    max-height: 300px;
    overflow-y: auto;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    z-index: 100;
}

.suggestion-item {
    padding: 0.75rem 1rem;
    cursor: pointer;
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.2s;
}

.suggestion-item:hover {
    background: #f8fafc;
}

.suggestion-item:last-child {
    border-bottom: none;
}

.suggestion-highlight {
    font-weight: 600;
    color: #667eea;
}

.suggestion-meta {
    font-size: 0.8125rem;
    color: #64748b;
    margin-top: 0.25rem;
}

.review-note {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.1) 100%);
    border: 1px solid #3b82f6;
    border-radius: 0.75rem;
    padding: 1rem;
    display: flex;
    gap: 1rem;
}

.note-icon {
    flex-shrink: 0;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #3b82f6;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.note-content {
    flex: 1;
}

.note-content strong {
    display: block;
    color: #1e293b;
    margin-bottom: 0.25rem;
    font-size: 0.9375rem;
}

@media (max-width: 768px) {
    .view-section-product {
        flex-direction: column;
    }
    .view-details-product {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// All products data
const allProducts = @json($products);
let currentProducts = [];
let productQuantities = {};

// Open/Close modal functions
function openStockModal() {
    document.getElementById('stockModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeStockModal() {
    document.getElementById('stockModal').classList.remove('active');
    document.body.style.overflow = '';
    document.getElementById('stockForm').reset();
    document.getElementById('productsTableBody').innerHTML = '';
    document.getElementById('products_table_container').style.display = 'none';
    document.getElementById('empty_state').style.display = 'block';
    document.getElementById('reference_search').value = '';
    productQuantities = {};
    currentProducts = [];
    updateSaveButton();
}

document.getElementById('stockModal').addEventListener('click', function(e) {
    if (e.target === this) { closeStockModal(); }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && document.getElementById('stockModal').classList.contains('active')) { 
        closeStockModal(); 
    }
});

// When supplier is selected, load their products
document.getElementById('supplier_id').addEventListener('change', function() {
    const supplierId = this.value;
    
    if (!supplierId) {
        document.getElementById('products_table_container').style.display = 'none';
        document.getElementById('empty_state').style.display = 'block';
        currentProducts = [];
        productQuantities = {};
        return;
    }

    // Filter products by supplier
    currentProducts = allProducts.filter(p => p.supplier_id == supplierId);
    
    if (currentProducts.length === 0) {
        document.getElementById('productsTableBody').innerHTML = '<tr><td colspan="9" style="text-align: center; padding: 2rem; color: #94a3b8;"><i class="fas fa-inbox me-2"></i>No products found for this supplier</td></tr>';
        document.getElementById('products_table_container').style.display = 'block';
        document.getElementById('empty_state').style.display = 'none';
        return;
    }

    renderProductsTable();
    document.getElementById('products_table_container').style.display = 'block';
    document.getElementById('empty_state').style.display = 'none';
});

// Render products table
function renderProductsTable() {
    const tbody = document.getElementById('productsTableBody');
    tbody.innerHTML = '';

    currentProducts.forEach(product => {
        const currentStock = product.inventory ? product.inventory.quantity_on_hand : 0;
        const qty = productQuantities[product.product_id] || 0;
        
        const tr = document.createElement('tr');
        tr.setAttribute('data-product-id', product.product_id);
        tr.setAttribute('data-serial', product.serial_number || '');
        tr.innerHTML = `
            <td class="supplier-name">${product.product_name}</td>
            <td>${product.category ? product.category.category_name : 'N/A'}</td>
            <td>${product.brand || '-'}</td>
            <td>${product.size || '-'}</td>
            <td>₱${parseFloat(product.base_price || 0).toFixed(2)}</td>
            <td>₱${parseFloat(product.selling_price || 0).toFixed(2)}</td>
            <td><code>${product.serial_number || 'N/A'}</code></td>
            <td><span class="stock-badge">${currentStock}</span></td>
            <td>
                <div class="quantity-controls">
                    <button type="button" class="qty-btn minus" onclick="adjustQuantity(${product.product_id}, -1)">
                        <i class="fas fa-minus"></i>
                    </button>
                    <input type="number" class="qty-input" value="${qty}" min="0" 
                           onchange="setQuantity(${product.product_id}, this.value)" readonly>
                    <button type="button" class="qty-btn plus" onclick="adjustQuantity(${product.product_id}, 1)">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

// Adjust quantity with +/- buttons
window.adjustQuantity = function(productId, delta) {
    const currentQty = productQuantities[productId] || 0;
    const newQty = Math.max(0, currentQty + delta);
    productQuantities[productId] = newQty;
    
    // Update the input field
    const row = document.querySelector(`tr[data-product-id="${productId}"]`);
    if (row) {
        const input = row.querySelector('.qty-input');
        input.value = newQty;
    }
    
    updateSaveButton();
};

// Set quantity directly
window.setQuantity = function(productId, value) {
    const qty = Math.max(0, parseInt(value) || 0);
    productQuantities[productId] = qty;
    updateSaveButton();
};

// Update save button state
function updateSaveButton() {
    const hasQuantity = Object.values(productQuantities).some(qty => qty > 0);
    document.getElementById('saveStockBtn').disabled = !hasQuantity;
}

// Live search by reference number
document.getElementById('reference_search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase().trim();
    
    // Remove all highlights first
    document.querySelectorAll('.highlight-row').forEach(row => {
        row.classList.remove('highlight-row');
    });
    
    if (!searchTerm) return;
    
    // Find and highlight matching rows
    const rows = document.querySelectorAll('#productsTableBody tr');
    rows.forEach(row => {
        const serial = row.getAttribute('data-serial')?.toLowerCase() || '';
        if (serial.includes(searchTerm)) {
            row.classList.add('highlight-row');
            // Scroll to first match
            if (!document.querySelector('.highlight-row[data-scrolled]')) {
                row.setAttribute('data-scrolled', 'true');
                row.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
});

// Form submission
document.getElementById('stockForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Prepare stock data
    const stockData = [];
    
    for (const [productId, quantity] of Object.entries(productQuantities)) {
        if (quantity > 0) {
            const product = allProducts.find(p => p.product_id == productId);
            if (product) {
                stockData.push({
                    product_id: productId,
                    product_name: product.product_name,
                    category_id: product.category_id,
                    supplier_id: product.supplier_id,
                    brand: product.brand,
                    size: product.size,
                    base_price: product.base_price,
                    selling_price: product.selling_price,
                    serial_number: product.serial_number,
                    quantity: quantity
                });
            }
        }
    }
    
    if (stockData.length === 0) {
        alert('Please add quantity to at least one product.');
        return false;
    }
    
    // Set hidden field with stock data
    document.getElementById('stock_data').value = JSON.stringify(stockData);
    
    // Submit form
    this.submit();
});

// ========== VIEW INVENTORY ==========
function viewInventory(id) {
    fetch(`/admin/inventory/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('view_inventory_id').textContent = '#INV' + String(data.inventory_id).padStart(3, '0');
            document.getElementById('view_product_name').textContent = data.product.product_name;
            document.getElementById('view_category').textContent = data.product.category ? data.product.category.category_name : 'N/A';
            document.getElementById('view_supplier').textContent = data.product.supplier ? data.product.supplier.company_name : 'N/A';
            document.getElementById('view_brand').textContent = data.product.brand || 'N/A';
            document.getElementById('view_size').textContent = data.product.size || 'N/A';
            document.getElementById('view_quantity').textContent = data.quantity_on_hand;
            document.getElementById('view_last_updated').textContent = new Date(data.last_updated).toLocaleDateString('en-US', {year: 'numeric', month: 'long', day: 'numeric'});
            
            // Set image
            const imageContainer = document.getElementById('viewInventoryImage');
            if (data.product.image) {
                imageContainer.innerHTML = `<img src="/${data.product.image}" alt="${data.product.product_name}">`;
            } else {
                imageContainer.innerHTML = `<i class="fas fa-image" style="font-size: 48px; color: #cbd5e1;"></i>`;
            }
            
            window.currentInventoryData = data;
            document.getElementById('viewInventoryModal').style.display = 'flex';
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error loading inventory details', 'error');
        });
}

function closeViewInventoryModal() {
    document.getElementById('viewInventoryModal').style.display = 'none';
}

// ========== EDIT INVENTORY ==========
function editInventory(id) {
    fetch(`/admin/inventory/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editInventoryModal').style.display = 'flex';
            
            document.getElementById('editInventoryForm').action = `/admin/inventory/${id}`;
            document.getElementById('edit_inventory_id').value = data.inventory_id;
            document.getElementById('edit_product_name_display').value = data.product.product_name;
            document.getElementById('edit_current_stock').value = data.quantity_on_hand;
            document.getElementById('edit_quantity_on_hand').value = data.quantity_on_hand;
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error loading inventory for editing', 'error');
        });
}

function closeEditInventoryModal() {
    document.getElementById('editInventoryModal').style.display = 'none';
    document.getElementById('editInventoryForm').reset();
}

function editFromViewInventory() {
    closeViewInventoryModal();
    if (window.currentInventoryData) {
        editInventory(window.currentInventoryData.inventory_id);
    }
}

// ========== DELETE INVENTORY ==========
function deleteInventory(id) {
    if (confirm('⚠️ Are you sure you want to delete this inventory record?\n\nThis action cannot be undone!')) {
        fetch(`/admin/inventory/${id}`, {
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
                showToast('Inventory deleted successfully', 'success');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showToast('Error deleting inventory', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error deleting inventory', 'error');
        });
    }
}

// ========== SEARCH WITH SUGGESTIONS ==========
const allInventories = @json($inventories->items());

document.getElementById('inventorySearchInput').addEventListener('input', function(e) {
    const searchValue = e.target.value.trim().toLowerCase();
    const suggestionsDiv = document.getElementById('inventorySearchSuggestions');
    
    if (searchValue.length >= 2) {
        const matches = allInventories.filter(inv => {
            const productName = (inv.product?.product_name || '').toLowerCase();
            const brand = (inv.product?.brand || '').toLowerCase();
            const serial = (inv.product?.serial_number || '').toLowerCase();
            return productName.includes(searchValue) || brand.includes(searchValue) || serial.includes(searchValue);
        });
        
        displayInventorySuggestions(matches, searchValue);
    } else {
        suggestionsDiv.style.display = 'none';
    }
});

function displayInventorySuggestions(matches, searchTerm) {
    const suggestionsDiv = document.getElementById('inventorySearchSuggestions');
    
    if (matches.length === 0) {
        suggestionsDiv.innerHTML = '<div class="suggestion-item" style="cursor: default;">No matches found</div>';
        suggestionsDiv.style.display = 'block';
        return;
    }
    
    const html = matches.slice(0, 5).map(inv => {
        const productName = inv.product?.product_name || '';
        const brand = inv.product?.brand || '';
        const qty = inv.quantity_on_hand;
        const highlightedName = productName.replace(new RegExp(searchTerm, 'gi'), match => `<span class="suggestion-highlight">${match}</span>`);
        
        return `
            <div class="suggestion-item" onclick="selectInventorySuggestion('${productName}')">
                <div><strong>${highlightedName}</strong></div>
                <div class="suggestion-meta">${brand} • Stock: ${qty}</div>
            </div>
        `;
    }).join('');
    
    suggestionsDiv.innerHTML = html;
    suggestionsDiv.style.display = 'block';
}

function selectInventorySuggestion(productName) {
    document.getElementById('inventorySearchInput').value = productName;
    document.getElementById('inventorySearchSuggestions').style.display = 'none';
    performInventorySearch(productName);
}

function performInventorySearch(search) {
    const url = new URL(window.location.href);
    url.searchParams.set('search', search);
    window.location.href = url.toString();
}

// Close suggestions when clicking outside
document.addEventListener('click', function(e) {
    const searchInput = document.getElementById('inventorySearchInput');
    const suggestionsDiv = document.getElementById('inventorySearchSuggestions');
    if (!searchInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
        suggestionsDiv.style.display = 'none';
    }
});

// Status filter
document.getElementById('statusFilter').addEventListener('change', function() {
    const url = new URL(window.location.href);
    url.searchParams.set('status', this.value);
    window.location.href = url.toString();
});

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
document.getElementById('viewInventoryModal').addEventListener('click', function(e) {
    if (e.target === this) closeViewInventoryModal();
});

document.getElementById('editInventoryModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditInventoryModal();
});
</script>
@endsection
