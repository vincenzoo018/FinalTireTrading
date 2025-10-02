@extends('layouts.admin.app')

@section('title', 'Stock Adjustments')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Stock Adjustments</h1>
        <button class="btn-add-supplier" onclick="openAdjustmentModal()">
            <i class="fas fa-plus"></i>
            Create Adjustment
        </button>
    </div>

    <div class="content-card">
        <div class="table-controls">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search by product or reason..." id="searchInput">
            </div>

            <div class="filter-wrapper">
                <select class="btn-filter" id="adjustmentTypeFilter" style="padding-right: 2.5rem;">
                    <option value="">All Types</option>
                    <option value="addition">Addition</option>
                    <option value="subtraction">Subtraction</option>
                    <option value="damage">Damage</option>
                    <option value="return">Return</option>
                    <option value="correction">Correction</option>
                </select>
                <button class="btn-filter" onclick="toggleDateFilter()">
                    <i class="fas fa-calendar"></i>
                    Date Range
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>

        <!-- Date Range Filter Panel -->
        <div id="dateFilterPanel" style="display: none; padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; align-items: end;">
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">FROM DATE</label>
                    <input type="date" id="dateFrom" class="search-input" style="width: 100%;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">TO DATE</label>
                    <input type="date" id="dateTo" class="search-input" style="width: 100%;">
                </div>
                <div>
                    <button onclick="applyDateFilter()" class="btn-filter" style="width: 100%; justify-content: center;">
                        <i class="fas fa-filter"></i>
                        Apply Filter
                    </button>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="supplier-table">
                <thead>
                    <tr>
                        <th><input type="checkbox" class="checkbox-all"></th>
                        <th class="sortable">ID <i class="fas fa-sort"></i></th>
                        <th class="sortable">Product Name <i class="fas fa-sort"></i></th>
                        <th>Adjustment Type</th>
                        <th>Quantity</th>
                        <th>Previous Stock</th>
                        <th>New Stock</th>
                        <th>Reason</th>
                        <th>Adjusted By</th>
                        <th class="sortable">Date <i class="fas fa-sort"></i></th>
                        <th class="actions-header">Actions <i class="fas fa-info-circle tooltip-icon"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample Data Row 1 -->
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">1</td>
                        <td class="supplier-name">L'Oréal Professional Shampoo</td>
                        <td>
                            <span class="payment-badge" style="background: #d1fae5; color: #065f46;">Addition</span>
                        </td>
                        <td><span style="font-weight: 600; color: #059669;">+25</span></td>
                        <td><span class="stock-badge stock-medium">48</span></td>
                        <td><span class="stock-badge stock-high">73</span></td>
                        <td><span style="font-size: 0.8125rem; color: #64748b;" title="Restocking from supplier">Restocking from supplier</span></td>
                        <td><span style="font-size: 0.8125rem; color: #475569;">Admin User</span></td>
                        <td><span class="time-badge">Oct 02, 2025</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Sample Data Row 2 -->
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">2</td>
                        <td class="supplier-name">Kerastase Hair Mask</td>
                        <td>
                            <span class="payment-badge" style="background: #fee2e2; color: #991b1b;">Subtraction</span>
                        </td>
                        <td><span style="font-weight: 600; color: #dc2626;">-5</span></td>
                        <td><span class="stock-badge stock-medium">15</span></td>
                        <td><span class="stock-badge stock-low">10</span></td>
                        <td><span style="font-size: 0.8125rem; color: #64748b;" title="Sold during flash sale">Sold during flash sale</span></td>
                        <td><span style="font-size: 0.8125rem; color: #475569;">Staff Member</span></td>
                        <td><span class="time-badge">Oct 01, 2025</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Sample Data Row 3 -->
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">3</td>
                        <td class="supplier-name">OPI Nail Polish</td>
                        <td>
                            <span class="payment-badge" style="background: #fed7aa; color: #9a3412;">Damage</span>
                        </td>
                        <td><span style="font-weight: 600; color: #dc2626;">-3</span></td>
                        <td><span class="stock-badge stock-high">72</span></td>
                        <td><span class="stock-badge stock-high">69</span></td>
                        <td><span style="font-size: 0.8125rem; color: #64748b;" title="Broken during handling">Broken during handling</span></td>
                        <td><span style="font-size: 0.8125rem; color: #475569;">Manager</span></td>
                        <td><span class="time-badge">Sep 30, 2025</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Sample Data Row 4 -->
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">4</td>
                        <td class="supplier-name">Cetaphil Gentle Cleanser</td>
                        <td>
                            <span class="payment-badge" style="background: #e0e7ff; color: #3730a3;">Return</span>
                        </td>
                        <td><span style="font-weight: 600; color: #059669;">+2</span></td>
                        <td><span class="stock-badge stock-low">8</span></td>
                        <td><span class="stock-badge stock-medium">10</span></td>
                        <td><span style="font-size: 0.8125rem; color: #64748b;" title="Customer return - unopened">Customer return - unopened</span></td>
                        <td><span style="font-size: 0.8125rem; color: #475569;">Staff Member</span></td>
                        <td><span class="time-badge">Sep 29, 2025</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Sample Data Row 5 -->
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">5</td>
                        <td class="supplier-name">Revlon ColorStay Foundation</td>
                        <td>
                            <span class="payment-badge" style="background: #fef3c7; color: #92400e;">Correction</span>
                        </td>
                        <td><span style="font-weight: 600; color: #dc2626;">-2</span></td>
                        <td><span class="stock-badge stock-medium">22</span></td>
                        <td><span class="stock-badge stock-medium">20</span></td>
                        <td><span style="font-size: 0.8125rem; color: #64748b;" title="Physical count discrepancy">Physical count discrepancy</span></td>
                        <td><span style="font-size: 0.8125rem; color: #475569;">Manager</span></td>
                        <td><span class="time-badge">Sep 28, 2025</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Sample Data Row 6 -->
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">6</td>
                        <td class="supplier-name">Wella Koleston Hair Color</td>
                        <td>
                            <span class="payment-badge" style="background: #d1fae5; color: #065f46;">Addition</span>
                        </td>
                        <td><span style="font-weight: 600; color: #059669;">+50</span></td>
                        <td><span class="stock-badge stock-high">56</span></td>
                        <td><span class="stock-badge stock-high">106</span></td>
                        <td><span style="font-size: 0.8125rem; color: #64748b;" title="New stock delivery">New stock delivery</span></td>
                        <td><span style="font-size: 0.8125rem; color: #475569;">Admin User</span></td>
                        <td><span class="time-badge">Sep 27, 2025</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Sample Data Row 7 -->
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">7</td>
                        <td class="supplier-name">Bioderma Micellar Water</td>
                        <td>
                            <span class="payment-badge" style="background: #fee2e2; color: #991b1b;">Subtraction</span>
                        </td>
                        <td><span style="font-weight: 600; color: #dc2626;">-8</span></td>
                        <td><span class="stock-badge stock-medium">18</span></td>
                        <td><span class="stock-badge stock-medium">10</span></td>
                        <td><span style="font-size: 0.8125rem; color: #64748b;" title="Promotional giveaway">Promotional giveaway</span></td>
                        <td><span style="font-size: 0.8125rem; color: #475569;">Manager</span></td>
                        <td><span class="time-badge">Sep 26, 2025</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Sample Data Row 8 -->
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">8</td>
                        <td class="supplier-name">Maybelline Mascara</td>
                        <td>
                            <span class="payment-badge" style="background: #fed7aa; color: #9a3412;">Damage</span>
                        </td>
                        <td><span style="font-weight: 600; color: #dc2626;">-12</span></td>
                        <td><span class="stock-badge stock-medium">12</span></td>
                        <td><span class="stock-badge stock-out">0</span></td>
                        <td><span style="font-size: 0.8125rem; color: #64748b;" title="Expired products">Expired products</span></td>
                        <td><span style="font-size: 0.8125rem; color: #475569;">Staff Member</span></td>
                        <td><span class="time-badge">Sep 25, 2025</span></td>
                        <td class="actions-cell">
                            <button class="btn-icon btn-view" title="View Details">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="showing-info">
                Showing <strong>1-8</strong> of <strong>156</strong>
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

