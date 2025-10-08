@extends('layouts.admin.app')

@section('title', 'Product List')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Product List</h1>
        <button class="btn-add-supplier" onclick="openProductModal()">
            <i class="fas fa-plus"></i>
            Add Product
        </button>
    </div>

    <div class="content-card">
        <div class="table-controls">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="productSearchInput" class="search-input" placeholder="Search products...">
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
                        <th>Image</th>
                        <th class="sortable">
                            Product Name
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Supplier Name
                            <i class="fas fa-sort"></i>
                        </th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Base Price</th>
                        <th>Selling Price</th>
                        <th>Status</th>
                        <th class="actions-header">
                            Actions
                            <i class="fas fa-info-circle tooltip-icon"></i>
                        </th>
                    </tr>
                </thead>
                <tbody id="productsTableBody">
                @forelse($products as $product)
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td>{{ $product->product_id }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" alt="Product Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                            @else
                                <img src="{{ asset('images/default-product.png') }}" alt="Default Product Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                            @endif
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->supplier ? $product->supplier->company_name : 'N/A' }}</td>
                        <td>{{ $product->category ? $product->category->category_name : 'N/A' }}</td>
                        <td>{{ $product->brand }}</td>
                        <td>₱{{ number_format($product->base_price, 2) }}</td>
                        <td>₱{{ number_format($product->selling_price, 2) }}</td>
                        <td><span class="payment-badge status-active">Active</span></td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <button class="btn-action btn-view" title="View Product" 
                                        onclick="viewProduct({{ $product->product_id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action btn-edit" title="Edit Product" 
                                        onclick="editProduct({{ $product->product_id }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete-action" title="Delete Product" 
                                        onclick="deleteProduct({{ $product->product_id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">No products found.</td>
                    </tr>
                @endforelse

                {{-- Display all images from public/images --}}
                @php
                    $imageFiles = [];
                    $imagesPath = public_path('public/images');
                    if (file_exists($imagesPath)) {
                        $imageFiles = array_values(array_filter(scandir($imagesPath), function($file) use ($imagesPath) {
                            return is_file($imagesPath . DIRECTORY_SEPARATOR . $file) &&
                                preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
                        }));
                    }
                @endphp
                @foreach($imageFiles as $img)
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <img src="{{ asset('images/' . $img) }}" alt="{{ $img }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                        </td>
                        <td colspan="8"><span class="text-muted">Image: {{ $img }}</span></td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="showing-info">
                Showing <strong>1-10</strong> of <strong>156</strong>
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

