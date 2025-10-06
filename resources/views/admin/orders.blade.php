@extends('layouts.admin.app')

@section('title', 'Orders Management')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Orders Management</h1>
        <button class="btn-add-supplier">
            <i class="fas fa-plus"></i>
            New Order
        </button>
    </div>

    <div class="stats-grid">
        <!-- ...existing stat cards... -->
    </div>

    <div class="content-card">
        <div class="table-controls">
            <div class="search-wrapper" style="display: flex; align-items: center;">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="liveOrderSearchInput" class="search-input" placeholder="Search orders by customer, product, or status..." autocomplete="off">
            </div>
            <!-- ...existing filter controls... -->
        </div>

        <div class="table-responsive">
            <table class="supplier-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="checkbox-all">
                        </th>
                        <th class="sortable">
                            Order ID
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Customer Name
                            <i class="fas fa-sort"></i>
                        </th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Discount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Products</th>
                        <th class="actions-header">
                            Actions
                            <i class="fas fa-info-circle tooltip-icon"></i>
                        </th>
                    </tr>
                </thead>
                <tbody id="ordersTableBody">
                    @foreach($orders as $order)
                        <tr>
                            <td><input type="checkbox" class="row-checkbox"></td>
                            <td class="supplier-id">{{ $order->order_id }}</td>
                            <td class="supplier-name">
                                {{ $order->user->fname ?? 'N/A' }} {{ $order->user->lname ?? '' }}
                                <br>
                                <small>{{ $order->user->email ?? 'N/A' }}</small>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
                            <td class="transaction-amount">₱{{ number_format($order->total_amount, 2) }}</td>
                            <td>{{ $order->discount }}%</td>
                            <td>{{ $order->payment_method }}</td>
                            <td>
                                <span class="payment-badge status-{{ strtolower($order->status ?? 'pending') }}">
                                    {{ ucfirst($order->status ?? 'Pending') }}
                                </span>
                            </td>
                            <td>
                                <ul>
                                    @foreach($order->items as $item)
                                        <li>
                                            <strong>{{ $item->product->product_name ?? 'N/A' }}</strong>
                                            (Qty: {{ $item->quantity }},
                                            Price: ₱{{ number_format($item->price, 2) }})
                                            <br>
                                            <small>
                                                Brand: {{ $item->product->brand ?? '-' }},
                                                Size: {{ $item->product->size ?? '-' }},
                                                Serial #: {{ $item->product->serial_number ?? '-' }}
                                            </small>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="actions-cell">
                                @if(strtolower($order->status) === 'pending')
                                    <form action="{{ route('admin.orders.approve', $order) }}" method="POST" style="display:inline" onsubmit="return confirmApprove()">
                                        @csrf
                                        <input type="hidden" name="approved_note" value="Approved by admin">
                                        <button class="btn-icon btn-view" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.orders.reject', $order) }}" method="POST" style="display:inline" onsubmit="return confirmReject(this)">
                                        @csrf
                                        <input type="hidden" name="rejected_reason" value="">
                                        <button class="btn-icon btn-edit" title="Reject">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn-icon btn-view" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="showing-info">
                Showing <strong>{{ $orders->firstItem() ?? 1 }}-{{ $orders->lastItem() ?? $orders->count() }}</strong> of <strong>{{ $orders->total() ?? $orders->count() }}</strong>
            </div>
            <div class="pagination">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmApprove() {
    return confirm('Are you sure you want to approve this order? Inventory will be deducted.');
}

function confirmReject(form) {
    const reason = prompt('Enter reason for rejection:');
    if (!reason) return false;
    form.querySelector('input[name="rejected_reason"]').value = reason;
    return confirm('Are you sure you want to reject this order?');
}
document.getElementById('liveOrderSearchInput').addEventListener('input', function() {
    var search = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '{{ route('admin.orders') }}?search=' + encodeURIComponent(search), true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Extract only the table body from the response
            var parser = new DOMParser();
            var doc = parser.parseFromString(xhr.responseText, 'text/html');
            var newTbody = doc.getElementById('ordersTableBody');
            if (newTbody) {
                document.getElementById('ordersTableBody').innerHTML = newTbody.innerHTML;
            }
        }
    };
    xhr.send();
});
</script>
@endsection