<!-- Create Stock Adjustment Modal -->
<div class="modal-overlay" id="adjustmentModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Stock Adjustment Information</h2>
            <p class="required-text">Fields marked with an asterisk <span class="asterisk">(*)</span> are required.</p>
        </div>

        <form id="adjustmentForm">
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            Product Name <span class="required">*</span>
                        </label>
                        <select class="form-select" id="productSelect" required>
                            <option value="">Select product</option>
                            <option value="1" data-stock="48">L'Oréal Professional Shampoo (Stock: 48)</option>
                            <option value="2" data-stock="15">Kerastase Hair Mask (Stock: 15)</option>
                            <option value="3" data-stock="72">OPI Nail Polish (Stock: 72)</option>
                            <option value="4" data-stock="8">Cetaphil Gentle Cleanser (Stock: 8)</option>
                            <option value="5" data-stock="22">Revlon ColorStay Foundation (Stock: 22)</option>
                            <option value="6" data-stock="56">Wella Koleston Hair Color (Stock: 56)</option>
                            <option value="7" data-stock="18">Bioderma Micellar Water (Stock: 18)</option>
                            <option value="8" data-stock="0">Maybelline Mascara (Stock: 0)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Adjustment Type <span class="required">*</span>
                        </label>
                        <select class="form-select" id="adjustmentType" required>
                            <option value="">Select type</option>
                            <option value="addition">Addition</option>
                            <option value="subtraction">Subtraction</option>
                            <option value="damage">Damage</option>
                            <option value="return">Return</option>
                            <option value="correction">Correction</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Physical Count <span class="required">*</span>
                            <i class="fas fa-info-circle info-icon" title="Enter the quantity to adjust"></i>
                        </label>
                        <input type="number" class="form-input" id="quantity" placeholder="Enter quantity" min="1" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Current Stock
                            <i class="fas fa-info-circle info-icon" title="Current stock level"></i>
                        </label>
                        <input type="text" class="form-input" id="currentStock" placeholder="--" readonly style="background: #f1f5f9;">
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">
                            Reason <span class="required">*</span>
                        </label>
                        <textarea class="form-textarea" id="reason" placeholder="Enter reason for adjustment" required></textarea>
                        <small style="color: #64748b; font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                            Example: "While performing a physical stock count, I found additional units of this product that were not previously recorded. To make sure the system reflects the actual number of items on hand, I am adding them into inventory."
                        </small>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeAdjustmentModal()">Cancel</button>
                <button type="submit" class="btn-save">Submit Stock Adjustment</button>
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

