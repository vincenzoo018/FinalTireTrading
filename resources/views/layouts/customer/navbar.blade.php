<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('customer.home') }}">
            <img src="/images/logo.png" alt="8PLY TIRE AND SERVICES" height="45" class="d-inline-block align-text-top me-2">
            <span class="brand-text">8PLY TIRE AND SERVICES</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.home') ? 'active' : '' }}" href="{{ route('customer.home') }}">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.products') ? 'active' : '' }}" href="{{ route('customer.products') }}">
                        <i class="fas fa-tire me-1"></i>Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.services') ? 'active' : '' }}" href="{{ route('customer.services') }}">
                        <i class="fas fa-tools me-1"></i>Services
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.booking') ? 'active' : '' }}" href="{{ route('customer.booking') }}">
                        <i class="fas fa-calendar-alt me-1"></i>Book Service
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.feedback') ? 'active' : '' }}" href="{{ route('customer.feedback') }}">
                        <i class="fas fa-comment-dots me-1"></i>Feedback
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link position-relative" href="{{ route('customer.cart') }}">
                        <i class="fas fa-shopping-cart me-1"></i>
                        Cart <span id="cartCount" class="badge bg-primary position-absolute top-0 start-100 translate-middle">0</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i> My Account
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('customer.profile') }}">
                            <i class="fas fa-user me-2"></i>Profile
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('customer.orders') }}">
                            <i class="fas fa-clipboard-list me-2"></i>My Orders
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="{{ route('customer.logout') }}">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
