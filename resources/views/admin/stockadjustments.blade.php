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
                    <option value="increase">Increase</option>
                    <option value="decrease">Decrease</option>
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
                        <th>Status</th>
                        <th class="sortable">Date <i class="fas fa-sort"></i></th>
                        <th class="actions-header">Actions <i class="fas fa-info-circle tooltip-icon"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($adjustments as $adjustment)
                        <tr>
                            <td><input type="checkbox" class="row-checkbox"></td>
                            <td class="supplier-id">{{ $adjustment->stock_adjustment_id }}</td>
                            <td class="supplier-name">{{ $adjustment->stockProd->product->product_name ?? 'N/A' }}</td>
                            <td>
                                @if($adjustment->adjustment_type == 'increase')
                                    <span class="payment-badge" style="background: #d1fae5; color: #065f46;">Increase</span>
                                @else
                                    <span class="payment-badge" style="background: #fee2e2; color: #991b1b;">Decrease</span>
                                @endif
                            </td>
                            <td>
                                @if($adjustment->adjustment_type == 'increase')
                                    <span style="font-weight: 600; color: #059669;">+{{ $adjustment->adjust_count }}</span>
                                @else
                                    <span style="font-weight: 600; color: #dc2626;">-{{ $adjustment->adjust_count }}</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $previousStock = $adjustment->system_count;
                                    $stockClass = $previousStock <= 10 ? 'stock-low' : ($previousStock <= 50 ? 'stock-medium' : 'stock-high');
                                @endphp
                                <span class="stock-badge {{ $stockClass }}">{{ $previousStock }}</span>
                            </td>
                            <td>
                                @php
                                    $newStock = $adjustment->adjustment_type == 'increase' ?
                                        $adjustment->system_count + $adjustment->adjust_count :
                                        $adjustment->system_count - $adjustment->adjust_count;
                                    $newStockClass = $newStock <= 10 ? 'stock-low' : ($newStock <= 50 ? 'stock-medium' : 'stock-high');
                                @endphp
                                <span class="stock-badge {{ $newStockClass }}">{{ $newStock }}</span>
                            </td>
                            <td><span style="font-size: 0.8125rem; color: #64748b;" title="{{ $adjustment->reason }}">{{ Str::limit($adjustment->reason, 30) }}</span></td>
                            <td>
                                @if($adjustment->status === 'pending')
                                    <span class="payment-badge" style="background: #fef3c7; color: #92400e;">Pending</span>
                                @elseif($adjustment->status === 'approved')
                                    <span class="payment-badge" style="background: #d1fae5; color: #065f46;">Approved</span>
                                @elseif($adjustment->status === 'rejected')
                                    <span class="payment-badge" style="background: #fee2e2; color: #991b1b;">Rejected</span>
                                @endif
                            </td>
                            <td><span class="time-badge">{{ $adjustment->created_at->format('M d, Y') }}</span></td>
                            <td class="actions-cell">
                                <button class="btn-icon btn-view" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 2rem; color: #64748b;">
                                No stock adjustments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="showing-info">
                Showing <strong>{{ $adjustments->firstItem() ?? 0 }}-{{ $adjustments->lastItem() ?? 0 }}</strong> of <strong>{{ $adjustments->total() }}</strong>
            </div>

            <div class="pagination">
                @if ($adjustments->hasPages())
                    {{ $adjustments->links() }}
                @endif
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

        <!-- Example Stock Adjustment Modal/Form -->
        <form method="POST" action="{{ route('admin.stockadjustments.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            Product Name <span class="required">*</span>
                        </label>
                        <select class="form-select" name="stock_prod_id" required>
                            @foreach($inventories as $inv)
                                <option value="{{ $inv->stock_prod_id }}">{{ $inv->product->product_name }} (Current: {{ $inv->product->inventory->quantity_on_hand ?? 0 }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Adjustment Type <span class="required">*</span>
                        </label>
                        <select class="form-select" name="adjustment_type" required>
                            <option value="increase">Increase</option>
                            <option value="decrease">Decrease</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Physical Count <span class="required">*</span>
                            <i class="fas fa-info-circle info-icon" title="Enter the actual physical count"></i>
                        </label>
                        <input type="number" class="form-input" name="physical_count" min="0" placeholder="Enter actual physical count" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Reason <span class="required">*</span>
                        </label>
                        <input type="text" class="form-input" name="reason" placeholder="Enter reason for adjustment" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            System Count <span class="required">*</span>
                            <i class="fas fa-info-circle info-icon" title="Current system inventory count"></i>
                        </label>
                        <input type="number" class="form-input" name="system_count" min="0" placeholder="Enter current system count" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Adjustment Quantity <span class="required">*</span>
                            <i class="fas fa-info-circle info-icon" title="Quantity to add or subtract"></i>
                        </label>
                        <input type="number" class="form-input" name="adjust_count" min="1" placeholder="Enter quantity to adjust" required>
                    </div>

                    <!-- Employee fields removed - only admin can see these -->

                    <div class="form-group">
                        <label class="form-label">
                            Status
                        </label>
                        <input type="text" class="form-input" value="Pending Approval" readonly style="background: #f8fafc; color: #64748b;">
                        <small style="font-size: 0.75rem; color: #64748b;">All adjustments require admin approval</small>
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
    document.querySelector('form').reset();
}

// Close modal when clicking outside
document.getElementById('adjustmentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAdjustmentModal();
    }
});

// Update system count when product is selected
document.querySelector('select[name="stock_prod_id"]').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const stockText = selectedOption.textContent;
    const match = stockText.match(/Current: (\d+)/);
    if (match) {
        document.querySelector('input[name="system_count"]').value = match[1];
    }
});

// Handle form submission - Let the form submit naturally to the backend
document.querySelector('form').addEventListener('submit', function(e) {
    // Get form values for validation
    const productId = document.querySelector('select[name="stock_prod_id"]').value;
    const adjustmentType = document.querySelector('select[name="adjustment_type"]').value;
    const physicalCount = document.querySelector('input[name="physical_count"]').value;
    const systemCount = document.querySelector('input[name="system_count"]').value;
    const adjustCount = document.querySelector('input[name="adjust_count"]').value;
    const reason = document.querySelector('input[name="reason"]').value;
    // Validate
    if (!productId || !adjustmentType || !physicalCount || !systemCount || !adjustCount || !reason) {
        e.preventDefault();
        alert('Please fill in all required fields');
        return;
    }

    // Validate that adjust_count is positive
    if (parseInt(adjustCount) <= 0) {
        e.preventDefault();
        alert('Adjustment quantity must be greater than 0');
        return;
    }

    // Let the form submit to the backend
    console.log('Submitting stock adjustment...');
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