.required-text {
    color: #64748b;
}

.asterisk {
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
    
    #dateFilterPanel > div {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Open modal
function openAdjustmentModal() {
    document.getElementById('adjustmentModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

// Close modal
function closeAdjustmentModal() {
    document.getElementById('adjustmentModal').classList.remove('active');
    document.body.style.overflow = '';
    document.getElementById('adjustmentForm').reset();
    document.getElementById('currentStock').value = '';
}

// Close modal when clicking outside
document.getElementById('adjustmentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAdjustmentModal();
    }
});

// Update current stock when product is selected
document.getElementById('productSelect').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const stock = selectedOption.getAttribute('data-stock');
    document.getElementById('currentStock').value = stock ? stock : '--';
});

// Handle form submission
document.getElementById('adjustmentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form values
    const productId = document.getElementById('productSelect').value;
    const adjustmentType = document.getElementById('adjustmentType').value;
    const quantity = document.getElementById('quantity').value;
    const reason = document.getElementById('reason').value;
    
    // Validate
    if (!productId || !adjustmentType || !quantity || !reason) {
        alert('Please fill in all required fields');
        return;
    }
    
    // Here you would typically send this to your backend
    console.log({
        product_id: productId,
        adjustment_type: adjustmentType,
        quantity: quantity,
        reason: reason
    });
    
    alert('Stock adjustment submitted successfully!');
    closeAdjustmentModal();
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAdjustmentModal();
    }
});

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('.supplier-table tbody tr');
    
    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Adjustment type filter
document.getElementById('adjustmentTypeFilter').addEventListener('change', function() {
    const filterValue = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('.supplier-table tbody tr');
    
    tableRows.forEach(row => {
        if (!filterValue) {
            row.style.display = '';
        } else {
            const typeCell = row.cells[3];
            const type = typeCell ? typeCell.textContent.toLowerCase() : '';
            row.style.display = type.includes(filterValue) ? '' : 'none';
        }
    });
});

// Toggle date filter panel
function toggleDateFilter() {
    const panel = document.getElementById('dateFilterPanel');
    panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
}

// Apply date filter
function applyDateFilter() {
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    
    if (!dateFrom && !dateTo) {
        alert('Please select at least one date');
        return;
    }
    
    // Here you would typically send this to your backend for filtering
    console.log('Filtering from:', dateFrom, 'to:', dateTo);
    alert('Date filter applied: ' + dateFrom + ' to ' + dateTo);
}

// Select all checkboxes
document.querySelector('.checkbox-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
});
</script>
@endsection