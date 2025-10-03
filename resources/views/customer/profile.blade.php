@extends('layouts.customer.app')

@section('content')
<!-- Profile Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="section-title text-start mb-2">My Profile</h1>
                <p class="lead mb-0">Manage your account information, preferences, and track your orders</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <span class="badge bg-success fs-6">
                    <i class="fas fa-check-circle me-1"></i>Verified Account
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Profile Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Left Column - Profile Sidebar -->
            <div class="col-lg-4">
                <!-- Profile Card -->
                <div class="card profile-sidebar-card mb-4">
                    <div class="card-body text-center">
                        <div class="profile-picture-wrapper mb-3">
                            <div class="profile-picture">
                                <img src="/images/user-avatar.jpg" alt="Profile Picture" class="rounded-circle">
                                <button class="btn btn-primary btn-sm edit-photo-btn" onclick="triggerPhotoUpload()">
                                    <i class="fas fa-camera"></i>
                                </button>
                                <input type="file" id="photoUpload" class="d-none" accept="image/*">
                            </div>
                        </div>
                        <h4 class="profile-name">Juan Dela Cruz</h4>
                        <p class="text-muted mb-3">
                            <i class="fas fa-map-marker-alt me-1 text-primary"></i>Cebu City, Philippines
                        </p>
                        <div class="member-badge mb-3">
                            <span class="badge bg-warning">
                                <i class="fas fa-crown me-1"></i>Gold Member
                            </span>
                        </div>
                        <p class="text-muted small">
                            <i class="fas fa-calendar-alt me-1"></i>Customer since 2020
                        </p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card profile-sidebar-card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="fas fa-bolt me-2 text-primary"></i>Quick Actions
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('customer.orders') }}" class="btn btn-outline-primary text-start">
                                <i class="fas fa-shopping-bag me-2"></i>My Orders
                            </a>
                            <a href="{{ route('customer.feedback') }}" class="btn btn-outline-primary text-start">
                                <i class="fas fa-comment me-2"></i>My Feedback
                            </a>
                            <a href="#" class="btn btn-outline-primary text-start">
                                <i class="fas fa-heart me-2"></i>Wishlist
                            </a>
                            <a href="#" class="btn btn-outline-primary text-start">
                                <i class="fas fa-bell me-2"></i>Notifications
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Account Statistics -->
                <div class="card profile-sidebar-card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="fas fa-chart-bar me-2 text-primary"></i>Account Statistics
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Total Orders</span>
                            <span class="fw-bold text-primary">12</span>
                        </div>
                        <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Pending Orders</span>
                            <span class="fw-bold text-warning">2</span>
                        </div>
                        <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Completed Orders</span>
                            <span class="fw-bold text-success">10</span>
                        </div>
                        <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Total Spent</span>
                            <span class="fw-bold text-primary">P45,800</span>
                        </div>
                        <div class="stat-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">Loyalty Points</span>
                            <span class="fw-bold text-info">1,250</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Profile Content -->
            <div class="col-lg-8">
                <!-- Personal Information -->
                <div class="card profile-content-card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-user me-2"></i>Personal Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="personalInfoForm">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="firstName" class="form-label">
                                        <i class="fas fa-user me-1 text-primary"></i>First Name
                                    </label>
                                    <input type="text" class="form-control" id="firstName" value="Juan" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="lastName" class="form-label">
                                        <i class="fas fa-user me-1 text-primary"></i>Last Name
                                    </label>
                                    <input type="text" class="form-control" id="lastName" value="Dela Cruz" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-1 text-primary"></i>Email Address
                                    </label>
                                    <input type="email" class="form-control" id="email" value="juan.delacruz@example.com" required>
                                    <div class="form-text">
                                        <i class="fas fa-check-circle text-success me-1"></i>Email verified
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">
                                        <i class="fas fa-phone me-1 text-primary"></i>Phone Number
                                    </label>
                                    <input type="tel" class="form-control" id="phone" value="09123456789" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">
                                    <i class="fas fa-map-marker-alt me-1 text-primary"></i>Address
                                </label>
                                <textarea class="form-control" id="address" rows="3" required>123 Sample Street, Cebu City, Cebu 6000</textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" value="Cebu City" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="province" class="form-label">Province</label>
                                    <input type="text" class="form-control" id="province" value="Cebu" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="zipCode" class="form-label">ZIP Code</label>
                                    <input type="text" class="form-control" id="zipCode" value="6000" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Profile
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                    <i class="fas fa-undo me-2"></i>Reset Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="card profile-content-card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-lock me-2"></i>Change Password
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="passwordForm">
                            <div class="mb-3">
                                <label for="currentPassword" class="form-label">
                                    <i class="fas fa-key me-1 text-primary"></i>Current Password
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="currentPassword" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('currentPassword')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="newPassword" class="form-label">
                                    <i class="fas fa-lock me-1 text-primary"></i>New Password
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="newPassword" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('newPassword')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="form-text">
                                    Password must be at least 8 characters with numbers and symbols
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">
                                    <i class="fas fa-lock me-1 text-primary"></i>Confirm New Password
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirmPassword" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key me-2"></i>Change Password
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="resetPasswordForm()">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Communication Preferences -->
                <div class="card profile-content-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-bell me-2"></i>Communication Preferences
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="preferencesForm">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                    <label class="form-check-label" for="emailNotifications">
                                        Email Notifications
                                    </label>
                                </div>
                                <small class="text-muted">Receive order updates, promotions, and newsletters via email</small>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="smsNotifications">
                                    <label class="form-check-label" for="smsNotifications">
                                        SMS Notifications
                                    </label>
                                </div>
                                <small class="text-muted">Receive important updates via SMS</small>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="promotionalEmails" checked>
                                    <label class="form-check-label" for="promotionalEmails">
                                        Promotional Emails
                                    </label>
                                </div>
                                <small class="text-muted">Receive special offers, discounts, and product announcements</small>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="serviceReminders" checked>
                                    <label class="form-check-label" for="serviceReminders">
                                        Service Reminders
                                    </label>
                                </div>
                                <small class="text-muted">Get reminders for upcoming vehicle services and maintenance</small>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Preferences
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submissions
    document.getElementById('personalInfoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        showNotification('Profile updated successfully!', 'success');
    });

    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (newPassword !== confirmPassword) {
            showNotification('Passwords do not match!', 'error');
            return;
        }

        if (newPassword.length < 8) {
            showNotification('Password must be at least 8 characters long!', 'error');
            return;
        }

        showNotification('Password changed successfully!', 'success');
        resetPasswordForm();
    });

    document.getElementById('preferencesForm').addEventListener('submit', function(e) {
        e.preventDefault();
        showNotification('Preferences saved successfully!', 'success');
    });
});

