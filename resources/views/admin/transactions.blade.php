@extends('layouts.admin.app')

@section('title', 'Supplier Transactions')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Supplier Transactions</h1>
        <button class="btn-add-supplier" onclick="openTxnModal()">
            <i class="fas fa-plus"></i>
            New Transaction
        </button>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success" style="background: #d1fae5; border: 1px solid #10b981; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.75rem;">
        <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.25rem;"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error" style="background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
        <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
            <i class="fas fa-exclamation-circle" style="color: #ef4444; font-size: 1.25rem;"></i>
            <div>
                @foreach($errors->all() as $error)
                    <p style="margin: 0.25rem 0;">{{ $error }}</p>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <div class="content-card">
        <div class="table-controls">
            <form method="GET" style="display:flex; gap:1rem; width:100%;">
                <div class="search-wrapper" style="flex:1;">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Search by reference or supplier...">
                </div>

                <div class="filter-wrapper">
                    <select class="btn-filter" name="supplier_id" onchange="this.form.submit()" style="padding-right: 2rem;">
                        <option value="">All Suppliers</option>
                        @foreach(($suppliers ?? []) as $s)
                            <option value="{{ $s->supplier_id }}" {{ (string)request('supplier_id') === (string)$s->supplier_id ? 'selected' : '' }}>{{ $s->supplier_name }}</option>
                        @endforeach
                    </select>
                    <button class="btn-filter" type="submit">
                        <i class="fas fa-filter"></i>
                        Apply
                    </button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="supplier-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="checkbox-all">
                        </th>
                        <th class="sortable">Transaction ID <i class="fas fa-sort"></i></th>
                        <th class="sortable">Supplier Name <i class="fas fa-sort"></i></th>
                        <th>Reference Number</th>
                        <th>Order Date</th>
                        <th>Delivery Date</th>
                        <th>Overall Total</th>
                        <th>Tax</th>
                        <th class="actions-header">Actions <i class="fas fa-info-circle tooltip-icon"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($transactions ?? []) as $txn)
                    <tr>
                        <td><input type="checkbox" class="row-checkbox"></td>
                        <td class="supplier-id">{{ $txn->transaction_id }}</td>
                        <td class="supplier-name">{{ $txn->supplier->supplier_name ?? 'N/A' }}</td>
                        <td>{{ $txn->reference_num }}</td>
                        <td>{{ \Carbon\Carbon::parse($txn->order_date)->format('M d, Y') }}</td>
                        <td>{{ $txn->delivery_date ? \Carbon\Carbon::parse($txn->delivery_date)->format('M d, Y') : '-' }}</td>
                        <td class="transaction-amount">₱{{ number_format($txn->overall_total, 2) }}</td>
                        <td>₱{{ number_format($txn->tax, 2) }}</td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <a href="{{ route('admin.transactions.show', $txn->transaction_id) }}" 
                                   class="btn-action btn-view" title="View Invoice" target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn-action btn-edit" title="Edit Transaction" 
                                        onclick="editTransaction({{ $txn->transaction_id }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete-action" title="Delete Transaction" 
                                        onclick="deleteTransaction({{ $txn->transaction_id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 1rem; color: #64748b;">
                            No transactions found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="showing-info">
                Showing <strong>{{ $transactions->firstItem() ?? 0 }}-{{ $transactions->lastItem() ?? 0 }}</strong> of <strong>{{ $transactions->total() ?? 0 }}</strong>
            </div>

            <div class="pagination">
                @if (method_exists($transactions, 'links'))
                    {{ $transactions->links() }}
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Create Transaction Modal - Redesigned Multi-Step Wizard -->
<div class="modal-overlay" id="txnModal">
    <div class="modal-content txn-wizard-modal">
        <div class="modal-header">
            <h2><i class="fas fa-file-invoice"></i> Create Supplier Transaction</h2>
            <button type="button" class="modal-close-btn" onclick="closeTxnModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Progress Steps -->
        <div class="wizard-steps">
            <div class="wizard-step active" data-step="1">
                <div class="step-number">1</div>
                <div class="step-label">Supplier</div>
            </div>
            <div class="wizard-line"></div>
            <div class="wizard-step" data-step="2">
                <div class="step-number">2</div>
                <div class="step-label">Details</div>
            </div>
            <div class="wizard-line"></div>
            <div class="wizard-step" data-step="3">
                <div class="step-number">3</div>
                <div class="step-label">Products</div>
            </div>
            <div class="wizard-line"></div>
            <div class="wizard-step" data-step="4">
                <div class="step-number">4</div>
                <div class="step-label">Review</div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.transactions.store') }}" id="txnWizardForm">
            @csrf
            <div class="modal-body">
                <!-- STEP 1: Supplier Selection -->
                <div class="wizard-content active" data-step="1">
                    <div class="wizard-section">
                        <h3 class="section-title"><i class="fas fa-truck"></i> Select Supplier</h3>
                        <p class="section-desc">Choose the supplier for this transaction</p>
                        
                        <div class="supplier-grid">
                            @foreach(($suppliers ?? []) as $s)
                            <div class="supplier-card" onclick="selectSupplier({{ $s->supplier_id }}, '{{ $s->supplier_name }}', '{{ $s->company_name }}', '{{ $s->contact_person }}', '{{ $s->contact_number }}')">
                                <div class="supplier-icon">
                                    <i class="fas fa-store"></i>
                                </div>
                                <div class="supplier-info">
                                    <h4>{{ $s->supplier_name }}</h4>
                                    <p class="company-name">{{ $s->company_name }}</p>
                                    <div class="supplier-meta">
                                        <span><i class="fas fa-user"></i> {{ $s->contact_person }}</span>
                                        <span><i class="fas fa-phone"></i> {{ $s->contact_number }}</span>
                                    </div>
                                </div>
                                <div class="supplier-radio">
                                    <input type="radio" name="supplier_id" value="{{ $s->supplier_id }}" required>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div id="selectedSupplierInfo" class="selected-info" style="display:none;">
                            <i class="fas fa-check-circle"></i>
                            <span id="selectedSupplierName"></span>
                        </div>
                    </div>
                </div>

                <!-- STEP 2: Transaction Details -->
                <div class="wizard-content" data-step="2">
                    <div class="wizard-section">
                        <h3 class="section-title"><i class="fas fa-info-circle"></i> Transaction Details</h3>
                        <p class="section-desc">Enter order and delivery information</p>
                        
                        <div class="form-grid-2col">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-hashtag"></i> Reference Number <span class="required">*</span></label>
                                <input type="text" class="form-input" name="reference_num" id="referenceNum" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-calendar"></i> Order Date <span class="required">*</span></label>
                                <input type="date" class="form-input" name="order_date" id="orderDate" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-shipping-fast"></i> Delivery Status <span class="required">*</span></label>
                                <div class="radio-group">
                                    <label class="radio-card">
                                        <input type="radio" name="delivery_received" value="1" onchange="toggleDeliveryFields(true)">
                                        <div class="radio-content">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Received</span>
                                        </div>
                                    </label>
                                    <label class="radio-card">
                                        <input type="radio" name="delivery_received" value="0" checked onchange="toggleDeliveryFields(false)">
                                        <div class="radio-content">
                                            <i class="fas fa-clock"></i>
                                            <span>Pending</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" id="deliveryDateGroup" style="display:none;">
                                <label class="form-label"><i class="fas fa-calendar-check"></i> Delivery Date</label>
                                <input type="date" class="form-input" name="delivery_date" id="deliveryDate">
                            </div>

                            <div class="form-group" id="estimatedDateGroup">
                                <label class="form-label"><i class="fas fa-calendar-alt"></i> Estimated Delivery</label>
                                <input type="date" class="form-input" name="estimated_date" id="estimatedDate">
                            </div>

                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-dollar-sign"></i> Delivery Fee</label>
                                <input type="number" step="0.01" class="form-input" name="delivery_fee" id="deliveryFee" value="0" min="0" oninput="calculateTax()">
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-percent"></i> Tax Amount <span class="required">*</span>
                                </label>
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #64748b; cursor: pointer;">
                                        <input type="checkbox" id="autoTaxCheckbox" checked onchange="toggleAutoTax()">
                                        Auto-calculate (12% VAT)
                                    </label>
                                </div>
                                <input type="number" step="0.01" class="form-input" name="tax" id="taxAmount" value="0" min="0" required readonly style="background: #f8fafc;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: Products Selection -->
                <div class="wizard-content" data-step="3">
                    <div class="wizard-section">
                        <h3 class="section-title"><i class="fas fa-boxes"></i> Select Products</h3>
                        <p class="section-desc">Use +/- buttons to adjust quantities for each product</p>
                        
                        <div id="productsTableContainer" class="products-table-container">
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <p>Loading products from supplier...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 4: Review & Summary -->
                <div class="wizard-content" data-step="4">
                    <div class="wizard-section">
                        <h3 class="section-title"><i class="fas fa-clipboard-check"></i> Review Transaction</h3>
                        <p class="section-desc">Please review all details before submitting. Click "Create Transaction" to save.</p>
                        
                        <div class="review-grid">
                            <div class="review-card">
                                <h4><i class="fas fa-truck"></i> Supplier Information</h4>
                                <div class="review-item">
                                    <span class="review-label">Supplier:</span>
                                    <span class="review-value" id="reviewSupplier">-</span>
                                </div>
                                <div class="review-item">
                                    <span class="review-label">Company:</span>
                                    <span class="review-value" id="reviewCompany">-</span>
                                </div>
                                <div class="review-item">
                                    <span class="review-label">Contact:</span>
                                    <span class="review-value" id="reviewContact">-</span>
                                </div>
                                <div class="review-item">
                                    <span class="review-label">Phone:</span>
                                    <span class="review-value" id="reviewPhone">-</span>
                                </div>
                            </div>

                            <div class="review-card">
                                <h4><i class="fas fa-file-alt"></i> Transaction Details</h4>
                                <div class="review-item">
                                    <span class="review-label">Reference #:</span>
                                    <span class="review-value" id="reviewReference">-</span>
                                </div>
                                <div class="review-item">
                                    <span class="review-label">Order Date:</span>
                                    <span class="review-value" id="reviewOrderDate">-</span>
                                </div>
                                <div class="review-item">
                                    <span class="review-label">Delivery Status:</span>
                                    <span class="review-value" id="reviewStatus">-</span>
                                </div>
                                <div class="review-item" id="reviewDeliveryDateRow" style="display:none;">
                                    <span class="review-label">Delivery Date:</span>
                                    <span class="review-value" id="reviewDeliveryDate">-</span>
                                </div>
                                <div class="review-item" id="reviewEstimatedDateRow" style="display:none;">
                                    <span class="review-label">Estimated Date:</span>
                                    <span class="review-value" id="reviewEstimatedDate">-</span>
                                </div>
                            </div>
                        </div>

                        <div class="review-table">
                            <h4><i class="fas fa-list"></i> Products Summary</h4>
                            <p style="color: #64748b; font-size: 0.875rem; margin-bottom: 1rem;">
                                <strong id="reviewProductCount">0</strong> product(s) selected
                            </p>
                            <table class="summary-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th class="text-right">Quantity</th>
                                        <th class="text-right">Unit Price</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="reviewProductsList">
                                    <tr>
                                        <td colspan="6" style="text-align:center; padding: 2rem; color: #94a3b8;">
                                            <i class="fas fa-box-open" style="font-size: 2rem; margin-bottom: 0.5rem; opacity: 0.5;"></i>
                                            <p>No products to display</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="totals-summary">
                            <div class="total-row">
                                <span><i class="fas fa-boxes"></i> Products Subtotal:</span>
                                <strong id="reviewSubtotal">₱0.00</strong>
                            </div>
                            <div class="total-row">
                                <span><i class="fas fa-truck"></i> Delivery Fee:</span>
                                <strong id="reviewDeliveryFee">₱0.00</strong>
                            </div>
                            <div class="total-row">
                                <span><i class="fas fa-receipt"></i> Tax:</span>
                                <strong id="reviewTax">₱0.00</strong>
                            </div>
                            <div class="total-row grand-total">
                                <span><i class="fas fa-calculator"></i> Grand Total:</span>
                                <strong id="reviewGrandTotal">₱0.00</strong>
                            </div>
                        </div>

                        <div class="review-note">
                            <div class="note-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="note-content">
                                <strong>What happens when you save?</strong>
                                <ul>
                                    <li>Transaction will be recorded in the system</li>
                                    <li id="stockNoteReceived" style="display:none;">Stock will be automatically added to StockProd (available for inventory)</li>
                                    <li id="stockNotePending" style="display:none;">Transaction will be marked as pending until delivery is received</li>
                                    <li>You can view this transaction in the transactions list</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeTxnModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <div class="footer-actions">
                    <button type="button" class="btn-secondary" id="prevBtn" onclick="prevStep()" style="display:none;">
                        <i class="fas fa-arrow-left"></i> Previous
                    </button>
                    <button type="button" class="btn-primary" id="nextBtn" onclick="nextStep()">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn-save" id="submitBtn" style="display:none;">
                        <i class="fas fa-check"></i> Create Transaction
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
/* Modal Base Styles */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(4px);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    animation: fadeIn 0.3s ease;
}
.modal-overlay.active { display: flex; }

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.modal-content {
    background: #fff;
    border-radius: 1rem;
    width: 100%;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    display: flex;
    flex-direction: column;
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.txn-wizard-modal {
    max-width: 1000px;
}

.modal-header {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.modal-header h2 {
    margin: 0;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.modal-close-btn {
    background: rgba(255,255,255,0.2);
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.modal-close-btn:hover {
    background: rgba(255,255,255,0.3);
    transform: rotate(90deg);
}

/* Wizard Steps */
.wizard-steps {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 2rem 1rem;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}

.wizard-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    position: relative;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s;
}

.wizard-step.active .step-number {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.wizard-step.completed .step-number {
    background: #10b981;
    color: white;
}

.step-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #64748b;
}

.wizard-step.active .step-label {
    color: #667eea;
    font-weight: 600;
}

.wizard-line {
    width: 80px;
    height: 2px;
    background: #e2e8f0;
    margin: 0 1rem;
    margin-bottom: 1.5rem;
}

/* Wizard Content */
.modal-body {
    flex: 1;
    overflow-y: auto;
    padding: 0;
    max-height: calc(90vh - 250px);
    min-height: 400px;
}

/* Custom Scrollbar */
.modal-body::-webkit-scrollbar {
    width: 8px;
}

.modal-body::-webkit-scrollbar-track {
    background: #f1f5f9;
}

.modal-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

.products-table-container::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.products-table-container::-webkit-scrollbar-track {
    background: #f8fafc;
}

.products-table-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.products-table-container::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

.wizard-content {
    display: none;
    animation: fadeInSlide 0.3s ease;
}

.wizard-content.active {
    display: block;
}

@keyframes fadeInSlide {
    from { opacity: 0; transform: translateX(20px); }
    to { opacity: 1; transform: translateX(0); }
}

.wizard-section {
    padding: 2rem;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-desc {
    color: #64748b;
    font-size: 0.875rem;
    margin: 0 0 1.5rem 0;
}

/* Supplier Cards */
.supplier-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
    margin-top: 1.5rem;
}

.supplier-card {
    border: 2px solid #e2e8f0;
    border-radius: 0.75rem;
    padding: 1.5rem;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    gap: 1rem;
    align-items: flex-start;
    position: relative;
}

.supplier-card:hover {
    border-color: #667eea;
    background: #f8fafc;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
}

.supplier-card.selected {
    border-color: #667eea;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
}

.supplier-icon {
    width: 50px;
    height: 50px;
    border-radius: 0.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.supplier-info {
    flex: 1;
}

.supplier-info h4 {
    margin: 0 0 0.25rem 0;
    font-size: 1.125rem;
    color: #1e293b;
}

.company-name {
    font-size: 0.875rem;
    color: #64748b;
    margin: 0 0 0.75rem 0;
}

.supplier-meta {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    font-size: 0.8125rem;
    color: #64748b;
}

.supplier-meta span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.supplier-radio {
    flex-shrink: 0;
}

.supplier-radio input[type="radio"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.selected-info {
    margin-top: 1.5rem;
    padding: 1rem;
    background: #ecfdf5;
    border: 1px solid #10b981;
    border-radius: 0.5rem;
    color: #047857;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
}

.selected-info i {
    font-size: 1.25rem;
}

/* Form Styles */
.form-grid-2col {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #334155;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-label i {
    color: #667eea;
}

.required {
    color: #ef4444;
}

.form-input, .form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #cbd5e1;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.form-input:focus, .form-select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Radio Cards */
.radio-group {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.radio-card {
    border: 2px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 1rem;
    cursor: pointer;
    transition: all 0.2s;
    display: block;
}

.radio-card:hover {
    border-color: #667eea;
    background: #f8fafc;
}

.radio-card input[type="radio"] {
    display: none;
}

.radio-card input[type="radio"]:checked + .radio-content {
    color: #667eea;
}

.radio-card:has(input[type="radio"]:checked) {
    border-color: #667eea;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
}

.radio-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
    color: #64748b;
}

.radio-content i {
    font-size: 1.25rem;
}

/* Products Table */
.products-table-container {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
    padding: 1rem;
    min-height: 300px;
    max-height: 500px;
    overflow-y: auto;
}

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem;
    color: #64748b;
    text-align: center;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.products-table {
    width: 100%;
    background: white;
    border-radius: 0.5rem;
    overflow: hidden;
}

.products-table thead {
    background: #f1f5f9;
}

.products-table th,
.products-table td {
    padding: 1rem;
    text-align: left;
}

.products-table th {
    font-weight: 600;
    font-size: 0.875rem;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.products-table tbody tr {
    border-bottom: 1px solid #e2e8f0;
    transition: background 0.2s;
}

.products-table tbody tr:hover {
    background: #f8fafc;
}

.product-name {
    font-weight: 500;
    color: #1e293b;
}

.product-meta {
    font-size: 0.8125rem;
    color: #64748b;
}

/* Quantity Controls */
.qty-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.qty-btn {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 0.375rem;
    font-size: 1.125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.qty-btn-minus {
    background: #fee2e2;
    color: #dc2626;
}

.qty-btn-minus:hover:not(:disabled) {
    background: #fecaca;
    transform: scale(1.1);
}

.qty-btn-minus:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.qty-btn-plus {
    background: #d1fae5;
    color: #059669;
}

.qty-btn-plus:hover {
    background: #a7f3d0;
    transform: scale(1.1);
}

.qty-input {
    width: 60px;
    text-align: center;
    padding: 0.5rem;
    border: 1px solid #cbd5e1;
    border-radius: 0.375rem;
    font-weight: 600;
    font-size: 0.875rem;
}

/* Review Section */
.review-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.review-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
    padding: 1.5rem;
}

.review-card h4 {
    margin: 0 0 1rem 0;
    font-size: 1rem;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.review-item {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e2e8f0;
}

.review-item:last-child {
    border-bottom: none;
}

.review-label {
    font-size: 0.875rem;
    color: #64748b;
}

.review-value {
    font-weight: 500;
    color: #1e293b;
}

.review-table {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.review-table h4 {
    margin: 0 0 1rem 0;
    font-size: 1rem;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.summary-table {
    width: 100%;
}

.summary-table th,
.summary-table td {
    padding: 0.75rem;
    text-align: left;
}

.summary-table th {
    background: #f8fafc;
    font-weight: 600;
    font-size: 0.875rem;
    color: #475569;
    border-bottom: 2px solid #e2e8f0;
}

.summary-table .text-right {
    text-align: right;
}

.summary-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
}

.totals-summary {
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 0.75rem;
    padding: 1.5rem;
}

.total-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    font-size: 0.9375rem;
    color: #475569;
}

.total-row.grand-total {
    padding-top: 1rem;
    margin-top: 0.5rem;
    border-top: 2px solid #cbd5e1;
    font-size: 1.25rem;
    color: #1e293b;
}

.total-row.grand-total strong {
    color: #667eea;
}

.total-row i {
    margin-right: 0.5rem;
    color: #667eea;
}

/* Review Note */
.review-note {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border: 1px solid #667eea;
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-top: 1.5rem;
    display: flex;
    gap: 1rem;
}

.note-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #667eea;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.note-content {
    flex: 1;
}

.note-content strong {
    display: block;
    color: #1e293b;
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.note-content ul {
    margin: 0;
    padding-left: 1.5rem;
    color: #475569;
    font-size: 0.875rem;
}

.note-content ul li {
    margin: 0.375rem 0;
    line-height: 1.5;
}

/* Modal Footer */
.modal-footer {
    padding: 1.5rem 2rem;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8fafc;
}

.footer-actions {
    display: flex;
    gap: 1rem;
}

.btn-primary, .btn-secondary, .btn-save, .btn-cancel {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.5rem;
    font-size: 0.9375rem;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: #e2e8f0;
    color: #475569;
}

.btn-secondary:hover {
    background: #cbd5e1;
}

.btn-save {
    background: #10b981;
    color: white;
}

.btn-save:hover {
    background: #059669;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

.btn-cancel {
    background: #ef4444;
    color: white;
}

.btn-cancel:hover {
    background: #dc2626;
}

/* Responsive */
@media (max-width: 768px) {
    .form-grid-2col,
    .review-grid {
        grid-template-columns: 1fr;
    }
    
    .supplier-grid {
        grid-template-columns: 1fr;
    }
    
    .wizard-steps {
        padding: 1rem;
    }
    
    .wizard-line {
        width: 40px;
        margin: 0 0.5rem;
    }
    
    .step-label {
        display: none;
    }
}
</style>

<script>
// ========== WIZARD STATE MANAGEMENT ==========
let currentStep = 1;
let selectedSupplierData = null;
let productsData = [];
let autoTaxEnabled = true;
const TAX_RATE = 0.12; // 12% VAT

const allProducts = @json($products ?? []);
console.log('Loaded products:', allProducts);

// ========== MODAL CONTROLS ==========
function openTxnModal() {
    document.getElementById('txnModal').classList.add('active');
    document.body.style.overflow = 'hidden';
    resetWizard();
}

function closeTxnModal() {
    document.getElementById('txnModal').classList.remove('active');
    document.body.style.overflow = '';
    resetWizard();
}

function resetWizard() {
    currentStep = 1;
    selectedSupplierData = null;
    productsData = [];
    autoTaxEnabled = true;
    updateWizardUI();
    document.getElementById('txnWizardForm').reset();
    document.querySelectorAll('.supplier-card').forEach(c => c.classList.remove('selected'));
    document.getElementById('selectedSupplierInfo').style.display = 'none';
    document.getElementById('productsTableContainer').innerHTML = '<div class="empty-state"><i class="fas fa-box-open"></i><p>Loading products from supplier...</p></div>';
    
    // Reset tax settings
    document.getElementById('autoTaxCheckbox').checked = true;
    document.getElementById('taxAmount').readOnly = true;
    document.getElementById('taxAmount').style.background = '#f8fafc';
    document.getElementById('taxAmount').value = '0';
}

document.getElementById('txnModal').addEventListener('click', function(e) {
    if (e.target === this) closeTxnModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeTxnModal();
});

// ========== WIZARD NAVIGATION ==========
function nextStep() {
    // Validate current step before proceeding
    if (!validateStep(currentStep)) return;
    
    if (currentStep < 4) {
        currentStep++;
        
        // Load products when entering step 3
        if (currentStep === 3) {
            loadSupplierProducts();
        }
        
        // Populate review when entering step 4
        if (currentStep === 4) {
            populateReview();
        }
        
        updateWizardUI();
    }
}

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        updateWizardUI();
    }
}

function updateWizardUI() {
    // Update step indicators
    document.querySelectorAll('.wizard-step').forEach(step => {
        const stepNum = parseInt(step.dataset.step);
        step.classList.remove('active', 'completed');
        if (stepNum === currentStep) {
            step.classList.add('active');
        } else if (stepNum < currentStep) {
            step.classList.add('completed');
        }
    });
    
    // Update content visibility
    document.querySelectorAll('.wizard-content').forEach(content => {
        content.classList.remove('active');
    });
    document.querySelector(`.wizard-content[data-step="${currentStep}"]`).classList.add('active');
    
    // Update button visibility
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    
    prevBtn.style.display = currentStep > 1 ? 'flex' : 'none';
    nextBtn.style.display = currentStep < 4 ? 'flex' : 'none';
    submitBtn.style.display = currentStep === 4 ? 'flex' : 'none';
}

function validateStep(step) {
    switch(step) {
        case 1:
            if (!document.querySelector('input[name="supplier_id"]:checked')) {
                alert('Please select a supplier');
                return false;
            }
            return true;
        case 2:
            const refNum = document.getElementById('referenceNum').value.trim();
            const orderDate = document.getElementById('orderDate').value;
            if (!refNum) {
                alert('Please enter a reference number');
                return false;
            }
            if (!orderDate) {
                alert('Please select an order date');
                return false;
            }
            return true;
        case 3:
            const hasProducts = productsData.some(p => p.quantity > 0);
            if (!hasProducts) {
                alert('Please add at least one product with quantity > 0');
                return false;
            }
            return true;
        default:
            return true;
    }
}

// ========== SUPPLIER SELECTION ==========
function selectSupplier(id, name, company, contact, phone) {
    // Update radio selection
    document.querySelectorAll('.supplier-card').forEach(c => c.classList.remove('selected'));
    event.currentTarget.classList.add('selected');
    document.querySelector(`input[name="supplier_id"][value="${id}"]`).checked = true;
    
    // Store supplier data
    selectedSupplierData = { id, name, company, contact, phone };
    
    // Show selection info
    document.getElementById('selectedSupplierInfo').style.display = 'flex';
    document.getElementById('selectedSupplierName').textContent = `${name} (${company})`;
}

// ========== PRODUCTS LOADING & MANAGEMENT ==========
function loadSupplierProducts() {
    if (!selectedSupplierData) {
        console.error('No supplier selected');
        return;
    }
    
    console.log('Loading products for supplier ID:', selectedSupplierData.id);
    
    // Filter products by supplier
    const supplierProducts = allProducts.filter(p => {
        return p.supplier_id == selectedSupplierData.id;
    });
    
    console.log('Found products:', supplierProducts);
    
    // Initialize products data with quantity 0
    productsData = supplierProducts.map(p => ({
        product_id: p.product_id,
        product_name: p.product_name,
        category: p.category?.category_name || 'N/A',
        base_price: parseFloat(p.base_price) || 0,
        quantity: 0,
        total: 0
    }));
    
    console.log('Initialized products data:', productsData);
    
    renderProductsTable();
    calculateTax(); // Calculate initial tax
}

function renderProductsTable() {
    const container = document.getElementById('productsTableContainer');
    
    if (productsData.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <p>No products found for this supplier</p>
            </div>
        `;
        return;
    }
    
    let html = `
        <table class="products-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Quantity</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    productsData.forEach((product, index) => {
        html += `
            <tr>
                <td>
                    <div class="product-name">${product.product_name}</div>
                </td>
                <td>
                    <div class="product-meta">${product.category}</div>
                </td>
                <td class="text-right">₱${product.base_price.toFixed(2)}</td>
                <td>
                    <div class="qty-controls">
                        <button type="button" class="qty-btn qty-btn-minus" onclick="adjustQuantity(${index}, -1)" ${product.quantity === 0 ? 'disabled' : ''}>
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" class="qty-input" value="${product.quantity}" 
                               onchange="setQuantity(${index}, this.value)" min="0">
                        <button type="button" class="qty-btn qty-btn-plus" onclick="adjustQuantity(${index}, 1)">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </td>
                <td class="text-right"><strong>₱${product.total.toFixed(2)}</strong></td>
            </tr>
        `;
    });
    
    html += '</tbody></table>';
    container.innerHTML = html;
}

function adjustQuantity(index, delta) {
    productsData[index].quantity = Math.max(0, productsData[index].quantity + delta);
    productsData[index].total = productsData[index].quantity * productsData[index].base_price;
    renderProductsTable();
    calculateTax();
}

function setQuantity(index, value) {
    const qty = Math.max(0, parseInt(value) || 0);
    productsData[index].quantity = qty;
    productsData[index].total = qty * productsData[index].base_price;
    renderProductsTable();
    calculateTax();
}

// ========== TAX CALCULATION ==========
function toggleAutoTax() {
    autoTaxEnabled = document.getElementById('autoTaxCheckbox').checked;
    const taxInput = document.getElementById('taxAmount');
    
    if (autoTaxEnabled) {
        taxInput.readOnly = true;
        taxInput.style.background = '#f8fafc';
        calculateTax();
    } else {
        taxInput.readOnly = false;
        taxInput.style.background = '#ffffff';
    }
}

function calculateTax() {
    if (!autoTaxEnabled) return;
    
    // Calculate subtotal from products
    let subtotal = 0;
    productsData.forEach(p => {
        subtotal += p.total;
    });
    
    // Add delivery fee to taxable amount
    const deliveryFee = parseFloat(document.getElementById('deliveryFee').value) || 0;
    const taxableAmount = subtotal + deliveryFee;
    
    // Calculate 12% VAT
    const tax = taxableAmount * TAX_RATE;
    
    // Update tax input
    document.getElementById('taxAmount').value = tax.toFixed(2);
    
    console.log('Tax calculated:', {
        subtotal: subtotal.toFixed(2),
        deliveryFee: deliveryFee.toFixed(2),
        taxableAmount: taxableAmount.toFixed(2),
        tax: tax.toFixed(2)
    });
}

// ========== DELIVERY TOGGLE ==========
function toggleDeliveryFields(isReceived) {
    const deliveryDateGroup = document.getElementById('deliveryDateGroup');
    const estimatedDateGroup = document.getElementById('estimatedDateGroup');
    
    if (isReceived) {
        deliveryDateGroup.style.display = 'flex';
        estimatedDateGroup.style.display = 'none';
        document.getElementById('deliveryDate').required = true;
        document.getElementById('estimatedDate').required = false;
    } else {
        deliveryDateGroup.style.display = 'none';
        estimatedDateGroup.style.display = 'flex';
        document.getElementById('deliveryDate').required = false;
        document.getElementById('estimatedDate').required = false;
    }
}

// ========== REVIEW & SUBMIT ==========
function populateReview() {
    // Supplier info
    document.getElementById('reviewSupplier').textContent = selectedSupplierData.name;
    document.getElementById('reviewCompany').textContent = selectedSupplierData.company;
    document.getElementById('reviewContact').textContent = selectedSupplierData.contact;
    document.getElementById('reviewPhone').textContent = selectedSupplierData.phone;
    
    // Transaction details
    document.getElementById('reviewReference').textContent = document.getElementById('referenceNum').value;
    document.getElementById('reviewOrderDate').textContent = new Date(document.getElementById('orderDate').value).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    
    const deliveryStatus = document.querySelector('input[name="delivery_received"]:checked').value;
    const isReceived = deliveryStatus === '1';
    
    document.getElementById('reviewStatus').innerHTML = isReceived
        ? '<span style="color:#10b981;"><i class="fas fa-check-circle"></i> Received</span>'
        : '<span style="color:#f59e0b;"><i class="fas fa-clock"></i> Pending</span>';
    
    // Show/hide delivery dates
    const deliveryDateRow = document.getElementById('reviewDeliveryDateRow');
    const estimatedDateRow = document.getElementById('reviewEstimatedDateRow');
    const deliveryDateInput = document.getElementById('deliveryDate').value;
    const estimatedDateInput = document.getElementById('estimatedDate').value;
    
    if (isReceived && deliveryDateInput) {
        deliveryDateRow.style.display = 'flex';
        document.getElementById('reviewDeliveryDate').textContent = new Date(deliveryDateInput).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        estimatedDateRow.style.display = 'none';
    } else if (!isReceived && estimatedDateInput) {
        estimatedDateRow.style.display = 'flex';
        document.getElementById('reviewEstimatedDate').textContent = new Date(estimatedDateInput).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        deliveryDateRow.style.display = 'none';
    } else {
        deliveryDateRow.style.display = 'none';
        estimatedDateRow.style.display = 'none';
    }
    
    // Show/hide stock notes
    document.getElementById('stockNoteReceived').style.display = isReceived ? 'list-item' : 'none';
    document.getElementById('stockNotePending').style.display = isReceived ? 'none' : 'list-item';
    
    // Products list
    const productsList = document.getElementById('reviewProductsList');
    const selectedProducts = productsData.filter(p => p.quantity > 0);
    
    // Update product count
    document.getElementById('reviewProductCount').textContent = selectedProducts.length;
    
    let productsHTML = '';
    let subtotal = 0;
    
    if (selectedProducts.length === 0) {
        productsHTML = `
            <tr>
                <td colspan="6" style="text-align:center; padding: 2rem; color: #94a3b8;">
                    <i class="fas fa-box-open" style="font-size: 2rem; margin-bottom: 0.5rem; opacity: 0.5;"></i>
                    <p>No products selected</p>
                </td>
            </tr>
        `;
    } else {
        selectedProducts.forEach((product, index) => {
            subtotal += product.total;
            productsHTML += `
                <tr>
                    <td style="text-align:center;">${index + 1}</td>
                    <td><strong>${product.product_name}</strong></td>
                    <td>${product.category}</td>
                    <td class="text-right"><span style="background:#e0e7ff; padding:0.25rem 0.75rem; border-radius:0.375rem; font-weight:600;">${product.quantity}</span></td>
                    <td class="text-right">₱${product.base_price.toFixed(2)}</td>
                    <td class="text-right"><strong style="color:#667eea;">₱${product.total.toFixed(2)}</strong></td>
                </tr>
            `;
        });
    }
    
    productsList.innerHTML = productsHTML;
    
    // Totals
    const deliveryFee = parseFloat(document.getElementById('deliveryFee').value) || 0;
    const tax = parseFloat(document.getElementById('taxAmount').value) || 0;
    const grandTotal = subtotal + deliveryFee + tax;
    
    document.getElementById('reviewSubtotal').textContent = `₱${subtotal.toFixed(2)}`;
    document.getElementById('reviewDeliveryFee').textContent = `₱${deliveryFee.toFixed(2)}`;
    document.getElementById('reviewTax').textContent = `₱${tax.toFixed(2)}`;
    document.getElementById('reviewGrandTotal').textContent = `₱${grandTotal.toFixed(2)}`;
}

// ========== FORM SUBMISSION ==========
document.getElementById('txnWizardForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get selected products
    const selectedProducts = productsData.filter(p => p.quantity > 0);
    
    console.log('Submitting form with products:', selectedProducts);
    
    if (selectedProducts.length === 0) {
        alert('Please add at least one product');
        return;
    }
    
    // Remove existing hidden inputs
    document.querySelectorAll('input[name^="items["]').forEach(el => el.remove());
    
    // Create hidden inputs for each product
    const form = this;
    selectedProducts.forEach((product, index) => {
        // Product ID
        const productIdInput = document.createElement('input');
        productIdInput.type = 'hidden';
        productIdInput.name = `items[${index}][product_id]`;
        productIdInput.value = product.product_id;
        form.appendChild(productIdInput);
        
        // Quantity
        const quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = `items[${index}][quantity]`;
        quantityInput.value = product.quantity;
        form.appendChild(quantityInput);
        
        // Total
        const totalInput = document.createElement('input');
        totalInput.type = 'hidden';
        totalInput.name = `items[${index}][total]`;
        totalInput.value = product.total.toFixed(2);
        form.appendChild(totalInput);
    });
    
    console.log('Form data prepared, submitting...');
    
    // Submit the form
    form.submit();
});

// ========== ACTION BUTTON FUNCTIONS ==========
function editTransaction(id) {
    // Load transaction data and open modal in edit mode
    fetch(`/admin/transactions/${id}`)
        .then(res => res.json())
        .then(data => {
            // Populate the wizard with existing data
            openTxnModal();
            // TODO: Fill form fields with data
            showToast('Edit functionality - coming soon', 'info');
        })
        .catch(err => {
            showToast('Failed to load transaction data', 'error');
        });
}

function deleteTransaction(id) {
    openDeleteModal(`/admin/transactions/${id}`, () => {
        // Refresh the page after successful delete
        location.reload();
    });
}
</script>
@endsection
