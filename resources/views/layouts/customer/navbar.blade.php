<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('customer.home') }}">
            <div class="logo-container">
                <div class="logo-icon">
                    <i class="fas fa-tire"></i>
                </div>
                <div class="logo-text-container">
                    <span class="logo-text">8PLY</span>
                    <span class="logo-subtitle">Tires & Services</span>
                </div>
            </div>
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.home') ? 'active' : '' }}" href="{{ route('customer.home') }}">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.products') ? 'active' : '' }}" href="{{ route('customer.products') }}">
                        <i class="fas fa-tire"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.services') ? 'active' : '' }}" href="{{ route('customer.services') }}">
                        <i class="fas fa-tools"></i> Services
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.booking') ? 'active' : '' }}" href="{{ route('customer.booking') }}">
                        <i class="fas fa-calendar-alt"></i> Bookings
                    </a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link position-relative cart-link" href="{{ route('customer.cart') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span id="cartCount" class="cart-badge">0</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar-small">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="d-none d-lg-inline ms-2">{{ Auth::user()->fname ?? 'Account' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end modern-dropdown" aria-labelledby="navbarDropdown">
                        <li class="dropdown-header">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar-dropdown">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="ms-3">
                                    <div class="fw-bold">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</div>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('customer.profile') }}">
                                <i class="fas fa-user me-2"></i>My Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('customer.orders') }}">
                                <i class="fas fa-clipboard-list me-2"></i>My Orders
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('customer.logout') }}">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
/* Modern Navbar Styles */
.navbar {
    padding: 0.75rem 0;
    transition: all 0.3s ease;
}

.logo-container {
    display: flex;
    align-items: center;
    gap: 12px;
}

.logo-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.logo-text-container {
    display: flex;
    flex-direction: column;
}

.logo-text {
    font-size: 24px;
    font-weight: 700;
    color: #1e293b;
    line-height: 1;
    letter-spacing: -0.5px;
}

.logo-subtitle {
    font-size: 11px;
    color: #64748b;
    font-weight: 500;
    letter-spacing: 0.5px;
}

.nav-link {
    color: #475569 !important;
    font-weight: 500;
    padding: 0.5rem 1rem !important;
    border-radius: 8px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.nav-link:hover {
    color: #4f46e5 !important;
    background-color: #f1f5f9;
}

.nav-link.active {
    color: #4f46e5 !important;
    background-color: #e0e7ff;
    font-weight: 600;
}

.nav-link i {
    font-size: 16px;
}

.cart-link {
    position: relative;
}

.cart-badge {
    position: absolute;
    top: 2px;
    right: 2px;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    border-radius: 10px;
    padding: 2px 6px;
    font-size: 11px;
    font-weight: 600;
    min-width: 18px;
    text-align: center;
}

.user-avatar-small {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
}

.user-avatar-dropdown {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.modern-dropdown {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    padding: 0.5rem 0;
    min-width: 280px;
}

.modern-dropdown .dropdown-header {
    padding: 1rem 1.25rem;
    background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
    border-radius: 12px 12px 0 0;
    margin-bottom: 0.5rem;
}

.modern-dropdown .dropdown-item {
    padding: 0.75rem 1.25rem;
    transition: all 0.2s ease;
    border-radius: 8px;
    margin: 0 0.5rem;
}

.modern-dropdown .dropdown-item:hover {
    background-color: #f1f5f9;
    transform: translateX(4px);
}

.modern-dropdown .dropdown-item i {
    width: 20px;
    text-align: center;
}

.navbar-toggler:focus {
    box-shadow: none;
}

@media (max-width: 991px) {
    .navbar-nav {
        padding: 1rem 0;
    }
    
    .nav-link {
        padding: 0.75rem 1rem !important;
    }
    
    .modern-dropdown {
        margin-top: 0.5rem;
    }
}
</style>