function triggerPhotoUpload() {
    document.getElementById('photoUpload').click();
}

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.parentElement.querySelector('button');
    const icon = button.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

function resetForm() {
    document.getElementById('personalInfoForm').reset();
    showNotification('Form reset to original values', 'info');
}

function resetPasswordForm() {
    document.getElementById('passwordForm').reset();
}

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    // Add to page
    const container = document.querySelector('.container');
    container.insertBefore(notification, container.firstChild);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Handle photo upload
document.getElementById('photoUpload').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            document.querySelector('.profile-picture img').src = e.target.result;
            showNotification('Profile picture updated successfully!', 'success');
        }

        reader.readAsDataURL(this.files[0]);
    }
});
</script>

<style>
.profile-sidebar-card, .profile-content-card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.profile-picture-wrapper {
    position: relative;
    display: inline-block;
}

.profile-picture {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto;
}

.profile-picture img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.edit-photo-btn {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-name {
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.member-badge .badge {
    font-size: 0.8rem;
    padding: 0.5rem 1rem;
}

.stat-item {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.stat-item:last-child {
    border-bottom: none;
}

.form-check.form-switch {
    padding-left: 3.5rem;
}

.form-check-input:checked {
    background-color: #3498db;
    border-color: #3498db;
}

.input-group .btn {
    border-left: none;
}

.input-group .form-control:focus {
    border-right: none;
}

.alert {
    border-radius: 0.75rem;
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .profile-picture {
        width: 100px;
        height: 100px;
    }

    .profile-sidebar-card {
        margin-bottom: 1.5rem;
    }
}
</style>
@endsection
