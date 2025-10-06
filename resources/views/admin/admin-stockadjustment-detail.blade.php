@extends('layouts.admin.app')

@section('title', 'Stock Adjustment Details')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Stock Adjustment Details</h1>
        <div class="header-actions">
            <div class="user-auth-info">
                <span class="auth-badge">
                    <i class="fas fa-user-shield"></i>
                    {{ Auth::user()->fname }} {{ Auth::user()->lname }}
                </span>
                <span class="role-badge">
                    @if(Auth::user()->role_id == 1)
                        <i class="fas fa-crown"></i> Administrator
                    @elseif(Auth::user()->role_id == 2)
                        <i class="fas fa-user-tie"></i> Employee
                    @endif
                </span>
            </div>
            <a href="{{ route('admin.stockadjustments.approvals.index') }}" class="btn-add-supplier">
                <i class="fas fa-arrow-left"></i>
                Back to Approvals
            </a>
        </div>
    </div>

    <div class="content-card">
        <div class="detail-grid">
            <!-- Adjustment Information -->
            <div class="detail-section">
                <h3 class="section-title">Adjustment Information</h3>
                <div class="detail-row">
                    <label>Adjustment ID:</label>
                    <span class="detail-value">#{{ $adjustment->stock_adjustment_id }}</span>
                </div>
                <div class="detail-row">
                    <label>Status:</label>
                    <span class="detail-value">
                        @if($adjustment->status === 'pending')
                            <span class="payment-badge" style="background: #fef3c7; color: #92400e;">Pending</span>
                        @elseif($adjustment->status === 'approved')
                            <span class="payment-badge" style="background: #d1fae5; color: #065f46;">Approved</span>
                        @elseif($adjustment->status === 'rejected')
                            <span class="payment-badge" style="background: #fee2e2; color: #991b1b;">Rejected</span>
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <label>Adjustment Type:</label>
                    <span class="detail-value">
                        @if($adjustment->adjustment_type == 'increase')
                            <span class="payment-badge" style="background: #d1fae5; color: #065f46;">Increase</span>
                        @else
                            <span class="payment-badge" style="background: #fee2e2; color: #991b1b;">Decrease</span>
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <label>Adjustment Quantity:</label>
                    <span class="detail-value">
                        @if($adjustment->adjustment_type == 'increase')
                            <span style="font-weight: 600; color: #059669;">+{{ $adjustment->adjust_count }}</span>
                        @else
                            <span style="font-weight: 600; color: #dc2626;">-{{ $adjustment->adjust_count }}</span>
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <label>Reason:</label>
                    <span class="detail-value">{{ $adjustment->reason }}</span>
                </div>
                <div class="detail-row">
                    <label>Created Date:</label>
                    <span class="detail-value">{{ $adjustment->created_at->format('M d, Y H:i') }}</span>
                </div>
            </div>

            <!-- Product Information -->
            <div class="detail-section">
                <h3 class="section-title">Product Information</h3>
                <div class="detail-row">
                    <label>Product Name:</label>
                    <span class="detail-value">{{ $adjustment->stockProd->product->product_name ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <label>Current System Stock:</label>
                    <span class="detail-value">
                        @php
                            $systemStock = $adjustment->system_count;
                            $stockClass = $systemStock <= 10 ? 'stock-low' : ($systemStock <= 50 ? 'stock-medium' : 'stock-high');
                        @endphp
                        <span class="stock-badge {{ $stockClass }}">{{ $systemStock }}</span>
                    </span>
                </div>
                <div class="detail-row">
                    <label>Physical Count:</label>
                    <span class="detail-value">
                        @php
                            $physicalStock = $adjustment->physical_count;
                            $stockClass = $physicalStock <= 10 ? 'stock-low' : ($physicalStock <= 50 ? 'stock-medium' : 'stock-high');
                        @endphp
                        <span class="stock-badge {{ $stockClass }}">{{ $physicalStock }}</span>
                    </span>
                </div>
                <div class="detail-row">
                    <label>New Stock (After Adjustment):</label>
                    <span class="detail-value">
                        @php
                            $newStock = $adjustment->adjustment_type == 'increase' ?
                                $adjustment->system_count + $adjustment->adjust_count :
                                $adjustment->system_count - $adjustment->adjust_count;
                            $newStockClass = $newStock <= 10 ? 'stock-low' : ($newStock <= 50 ? 'stock-medium' : 'stock-high');
                        @endphp
                        <span class="stock-badge {{ $newStockClass }}">{{ $newStock }}</span>
                    </span>
                </div>
            </div>

            <!-- Employee Information -->
            <div class="detail-section">
                <h3 class="section-title">Employee Information</h3>
                <div class="detail-row">
                    <label>Requested By:</label>
                    <span class="detail-value">{{ $adjustment->requestedBy->employee_name ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <label>Reviewed By:</label>
                    <span class="detail-value">{{ $adjustment->reviewedBy->employee_name ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <label>Reviewed Date:</label>
                    <span class="detail-value">{{ $adjustment->reviewed_date ? $adjustment->reviewed_date->format('M d, Y H:i') : 'N/A' }}</span>
                </div>
                @if($adjustment->admin_notes)
                <div class="detail-row">
                    <label>Admin Notes:</label>
                    <span class="detail-value">{{ $adjustment->admin_notes }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        @if($adjustment->status === 'pending')
        <div class="action-buttons">
            <form method="POST" action="{{ route('admin.stockadjustments.approvals.approve', $adjustment->stock_adjustment_id) }}" style="display: inline;">
                @csrf
                <input type="hidden" name="reviewed_by" value="">
                <div class="form-group">
                    <label class="form-label">Approval Notes (Optional)</label>
                    <textarea class="form-textarea" name="notes" placeholder="Add approval notes..." style="max-width: 500px;"></textarea>
                </div>
                <div class="button-group">
                    <button type="submit" class="btn-approve">
                        <i class="fas fa-check"></i>
                        Approve Adjustment
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ route('admin.stockadjustments.approvals.reject', $adjustment->stock_adjustment_id) }}" style="display: inline;">
                @csrf
                <div class="form-group">
                    <label class="form-label">Rejection Reason <span class="required">*</span></label>
                    <textarea class="form-textarea" name="rejection_reason" placeholder="Enter reason for rejection..." required style="max-width: 500px;"></textarea>
                </div>
                <div class="button-group">
                    <button type="submit" class="btn-reject">
                        <i class="fas fa-times"></i>
                        Reject Adjustment
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>

<style>
.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.detail-section {
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 0.75rem;
    border: 1px solid #e2e8f0;
}

.section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #3b82f6;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e2e8f0;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-row label {
    font-weight: 500;
    color: #475569;
    flex: 1;
}

.detail-value {
    font-weight: 600;
    color: #1e293b;
    flex: 1;
    text-align: right;
}

.action-buttons {
    background: #f8fafc;
    padding: 2rem;
    border-radius: 0.75rem;
    border: 1px solid #e2e8f0;
    margin-top: 2rem;
}

.button-group {
    margin-top: 1rem;
}

.btn-approve {
    background: #059669;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s;
    margin-right: 1rem;
}

.btn-approve:hover {
    background: #047857;
}

.btn-reject {
    background: #dc2626;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s;
}

.btn-reject:hover {
    background: #b91c1c;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-auth-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.auth-badge {
    background: #e0f2fe;
    color: #0277bd;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.role-badge {
    background: #f3e8ff;
    color: #7c3aed;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.role-badge i {
    color: #7c3aed;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #334155;
    margin-bottom: 0.5rem;
}

.form-label .required {
    color: #ef4444;
}

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

.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-textarea {
    min-height: 100px;
    resize: vertical;
    font-family: inherit;
}
</style>
@endsection