<!-- View Product Modal -->
<div id="viewProductModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 800px;">
        <div class="modal-header-view">
            <h2><i class="fas fa-eye"></i> Product Details</h2>
            <button class="modal-close-btn" onclick="closeViewProductModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body-view">
            <div class="view-section-product">
                <div class="view-image-container" id="viewProductImage">
                    <!-- Image will be inserted here -->
                </div>
                <div class="view-details-product">
                    <div class="detail-row">
                        <span class="detail-label">Product ID:</span>
                        <span class="detail-value" id="view_product_id"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Product Name:</span>
                        <span class="detail-value" id="view_product_name"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Category:</span>
                        <span class="detail-value" id="view_product_category"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Supplier:</span>
                        <span class="detail-value" id="view_product_supplier"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Brand:</span>
                        <span class="detail-value" id="view_product_brand"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Size:</span>
                        <span class="detail-value" id="view_product_size"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Base Price:</span>
                        <span class="detail-value" id="view_product_base_price"></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Selling Price:</span>
                        <span class="detail-value" id="view_product_selling_price"></span>
                    </div>
                    <div class="detail-row full-width">
                        <span class="detail-label">Description:</span>
                        <span class="detail-value" id="view_product_description"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="closeViewProductModal()" class="btn-cancel">Close</button>
            <button type="button" onclick="editFromViewProduct()" class="btn-save">
                <i class="fas fa-edit"></i> Edit Product
            </button>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div id="editProductModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-edit"></i> Edit Product</h2>
            <p class="required-text">Fields marked with an asterisk <span class="asterisk">(*)</span> are required.</p>
        </div>
        <form id="editProductForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_product_id" name="product_id">
            
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Product Name <span class="required">*</span></label>
                        <input type="text" id="edit_product_name" name="product_name" class="form-input" placeholder="Enter product name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Supplier Company <span class="required">*</span></label>
                        <select id="edit_supplier_id" name="supplier_id" class="form-select" required>
                            <option value="">Select supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->supplier_id }}">{{ $supplier->company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category <span class="required">*</span></label>
                        <select id="edit_category_id" name="category_id" class="form-select" required>
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Brand</label>
                        <input type="text" id="edit_brand" name="brand" class="form-input" placeholder="Enter brand name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Size</label>
                        <input type="text" id="edit_size" name="size" class="form-input" placeholder="Enter size">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Length</label>
                        <input type="text" id="edit_length" name="length" class="form-input" placeholder="Enter length">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Width</label>
                        <input type="text" id="edit_width" name="width" class="form-input" placeholder="Enter width">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Base Price <span class="required">*</span></label>
                        <input type="number" id="edit_base_price" name="base_price" class="form-input" placeholder="Enter base price" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Selling Price <span class="required">*</span></label>
                        <input type="number" id="edit_selling_price" name="selling_price" class="form-input" placeholder="Enter selling price" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Serial Number</label>
                        <input type="text" id="edit_serial_number" name="serial_number" class="form-input" placeholder="XXXXXXXXX">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Product Image</label>
                        <div id="currentProductImagePreview" style="margin-bottom: 10px;">
                            <!-- Current image will be shown here -->
                        </div>
                        <input type="file" name="image" class="form-input" accept="image/*" id="editProductImageInput">
                        <div id="editProductImagePreview" style="margin-top:10px;">
                            <!-- New image preview will appear here -->
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label class="form-label">Product Description</label>
                        <textarea id="edit_description" name="description" class="form-textarea" placeholder="Enter product description (optional)"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeEditProductModal()">Cancel</button>
                <button type="submit" class="btn-save">Update Product</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal-overlay" id="productModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add New Product</h2>
            <p class="required-text">Fields marked with an asterisk <span class="asterisk">(*)</span> are required.</p>
        </div>

        <form id="productForm" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            Product Name <span class="required">*</span>
                        </label>
                        <input type="text" name="product_name" class="form-input" placeholder="Enter product name" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Supplier Company <span class="required">*</span>
                        </label>
                        <select name="supplier_id" class="form-select" required>
                            <option value="">Select supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->supplier_id }}">{{ $supplier->company_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Category <span class="required">*</span>
                        </label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Brand
                        </label>
                        <input type="text" name="brand" class="form-input" placeholder="Enter brand name">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Size
                        </label>
                        <input type="text" name="size" class="form-input" placeholder="Enter size">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Length
                        </label>
                        <input type="text" name="length" class="form-input" placeholder="Enter length">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Width
                        </label>
                        <input type="text" name="width" class="form-input" placeholder="Enter width">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Base Price <span class="required">*</span></label>
                        <input type="number" name="base_price" class="form-input" placeholder="Enter base price" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Selling Price <span class="required">*</span></label>
                        <input type="number" name="selling_price" class="form-input" placeholder="Enter selling price" min="0" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Serial Number
                        </label>
                        <input type="text" name="serial_number" class="form-input" placeholder="XXXXXXXXX">
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Product Image
                        </label>
                        <input type="file" name="image" class="form-input" accept="public/image*" id="productImageInput">
                        <div id="imagePreview" style="margin-top:10px;">
                            <!-- Image preview will appear here -->
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">
                            Product Description
                        </label>
                        <textarea name="description" class="form-textarea" placeholder="Enter product description (optional)"></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeProductModal()">Cancel</button>
                <button type="submit" class="btn-save">Save Product</button>
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
// Live Search for Products
document.getElementById('productSearchInput').addEventListener('input', function() {
    var search = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '{{ route("admin.products.index") }}?search=' + encodeURIComponent(search), true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var parser = new DOMParser();
            var doc = parser.parseFromString(xhr.responseText, 'text/html');
            var newTbody = doc.getElementById('productsTableBody');
            if (newTbody) {
                document.getElementById('productsTableBody').innerHTML = newTbody.innerHTML;
            }
        }
    };
    xhr.send();
});

