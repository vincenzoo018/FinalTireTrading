@extends('layouts.admin.app')

@section('title', 'Stock Adjustment Approvals')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Stock Adjustment Approvals</h1>
        <div class="header-actions">
            <span class="pending-badge">Pending: {{ $adjustments->where('status', 'pending')->count() }}</span>
            <span style="font-size: 0.875rem; color: #64748b; margin-left: 1rem;">Admin Only Access</span>
        </div>
    </div>

    <div class="content-card">
        <div class="table-controls">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search by product or reason..." id="searchInput">
            </div>

            <div class="filter-wrapper">
                <select class="btn-filter" id="statusFilter" style="padding-right: 2.5rem;">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
                <button class="btn-filter" onclick="toggleBulkActions()">
                    <i class="fas fa-check-double"></i>
                    Bulk Actions
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>

        <!-- Bulk Actions Panel -->
        <div id="bulkActionsPanel" style="display: none; padding: 1rem 1.5rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; align-items: end;">
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">SELECTED ITEMS</label>
                    <span id="selectedCount" style="font-size: 0.875rem; color: #475569;">0 items selected</span>
                </div>
                <div>
                    <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem;">REVIEWER</label>
                    <select id="bulkReviewer" class="search-input" style="width: 100%;">
                        <option value="">Select Reviewer</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->employee_id }}">{{ $employee->employee_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button onclick="bulkApprove()" class="btn-filter" style="width: 100%; justify-content: center; background: #059669; color: white;">
                        <i class="fas fa-check"></i>
                        Bulk Approve
                    </button>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="supplier-table">
                <thead>
                    <tr>
                        <th><input type="checkbox" class="checkbox-all" id="selectAll"></th>
                        <th class="sortable">ID <i class="fas fa-sort"></i></th>
                        <th class="sortable">Product Name <i class="fas fa-sort"></i></th>
                        <th>Adjustment Type</th>
                        <th>Quantity</th>
                        <th>Previous Stock</th>
                        <th>New Stock</th>
                        <th>Reason</th>
                        <th>Requested By</th>
                        <th>Status</th>
                        <th class="sortable">Date <i class="fas fa-sort"></i></th>
                        <th class="actions-header">Actions <i class="fas fa-info-circle tooltip-icon"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($adjustments as $adjustment)
                        <tr data-status="{{ $adjustment->status }}">
                            <td>
                                @if($adjustment->status === 'pending')
                                    <input type="checkbox" class="row-checkbox" value="{{ $adjustment->stock_adjustment_id }}">
                                @endif
                            </td>
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
                            <td><span style="font-size: 0.8125rem; color: #475569;">{{ $adjustment->requestedBy->employee_name ?? 'N/A' }}</span></td>
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
                                <a href="{{ route('admin.stockadjustments.approvals.show', $adjustment->stock_adjustment_id) }}" class="btn-icon btn-view" title="Review Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($adjustment->status === 'pending')
                                    <button class="btn-icon btn-approve" title="Quick Approve" onclick="quickApprove({{ $adjustment->stock_adjustment_id }})">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn-icon btn-reject" title="Quick Reject" onclick="quickReject({{ $adjustment->stock_adjustment_id }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" style="text-align: center; padding: 2rem; color: #64748b;">
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

<!-- Quick Approve Modal -->
<div class="modal-overlay" id="quickApproveModal">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h2>Quick Approve Stock Adjustment</h2>
        </div>
        <form id="quickApproveForm">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Reviewer <span class="required">*</span></label>
                    <select class="form-select" name="reviewed_by" required>
                        <option value="">Select Reviewer</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->employee_id }}">{{ $employee->employee_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Notes (Optional)</label>
                    <textarea class="form-textarea" name="notes" placeholder="Add approval notes..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeQuickApproveModal()">Cancel</button>
                <button type="submit" class="btn-save" style="background: #059669;">Approve</button>
            </div>
        </form>
    </div>
</div>

<!-- Quick Reject Modal -->
<div class="modal-overlay" id="quickRejectModal">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h2>Reject Stock Adjustment</h2>
        </div>
        <form id="quickRejectForm">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Rejection Reason <span class="required">*</span></label>
                    <textarea class="form-textarea" name="rejection_reason" placeholder="Enter reason for rejection..." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeQuickRejectModal()">Cancel</button>
                <button type="submit" class="btn-save" style="background: #dc2626;">Reject</button>
            </div>
        </form>
    </div>
</div>

