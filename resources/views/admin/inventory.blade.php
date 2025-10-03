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
                            <button class="btn-icon btn-edit" title="Update Stock">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon btn-view" title="View History">
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
                Showing <strong>{{ $inventories->total() }}</strong> items
            </div>
            <div class="pagination">
                {{ $inventories->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Stock Add Modal -->
<div class="modal-overlay" id="stockModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add Stock</h2>
            <p class="required-text">
                Fields marked with an asterisk <span class="asterisk">(*)</span> are required.
            </p>
        </div>

        <form id="stockForm" method="POST" action="{{ route('admin.inventory.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-grid">
                    <!-- Product Search/Input Field -->
                    <div class="form-group full-width">
                        <label class="form-label">Product Name <span class="required">*</span></label>
                        <div class="input-with-icon">
                            <i class="fas fa-search input-icon"></i>
                            <select name="product_id" id="product_id" class="form-select" required>
                                <option value="">Select product...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Auto-fill fields (existing product data) -->
                    <div class="form-group">
                        <label class="form-label">Product Category <span class="required">*</span></label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Supplier Company Name <span class="required">*</span></label>
                        <select name="supplier_id" id="supplier_id" class="form-select" required>
                            <option value="">Select supplier</option>
                            @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->supplier_id }}">{{ $supplier->company_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Other product details input -->
                    <div class="form-group">
                        <label class="form-label">Brand</label>
                        <input type="text" name="brand" id="brand" class="form-input" placeholder="Enter brand name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Size</label>
                        <input type="text" name="size" id="size" class="form-input" placeholder="Enter size">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Length</label>
                        <input type="text" name="length" id="length" class="form-input" placeholder="Enter length">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Width</label>
                        <input type="text" name="width" id="width" class="form-input" placeholder="Enter width">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Base Price <span class="required">*</span></label>
                        <input type="number" name="base_price" id="base_price" class="form-input" placeholder="Enter base price" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Selling Price <span class="required">*</span></label>
                        <input type="number" name="selling_price" id="selling_price" class="form-input" placeholder="Enter selling price" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Serial Number</label>
                        <input type="text" name="serial_number" id="serial_number" class="form-input" placeholder="XXXXXXXXX">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Quantity <span class="required">*</span>
                            <i class="fas fa-info-circle info-icon" title="Amount to add"></i>
                        </label>
                        <select name="quantity" id="quantity" class="form-select" required>
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
                        <label class="form-label">Date <span class="required">*</span></label>
                        <input type="date" name="date" id="date" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status <span class="required">*</span></label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="In Stock">In Stock</option>
                            <option value="Low Stock">Low Stock</option>
                            <option value="Out of Stock">Out of Stock</option>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label">Product Description</label>
                        <textarea name="description" id="description" class="form-textarea" placeholder="Enter product description (optional)"></textarea>
                    </div>
                </div>

                <!-- Button to preview the entered data -->
                <div style="margin: 1rem 0;">
                    <button type="button" id="previewBtn" class="btn-save" style="background:#1e3a8a;">Preview Data</button>
                </div>

                <!-- Preview Table -->
                <div class="table-responsive" style="margin-top:1rem;">
                    <table class="supplier-table" id="previewTable">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Supplier</th>
                                <th>Brand</th>
                                <th>Size</th>
                                <th>Length</th>
                                <th>Width</th>
                                <th>Base Price</th>
                                <th>Selling Price</th>
                                <th>Serial Number</th>
                                <th>Quantity</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Preview rows will be appended here -->
                        </tbody>
                    </table>
                </div>


            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeStockModal()">Cancel</button>
                <button type="submit" class="btn-save">Save Stock</button>
            </div>
            <input type="hidden" name="preview_rows" id="preview_rows">
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
// Open/Close modal functions (existing)
function openStockModal() {
    document.getElementById('stockModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeStockModal() {
    document.getElementById('stockModal').classList.remove('active');
    document.body.style.overflow = '';
    document.getElementById('stockForm').reset();
    document.querySelector("#previewTable tbody").innerHTML = '';
    previewRows = [];
}
document.getElementById('stockModal').addEventListener('click', function(e) {
    if (e.target === this) { closeStockModal(); }
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closeStockModal(); }
});

