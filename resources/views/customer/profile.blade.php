@extends('layouts.customer.app')

@section('content')
<!-- Profile Header -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="section-title">My Profile</h1>
        <p class="lead">Manage your account information and preferences</p>
    </div>
</section>

<!-- Profile Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-4">
                <div class="profile-card text-center">
                    <div class="profile-picture mb-3">
                        <img src="/images/user-avatar.jpg" alt="Profile Picture" class="rounded-circle" width="120" height="120">
                    </div>
                    <h4>Juan Dela Cruz</h4>
                    <p class="text-muted">Customer since 2020</p>
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-bag me-2"></i>My Orders
                        </a>
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-comment me-2"></i>My Feedback
                        </a>
                    </div>
                </div>

                <div class="profile-card mt-4">
                    <h6>Account Statistics</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Orders:</span>
                        <strong>12</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Pending Orders:</span>
                        <strong>2</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Completed Orders:</span>
                        <strong>10</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Total Spent:</span>
                        <strong>P45,800</strong>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-8">
                <!-- Personal Information -->
                <div class="profile-card">
                    <h4 class="mb-4">Personal Information</h4>
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" value="Juan" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" value="Dela Cruz" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" value="juan.delacruz@example.com" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" value="09123456789" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" rows="3" required>123 Sample Street, Cebu City</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="profile-card mt-4">
                    <h4 class="mb-4">Change Password</h4>
                    <form>
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="currentPassword" required>
                        </div>

                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmPassword" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
