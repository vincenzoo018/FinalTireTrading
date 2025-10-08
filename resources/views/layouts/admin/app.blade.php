<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* User Profile Dropdown Styles */
        .user-profile {
            position: relative;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }

        .user-profile:hover {
            background-color: #f8fafc;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: #3b82f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
        }

        .user-name {
            font-weight: 500;
            color: #1e293b;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            min-width: 280px;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }

        .dropdown.active .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar-large {
            width: 48px;
            height: 48px;
            background: #3b82f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .user-details h4 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
        }

        .user-details p {
            margin: 0.25rem 0 0 0;
            font-size: 0.875rem;
            color: #64748b;
        }

        .user-role {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            margin-top: 0.5rem;
            padding: 0.25rem 0.5rem;
            background: #f1f5f9;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: #475569;
        }

        .user-role i {
            color: #3b82f6;
        }

        .dropdown-divider {
            height: 1px;
            background: #e2e8f0;
            margin: 0.5rem 0;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: #475569;
            text-decoration: none;
            transition: background-color 0.2s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-size: 0.875rem;
        }

        .dropdown-item:hover {
            background-color: #f8fafc;
            color: #1e293b;
        }

        .dropdown-item i {
            width: 16px;
            color: #64748b;
        }

        .logout-btn {
            color: #dc2626 !important;
        }

        .logout-btn:hover {
            background-color: #fef2f2 !important;
            color: #b91c1c !important;
        }

        .logout-btn i {
            color: #dc2626;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        @include('layouts.admin.sidebar')

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Navigation -->
            <header class="top-nav">
                <div class="nav-left">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="search-container">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search...">
                    </div>
                </div>
                <div class="nav-right">
                    <div class="user-profile dropdown">
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="user-name">{{ Auth::user()->fname ?? 'Admin' }}</span>
                        <i class="fas fa-chevron-down dropdown-toggle"></i>
                        <div class="dropdown-menu">
                            <div class="dropdown-header">
                                <div class="user-info">
                                    <div class="user-avatar-large">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="user-details">
                                        <h4>{{ Auth::user()->fname }} {{ Auth::user()->lname }}</h4>
                                        <p>{{ Auth::user()->email }}</p>
                                        <span class="user-role">
                                            @if(Auth::user()->role_id == 1)
                                                <i class="fas fa-crown"></i> Administrator
                                            @elseif(Auth::user()->role_id == 2)
                                                <i class="fas fa-user-tie"></i> Employee
                                            @else
                                                <i class="fas fa-user"></i> User
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-user-cog"></i>
                                Profile Settings
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-cog"></i>
                                Account Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('auth.logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item logout-btn">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');

            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    mainContent.classList.toggle('sidebar-collapsed');
                });
            }

            // Enhanced Dropdown functionality with smooth animations
            document.querySelectorAll('.nav-item.dropdown').forEach(dropdown => {
                const toggle = dropdown.querySelector('.dropdown-toggle');
                const menu = dropdown.querySelector('.dropdown-menu');
                
                if (toggle && menu) {
                    toggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        // Close other dropdowns
                        document.querySelectorAll('.nav-item.dropdown').forEach(otherDropdown => {
                            if (otherDropdown !== dropdown && otherDropdown.classList.contains('active')) {
                                otherDropdown.classList.remove('active');
                            }
                        });
                        
                        dropdown.classList.toggle('active');
                    });
                }
            });

            // User profile dropdown
            const userProfile = document.querySelector('.user-profile');
            if (userProfile) {
                userProfile.addEventListener('click', function(e) {
                    e.stopPropagation();
                    this.classList.toggle('active');
                });
            }

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown').forEach(dropdown => {
                        dropdown.classList.remove('active');
                    });
                }
            });

            // Close sidebar when clicking on a link in mobile view
            document.querySelectorAll('.sidebar-nav a').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('active');
                        mainContent.classList.remove('sidebar-collapsed');
                    }
                });
            });

            // Add fade-in animation to content
            const contentWrapper = document.querySelector('.content-wrapper');
            if (contentWrapper) {
                contentWrapper.style.animation = 'fadeInUp 0.5s ease';
            }

            // Animate stat cards on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.stat-card, .card, .content-card').forEach(card => {
                observer.observe(card);
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');

            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
                mainContent.classList.remove('sidebar-collapsed');
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