// Auto-fill fields when a product is selected
document.getElementById('product_id').addEventListener('change', function() {
    var productId = this.value;
    if (!productId) return;

    var products = @json($products);
    var product = products.find(p => p.product_id == productId);

    if (product) {
        document.getElementById('category_id').value = product.category_id || '';
        document.getElementById('supplier_id').value = product.supplier_id || '';
        document.getElementById('brand').value = product.brand || '';
        document.getElementById('size').value = product.size || '';
        document.getElementById('length').value = product.length || '';
        document.getElementById('width').value = product.width || '';
        document.getElementById('base_price').value = product.base_price || '';
        document.getElementById('selling_price').value = product.selling_price || '';
        document.getElementById('serial_number').value = product.serial_number || '';
        document.getElementById('description').value = product.description || '';
    } else {
        document.getElementById('category_id').value = '';
        document.getElementById('supplier_id').value = '';
        document.getElementById('brand').value = '';
        document.getElementById('size').value = '';
        document.getElementById('length').value = '';
        document.getElementById('width').value = '';
        document.getElementById('base_price').value = '';
        document.getElementById('selling_price').value = '';
        document.getElementById('serial_number').value = '';
        document.getElementById('description').value = '';
    }
});

// Store preview rows in an array
let previewRows = [];

// Add product to preview table (multi-row support)
document.getElementById('previewBtn').addEventListener('click', function(){
    var productSelect = document.getElementById('product_id');
    var productId = productSelect.value;
    var productName = productSelect.options[productSelect.selectedIndex].text;

    if (!productId) {
        alert('Please select a product.');
        return;
    }

    var categorySelect = document.getElementById('category_id');
    var categoryText = categorySelect.options[categorySelect.selectedIndex].text;
    var supplierSelect = document.getElementById('supplier_id');
    var supplierText = supplierSelect.options[supplierSelect.selectedIndex].text;
    var brand = document.getElementById('brand').value;
    var size = document.getElementById('size').value;
    var length = document.getElementById('length').value;
    var width = document.getElementById('width').value;
    var basePrice = document.getElementById('base_price').value;
    var sellingPrice = document.getElementById('selling_price').value;
    var serialNumber = document.getElementById('serial_number').value;
    var quantity = document.getElementById('quantity').value;
    var description = document.getElementById('description').value;

    // Validate required fields
    if (!categorySelect.value || !supplierSelect.value || !basePrice || !sellingPrice || !quantity) {
        alert('Please fill all required fields.');
        return;
    }

    // Add to previewRows array
    previewRows.push({
        productId, productName, categoryText, supplierText, brand, size, length, width,
        basePrice, sellingPrice, serialNumber, quantity, description
    });

    renderPreviewTable();
    // Optionally, reset fields for next entry
    document.getElementById('stockForm').reset();
});

// Render preview table with all rows
function renderPreviewTable() {
    var tbody = document.querySelector("#previewTable tbody");
    tbody.innerHTML = '';
    previewRows.forEach(function(row, idx){
        var tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${row.productName}</td>
            <td>${row.categoryText}</td>
            <td>${row.supplierText}</td>
            <td>${row.brand}</td>
            <td>${row.size}</td>
            <td>${row.length}</td>
            <td>${row.width}</td>
            <td>₱${parseFloat(row.basePrice || 0).toFixed(2)}</td>
            <td>₱${parseFloat(row.sellingPrice || 0).toFixed(2)}</td>
            <td>${row.serialNumber}</td>
            <td>${row.quantity}</td>
            <td>${row.description}</td>
            <td><button type="button" class="btn-cancel" onclick="removePreviewRow(${idx})">Remove</button></td>
        `;
        tbody.appendChild(tr);
    });
}

// Remove a row from preview
window.removePreviewRow = function(idx) {
    previewRows.splice(idx, 1);
    renderPreviewTable();
};

document.getElementById('stockForm').addEventListener('submit', function(e) {
    // Only allow submit if there is at least one preview row
    if (previewRows.length === 0) {
        alert('Please add at least one product to preview before saving.');
        e.preventDefault();
        return false;
    }
    document.getElementById('preview_rows').value = JSON.stringify(previewRows);
});
</script>
@endsection
