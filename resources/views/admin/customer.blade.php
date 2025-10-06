@extends('layouts.admin.app')

@section('title', 'Customers Management')

@section('content')
<div class="supplier-container">
    <div class="page-header">
        <h1 class="page-title">Customers Management</h1>
        
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #3498db;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>1,254</h3>
                <p>Total Customers</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #2ecc71;">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info">
                <h3>1,089</h3>
                <p>Active Customers</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #f39c12;">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="stat-info">
                <h3>45</h3>
                <p>New This Month</p>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="table-controls">
            <form method="GET" class="search-wrapper" style="display:flex; align-items:center; gap:.75rem;">
                <i class="fas fa-search search-icon"></i>
                <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Search name, email, username, phone...">
                <div class="filter-wrapper">
                    <select name="status" class="btn-filter" style="padding-right: 2rem;">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status')==='active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status')==='inactive' ? 'selected' : '' }}>Disabled</option>
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
                        <th class="sortable">
                            Customer ID
                            <i class="fas fa-sort"></i>
                        </th>
                        <th class="sortable">
                            Full Name
                            <i class="fas fa-sort"></i>
                        </th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>Address</th>
                        <th>Total Orders</th>
                        <th>Status</th>
                        <th class="actions-header">
                            Actions
                            <i class="fas fa-info-circle tooltip-icon"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($customers ?? []) as $user)
                        <tr>
                            <td><input type="checkbox" class="row-checkbox"></td>
                            <td class="supplier-id">{{ $user->user_id }}</td>
                            <td class="supplier-name">{{ $user->fname }} {{ $user->lname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->address }}</td>
                            <td><span class="order-count">{{ method_exists($user, 'orders') ? $user->orders()->count() : 0 }}</span></td>
                            <td>
                                <span class="payment-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">{{ $user->is_active ? 'Active' : 'Disabled' }}</span>
                            </td>
                            <td class="actions-cell">
                                @if(Auth::check() && Auth::user()->role_id === 1)
                                    <form action="{{ route('admin.customers.toggle', $user) }}" method="POST" style="display:inline" onsubmit="return confirmToggle(this, {{ $user->is_active ? 1 : 0 }})">
                                        @csrf
                                        <input type="hidden" name="ban_reason" value="">
                                        <button class="btn-icon btn-edit" title="{{ $user->is_active ? 'Disable' : 'Enable' }}">
                                            <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.customers.reset', $user) }}" method="POST" style="display:inline" onsubmit="return confirm('Reset password for this user? A temporary password will be generated.')">
                                        @csrf
                                        <button class="btn-icon btn-view" title="Reset Password">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align:center; padding: 2rem; color: #64748b;">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="showing-info">
                @isset($customers)
                    Showing <strong>{{ $customers->firstItem() ?? 0 }}-{{ $customers->lastItem() ?? 0 }}</strong> of <strong>{{ $customers->total() ?? 0 }}</strong>
                @endisset
            </div>

            <div class="pagination">
                @isset($customers)
                    {{ $customers->appends(request()->query())->links() }}
                @endisset
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmToggle(form, isActive) {
    if (!isActive) return confirm('Enable this account?');
    const reason = prompt('Enter ban/disable reason (optional):');
    if (reason === null) return false;
    form.querySelector('input[name="ban_reason"]').value = reason || '';
    return true;
}
</script>
@endsection