<style>
.pending-badge {
    background: #fef3c7;
    color: #92400e;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.btn-approve {
    background: #059669;
    color: white;
    border: none;
    padding: 0.5rem;
    border-radius: 0.25rem;
    cursor: pointer;
    margin: 0 0.25rem;
}

.btn-approve:hover {
    background: #047857;
}

.btn-reject {
    background: #dc2626;
    color: white;
    border: none;
    padding: 0.5rem;
    border-radius: 0.25rem;
    cursor: pointer;
    margin: 0 0.25rem;
}

.btn-reject:hover {
    background: #b91c1c;
}

.actions-cell {
    display: flex;
    gap: 0.5rem;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}
</style>

<script>
let currentAdjustmentId = null;

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('.supplier-table tbody tr');
    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Status filter
document.getElementById('statusFilter').addEventListener('change', function() {
    const filterValue = this.value;
    const tableRows = document.querySelectorAll('.supplier-table tbody tr');
    tableRows.forEach(row => {
        if (!filterValue) {
            row.style.display = '';
        } else {
            const status = row.getAttribute('data-status');
            row.style.display = status === filterValue ? '' : 'none';
        }
    });
});

// Toggle bulk actions panel
function toggleBulkActions() {
    const panel = document.getElementById('bulkActionsPanel');
    panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
}

// Select all checkboxes
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    updateSelectedCount();
});

// Individual checkbox change
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('row-checkbox')) {
        updateSelectedCount();
        updateSelectAllState();
    }
});

function updateSelectedCount() {
    const selected = document.querySelectorAll('.row-checkbox:checked');
    document.getElementById('selectedCount').textContent = `${selected.length} items selected`;
}

function updateSelectAllState() {
    const allCheckboxes = document.querySelectorAll('.row-checkbox');
    const checkedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
    const selectAll = document.getElementById('selectAll');

    selectAll.checked = allCheckboxes.length > 0 && allCheckboxes.length === checkedCheckboxes.length;
    selectAll.indeterminate = checkedCheckboxes.length > 0 && checkedCheckboxes.length < allCheckboxes.length;
}

// Bulk approve
function bulkApprove() {
    const selected = document.querySelectorAll('.row-checkbox:checked');
    const reviewer = document.getElementById('bulkReviewer').value;

    if (selected.length === 0) {
        alert('Please select at least one adjustment to approve.');
        return;
    }

    if (!reviewer) {
        alert('Please select a reviewer.');
        return;
    }

    const adjustmentIds = Array.from(selected).map(checkbox => checkbox.value);

    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("admin.stockadjustments.approvals.bulk-approve") }}';

    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';

    const idsInput = document.createElement('input');
    idsInput.type = 'hidden';
    idsInput.name = 'adjustment_ids';
    idsInput.value = JSON.stringify(adjustmentIds);

    const reviewerInput = document.createElement('input');
    reviewerInput.type = 'hidden';
    reviewerInput.name = 'reviewed_by';
    reviewerInput.value = reviewer;

    form.appendChild(csrfToken);
    form.appendChild(idsInput);
    form.appendChild(reviewerInput);
    document.body.appendChild(form);
    form.submit();
}

// Quick approve
function quickApprove(adjustmentId) {
    currentAdjustmentId = adjustmentId;
    document.getElementById('quickApproveModal').classList.add('active');
}

function closeQuickApproveModal() {
    document.getElementById('quickApproveModal').classList.remove('active');
    document.getElementById('quickApproveForm').reset();
}

// Quick reject
function quickReject(adjustmentId) {
    currentAdjustmentId = adjustmentId;
    document.getElementById('quickRejectModal').classList.add('active');
}

function closeQuickRejectModal() {
    document.getElementById('quickRejectModal').classList.remove('active');
    document.getElementById('quickRejectForm').reset();
}

// Handle quick approve form submission
document.getElementById('quickApproveForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(`/admin/stockadjustments/approvals/${currentAdjustmentId}/approve`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error approving adjustment: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error approving adjustment');
    });
});

// Handle quick reject form submission
document.getElementById('quickRejectForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(`/admin/stockadjustments/approvals/${currentAdjustmentId}/reject`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error rejecting adjustment: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error rejecting adjustment');
    });
});

// Close modals when clicking outside
document.getElementById('quickApproveModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeQuickApproveModal();
    }
});

document.getElementById('quickRejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeQuickRejectModal();
    }
});
</script>
@endsection
