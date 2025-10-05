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
                            <button class="btn-icon btn-view" title="View" onclick="openTxnView({{ $txn->transaction_id }})">
                                <i class="fas fa-eye"></i>
                            </button>
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

<!-- Create Transaction Modal -->
<div class="modal-overlay" id="txnModal">
    <div class="modal-content" style="max-width: 980px;">
        <div class="modal-header">
            <h2>Create Supplier Transaction</h2>
        </div>
        <form method="POST" action="{{ route('admin.transactions.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Reference Number <span class="required">*</span></label>
                        <input type="text" class="form-input" name="reference_num" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Supplier <span class="required">*</span></label>
                        <select class="form-select" name="supplier_id" id="supplierSelect" required>
                            <option value="">Select Supplier</option>
                            @foreach(($suppliers ?? []) as $s)
                                <option value="{{ $s->supplier_id }}">{{ $s->supplier_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Order Date <span class="required">*</span></label>
                        <input type="date" class="form-input" name="order_date" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Delivery Date</label>
                        <input type="date" class="form-input" name="delivery_date">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Delivery Fee</label>
                        <input type="number" step="0.01" class="form-input" name="delivery_fee" value="0">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Delivery Status</label>
                        <div style="display:flex; gap:1rem; align-items:center;">
                            <label style="display:flex; gap:0.5rem; align-items:center;">
                                <input type="radio" name="delivery_received" value="1"> Received
                            </label>
                            <label style="display:flex; gap:0.5rem; align-items:center;">
                                <input type="radio" name="delivery_received" value="0" checked> Not Received
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Estimated Date</label>
                        <input type="date" class="form-input" name="estimated_date">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tax <span class="required">*</span></label>
                        <input type="number" step="0.01" class="form-input" name="tax" value="0" required>
                    </div>
                </div>

                <div class="form-group full-width" style="margin-top: 1rem;">
                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <label class="form-label">Items <span class="required">*</span></label>
                        <button type="button" class="btn-add-supplier" onclick="addItemRow()"><i class="fas fa-plus"></i> Add Item</button>
                    </div>
                    <table class="supplier-table" style="margin-top: 0.5rem;">
                        <thead>
                            <tr>
                                <th style="width: 40%">Product</th>
                                <th style="width: 15%">Quantity</th>
                                <th style="width: 20%">Unit Price</th>
                                <th style="width: 20%">Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="itemsBody">
                            <tr>
                                <td>
                                    <select class="form-select" name="items[0][product_id]" onchange="syncUnitPrice(this)" required>
                                        @foreach(($products ?? []) as $p)
                                            <option value="{{ $p->product_id }}" data-price="{{ $p->base_price ?? 0 }}">{{ $p->product_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" class="form-input" name="items[0][quantity]" min="1" value="1" oninput="recalcRow(this)" required></td>
                                <td><input type="number" step="0.01" class="form-input" name="items[0][unit_price]" value="0" oninput="recalcRow(this)" required></td>
                                <td><input type="number" step="0.01" class="form-input" name="items[0][total]" min="0" value="0" required></td>
                                <td><button type="button" class="btn-icon btn-reject" onclick="removeItemRow(this)" title="Remove"><i class="fas fa-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="display:flex; gap:1rem; margin-top:1rem;">
                        <div style="flex:1;">
                            <label class="form-label">Sub Total (auto)</label>
                            <input type="number" step="0.01" class="form-input" id="subTotal" value="0" readonly>
                        </div>
                        <div style="flex:1;">
                            <label class="form-label">Overall Total (auto)</label>
                            <input type="number" step="0.01" class="form-input" id="overallTotal" value="0" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group full-width" id="supplierHistory" style="display:none; margin-top: 1rem;">
                    <label class="form-label">Recent Transactions for Supplier</label>
                    <table class="supplier-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Reference #</th>
                                <th>Order Date</th>
                                <th>Delivery Date</th>
                                <th>Overall Total</th>
                                <th>Tax</th>
                            </tr>
                        </thead>
                        <tbody id="historyList"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeTxnModal()">Cancel</button>
                <button type="submit" class="btn-save">Create Transaction</button>
            </div>
        </form>
    </div>
</div>

<style>
.modal-overlay {
    display: none;
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}
.modal-overlay.active { display: flex; }
.modal-content {
    background: #fff;
    border-radius: 0.75rem;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
}
.modal-header { padding: 1.5rem 2rem; border-bottom: 1px solid #e2e8f0; }
.modal-body { padding: 2rem; }
.modal-footer { padding: 1.5rem 2rem; border-top: 1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:1rem; }
.form-grid { display:grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
.form-group { display:flex; flex-direction:column; gap:0.5rem; }
.form-label { font-size: 0.875rem; font-weight: 500; color: #334155; }
.form-input, .form-select { width:100%; padding:0.75rem 1rem; border:1px solid #cbd5e1; border-radius:0.5rem; font-size:0.875rem; }
@media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } }
</style>

<script>
function openTxnModal(){ document.getElementById('txnModal').classList.add('active'); document.body.style.overflow='hidden'; }
function closeTxnModal(){ document.getElementById('txnModal').classList.remove('active'); document.body.style.overflow=''; }
// Close when clicking overlay
document.getElementById('txnModal').addEventListener('click', function(e){ if (e.target === this) closeTxnModal(); });
// Close on ESC
document.addEventListener('keydown', function(e){ if (e.key === 'Escape'){ closeTxnModal(); }});

function openTxnView(id){}

let itemIndex = 1;
function addItemRow(){
    const tbody = document.getElementById('itemsBody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td>
            <select class="form-select" name="items[${itemIndex}][product_id]" onchange="syncUnitPrice(this)" required>
                ${`@foreach(($products ?? []) as $p)<option value="{{ $p->product_id }}" data-price="{{ $p->base_price ?? 0 }}">{{ $p->product_name }}</option>@endforeach`}
            </select>
        </td>
        <td><input type="number" class="form-input" name="items[${itemIndex}][quantity]" min="1" value="1" oninput="recalcRow(this)" required></td>
        <td><input type="number" step="0.01" class="form-input" name="items[${itemIndex}][unit_price]" value="0" oninput="recalcRow(this)" required></td>
        <td><input type="number" step="0.01" class="form-input" name="items[${itemIndex}][total]" min="0" value="0" required></td>
        <td><button type="button" class="btn-icon btn-reject" onclick="removeItemRow(this)" title="Remove"><i class="fas fa-trash"></i></button></td>
    `;
    tbody.appendChild(tr);
    itemIndex++;
    const select = tr.querySelector('select');
    syncUnitPrice(select);
    recalcTotals();
}
function removeItemRow(btn){ btn.closest('tr').remove(); recalcTotals(); }

function recalcRow(el){
    const tr = el.closest('tr');
    const qty = parseFloat(tr.querySelector('input[name$="[quantity]"]').value||'0');
    const unit = parseFloat(tr.querySelector('input[name$="[unit_price]"]').value||'0');
    const totalInput = tr.querySelector('input[name$="[total]"]');
    if (document.activeElement !== totalInput) {
        totalInput.value = (qty * unit).toFixed(2);
    }
    recalcTotals();
}

function recalcTotals(){
    const totals = Array.from(document.querySelectorAll('#itemsBody input[name$="[total]"]'));
    let sum = 0;
    totals.forEach(input => { const v = parseFloat(input.value||'0'); if (!isNaN(v)) sum += v; });
    const tax = parseFloat(document.querySelector('input[name="tax"]').value||'0');
    const fee = parseFloat(document.querySelector('input[name="delivery_fee"]').value||'0');
    document.getElementById('subTotal').value = sum.toFixed(2);
    document.getElementById('overallTotal').value = (sum + tax + fee).toFixed(2);
}

function syncUnitPrice(select){
    const tr = select.closest('tr');
    const price = parseFloat(select.options[select.selectedIndex].getAttribute('data-price')||'0');
    const unitInput = tr.querySelector('input[name$="[unit_price]"]');
    if (unitInput) unitInput.value = price.toFixed(2);
    recalcRow(unitInput);
}

// Recalc on tax/fee/total changes
document.addEventListener('input', function(e){
    if (!e.target) return;
    if (e.target.name === 'tax' || e.target.name === 'delivery_fee' || (e.target.name && (e.target.name.endsWith('[total]') || e.target.name.endsWith('[unit_price]') || e.target.name.endsWith('[quantity]')))){
        if (e.target.name.endsWith('[total]')) recalcTotals(); else recalcRow(e.target);
    }
});

// Supplier history loader
document.getElementById('supplierSelect')?.addEventListener('change', async function(){
    const supplierId = this.value; const panel = document.getElementById('supplierHistory'); const list = document.getElementById('historyList');
    if (!supplierId) { panel.style.display='none'; list.innerHTML=''; return; }
    try {
        const res = await fetch(`/admin/transactions/supplier/${supplierId}/history`);
        const data = await res.json();
        if (data.success){
            panel.style.display='block';
            if (data.data.length){
                list.innerHTML = data.data.map(r => `
                    <tr>
                        <td>${r.transaction_id}</td>
                        <td>${r.reference_num}</td>
                        <td>${r.order_date}</td>
                        <td>${r.delivery_date ?? '-'}</td>
                        <td>₱${parseFloat(r.overall_total).toFixed(2)}</td>
                        <td>₱${parseFloat(r.tax).toFixed(2)}</td>
                    </tr>
                `).join('');
            } else {
                list.innerHTML = '<tr><td colspan="6" style="text-align:center; color:#64748b;">No previous transactions.</td></tr>';
            }
        } else { panel.style.display='block'; list.innerHTML = '<tr><td colspan="6">Could not load history.</td></tr>'; }
    } catch (e){ panel.style.display='block'; list.innerHTML = '<tr><td colspan="6">Could not load history.</td></tr>'; }
});
</script>
@endsection
