<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('customer.home') }}">
            <img src="/images/logo.png" alt="8PLY TIRE AND SERVICES" height="40" class="d-inline-block align-text-top me-2">
            8PLY TIRE AND SERVICES
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.products') }}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.services') }}">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.booking') }}">Book Service</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.feedback') }}">Feedback</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.cart') }}">
                        <i class="fas fa-shopping-cart"></i>
                        Cart <span id="cartCount" class="badge bg-primary">0</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i> My Account
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('customer.profile') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('customer.orders') }}">My Orders</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('customer.logout') }}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
