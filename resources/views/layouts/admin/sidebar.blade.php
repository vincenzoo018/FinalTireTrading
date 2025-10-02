<aside class="sidebar">
    <div class="sidebar-header">
        <h2 class="logo">Admin Panel</h2>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle">
                    <i class="fas fa-box"></i>
                    <span>Product</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('admin.categories') }}">Product Category</a></li>
                    <li><a href="{{ route('admin.product') }}">Product List</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.inventory') }}" class="nav-link {{ request()->routeIs('admin.inventory') ? 'active' : '' }}">
                    <i class="fas fa-warehouse"></i>
                    <span>Inventory</span>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('admin.supplier*') ? 'active' : '' }}">
                    <i class="fas fa-truck"></i>
                    <span>Supplier</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('admin.supplier') }}">Supplier List</a></li>
                    <li><a href="{{ route('admin.transactions') }}">Supplier Transaction</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.services') }}" class="nav-link {{ request()->routeIs('admin.services') ? 'active' : '' }}">
                    <i class="fas fa-concierge-bell"></i>
                    <span>Services</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.bookings') }}" class="nav-link {{ request()->routeIs('admin.bookings') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Booking</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.orders') }}" class="nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.sales') }}" class="nav-link {{ request()->routeIs('admin.sales') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Sales</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.customers') }}" class="nav-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Customer</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.employee') }}" class="nav-link {{ request()->routeIs('admin.employee') ? 'active' : '' }}">
                    <i class="fas fa-user-tie"></i>
                    <span>Employee</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