function openProductModal() {
    document.getElementById('productModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeProductModal() {
    document.getElementById('productModal').classList.remove('active');
    document.body.style.overflow = '';
    document.getElementById('productForm').reset();
    document.getElementById('imagePreview').innerHTML = '';
}

// Image preview for product modal
document.addEventListener('DOMContentLoaded', function () {
    var imageInput = document.getElementById('productImageInput');
    if (imageInput) {
        imageInput.addEventListener('change', function(event) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100px';
                    img.style.maxHeight = '100px';
                    img.style.borderRadius = '8px';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});

// Close modal when clicking outside
document.getElementById('productModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeProductModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeProductModal();
        closeViewProductModal();
        closeEditProductModal();
    }
});

// View Product Function
function viewProduct(id) {
    fetch(`/admin/product/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('view_product_id').textContent = '#' + data.product_id;
            document.getElementById('view_product_name').textContent = data.product_name;
            document.getElementById('view_product_category').textContent = data.category ? data.category.category_name : 'N/A';
            document.getElementById('view_product_supplier').textContent = data.supplier ? data.supplier.company_name : 'N/A';
            document.getElementById('view_product_brand').textContent = data.brand || 'N/A';
            document.getElementById('view_product_size').textContent = data.size || 'N/A';
            document.getElementById('view_product_base_price').textContent = '₱' + parseFloat(data.base_price).toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('view_product_selling_price').textContent = '₱' + parseFloat(data.selling_price).toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('view_product_description').textContent = data.description || 'No description available';
            
            // Set image
            const imageContainer = document.getElementById('viewProductImage');
            if (data.image) {
                imageContainer.innerHTML = `<img src="/${data.image}" alt="${data.product_name}">`;
            } else {
                imageContainer.innerHTML = `<i class="fas fa-image" style="font-size: 48px; color: #cbd5e1;"></i>`;
            }
            
            window.currentProductData = data;
            document.getElementById('viewProductModal').style.display = 'flex';
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error loading product details', 'error');
        });
}

function closeViewProductModal() {
    document.getElementById('viewProductModal').style.display = 'none';
}

// Edit Product Function
function editProduct(id) {
    fetch(`/admin/product/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editProductModal').style.display = 'flex';
            
            document.getElementById('editProductForm').action = `/admin/product/${id}`;
            document.getElementById('edit_product_id').value = data.product_id;
            document.getElementById('edit_product_name').value = data.product_name;
            document.getElementById('edit_supplier_id').value = data.supplier_id || '';
            document.getElementById('edit_category_id').value = data.category_id || '';
            document.getElementById('edit_brand').value = data.brand || '';
            document.getElementById('edit_size').value = data.size || '';
            document.getElementById('edit_length').value = data.length || '';
            document.getElementById('edit_width').value = data.width || '';
            document.getElementById('edit_base_price').value = data.base_price;
            document.getElementById('edit_selling_price').value = data.selling_price;
            document.getElementById('edit_serial_number').value = data.serial_number || '';
            document.getElementById('edit_description').value = data.description || '';
            
            // Show current image if exists
            const currentImageDiv = document.getElementById('currentProductImagePreview');
            if (data.image) {
                currentImageDiv.innerHTML = `
                    <div style="margin-bottom: 5px;">
                        <small style="color: #666;">Current Image:</small>
                    </div>
                    <img src="/${data.image}" 
                         style="max-width: 100px; max-height: 100px; border-radius: 8px; border: 2px solid #e5e7eb;">
                `;
            } else {
                currentImageDiv.innerHTML = '<small style="color: #999;">No current image</small>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error loading product for editing', 'error');
        });
}

function closeEditProductModal() {
    document.getElementById('editProductModal').style.display = 'none';
    document.getElementById('editProductForm').reset();
    document.getElementById('currentProductImagePreview').innerHTML = '';
    document.getElementById('editProductImagePreview').innerHTML = '';
}

function editFromViewProduct() {
    closeViewProductModal();
    if (window.currentProductData) {
        editProduct(window.currentProductData.product_id);
    }
}

// Delete Product Function
function deleteProduct(id) {
    if (confirm('⚠️ Are you sure you want to delete this product?\n\nThis action cannot be undone!')) {
        fetch(`/admin/product/${id}`, {
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
                showToast('Product deleted successfully', 'success');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showToast('Error deleting product', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error deleting product', 'error');
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
document.getElementById('viewProductModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeViewProductModal();
    }
});

document.getElementById('editProductModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditProductModal();
    }
});

// Image preview for edit product modal
var editImageInput = document.getElementById('editProductImageInput');
if (editImageInput) {
    editImageInput.addEventListener('change', function(event) {
        const preview = document.getElementById('editProductImagePreview');
        preview.innerHTML = '';
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '100px';
                img.style.maxHeight = '100px';
                img.style.borderRadius = '8px';
                img.style.border = '2px solid #10b981';
                preview.appendChild(img);
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
}
</script>
@endsection
