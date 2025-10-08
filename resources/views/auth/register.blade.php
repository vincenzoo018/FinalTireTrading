<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - 8PLY Tires & Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #818cf8;
            --secondary: #0ea5e9;
            --dark: #374151;
            --light: #f8fafc;
            --gray: #6b7280;
            --gray-light: #f3f4f6;
        }

        body {
            background: linear-gradient(135deg, var(--gray-light) 0%, #e0e7ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow-x: hidden;
            padding: 2rem 0;
        }

        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.1) 0%, transparent 50%);
            animation: rotate 20s linear infinite;
            z-index: 0;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            margin: 2rem auto;
            border: 1px solid rgba(255, 255, 255, 0.8);
            animation: fadeInUp 0.6s ease;
            position: relative;
            z-index: 1;
        }

        .auth-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 2rem 2rem;
            text-align: center;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            color: white;
            font-size: 24px;
            backdrop-filter: blur(10px);
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
        }

        .auth-body {
            padding: 2rem 2rem;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            transition: all 0.3s;
            background-color: var(--light);
        }

        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            background-color: white;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            font-size: 14px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
        }

        .auth-footer {
            text-align: center;
            padding: 1.5rem 2rem;
            background: var(--gray-light);
            border-top: 1px solid #e5e7eb;
            color: var(--gray);
        }

        .auth-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }

        .divider::before, .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #e5e7eb;
        }

        .divider-text {
            padding: 0 1rem;
            color: var(--gray);
            font-size: 14px;
        }

        .social-login {
            display: flex;
            gap: 10px;
            margin-bottom: 1.5rem;
        }

        .social-btn {
            flex: 1;
            padding: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            color: var(--gray);
        }

        .social-btn:hover {
            border-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .social-btn i {
            font-size: 18px;
        }

        .facebook {
            color: #3b5998;
        }

        .google {
            color: #db4437;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .alert {
            border-radius: 8px;
            border: none;
            padding: 12px 15px;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .password-requirements {
            font-size: 12px;
            color: var(--gray);
            margin-top: 5px;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .invalid-feedback {
            font-size: 13px;
            color: #dc2626;
        }

        .form-check-label {
            font-size: 14px;
            color: var(--dark);
        }

        .form-check-label a {
            color: var(--primary);
            text-decoration: none;
        }

        .form-check-label a:hover {
            text-decoration: underline;
        }

        /* Toast Notification Styles */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1055;
        }

        .success-toast {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            color: white;
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
        }

        .success-toast .toast-header {
            background: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .success-toast .btn-close {
            filter: invert(1);
        }
    </style>
</head>
<body>
    <!-- Toast Notification Container -->
    <div class="toast-container">
        <div id="successToast" class="toast success-toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto">Success!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <i class="fas fa-user-check me-2"></i>
                Your account has been created successfully!
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="auth-container">
                    <div class="auth-header">
                        <div class="logo">
                            <div class="logo-icon">
                                <i class="fas fa-tire"></i>
                            </div>
                            <div class="logo-text">8PLY</div>
                        </div>
                        <p class="mb-0" style="opacity: 0.9;">Create your account</p>
                    </div>

                    <div class="auth-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <strong>Error!</strong> Please check the form below for errors.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('auth.register') }}" id="registerForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fname" class="form-label">First Name</label>
                                        <input type="text" class="form-control @error('fname') is-invalid @enderror"
                                               id="fname" name="fname" value="{{ old('fname') }}"
                                               placeholder="Enter your first name" required>
                                        @error('fname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="lname" class="form-label">Last Name</label>
                                        <input type="text" class="form-control @error('lname') is-invalid @enderror"
                                               id="lname" name="lname" value="{{ old('lname') }}"
                                               placeholder="Enter your last name" required>
                                        @error('lname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="mname" class="form-label">Middle Name (Optional)</label>
                                <input type="text" class="form-control @error('mname') is-invalid @enderror"
                                       id="mname" name="mname" value="{{ old('mname') }}"
                                       placeholder="Enter your middle name">
                                @error('mname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                       id="username" name="username" value="{{ old('username') }}"
                                       placeholder="Choose a username" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address (Optional)</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}"
                                       placeholder="Enter your email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}"
                                       placeholder="Enter your phone number">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                       id="address" name="address" value="{{ old('address') }}"
                                       placeholder="Enter your address">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" placeholder="Create a password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="password-requirements">
                                    Must be at least 6 characters.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control"
                                       id="password_confirmation" name="password_confirmation"
                                       placeholder="Confirm your password" required>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input @error('terms') is-invalid @enderror"
                                           type="checkbox" name="terms" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#" class="text-primary">Terms of Service</a> and <a href="#" class="text-primary">Privacy Policy</a>
                                    </label>
                                    @error('terms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3" id="submitBtn">Create Account</button>
                        </form>

                        <div class="divider">
                            <span class="divider-text">Or sign up with</span>
                        </div>

                        <div class="social-login">
                            <button type="button" class="social-btn facebook">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button type="button" class="social-btn google">
                                <i class="fab fa-google"></i>
                            </button>
                        </div>
                    </div>

                    <div class="auth-footer">
                        Already have an account? <a href="{{ route('auth.login') }}">Sign in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the toast element
            const successToast = document.getElementById('successToast');
            const toast = new bootstrap.Toast(successToast);

            // Get the form and submit button
            const registerForm = document.getElementById('registerForm');
            const submitBtn = document.getElementById('submitBtn');

            // Check if we should show the success toast (for demo purposes)
            // In a real application, you would check for a success flag from the server
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                toast.show();
            }

            // Form submission handler
            registerForm.addEventListener('submit', function(e) {
                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Creating Account...';
                submitBtn.disabled = true;
                
                // Let the form submit naturally to the server
            });

            // Real-time password validation
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('password_confirmation');

            function validatePassword() {
                if (passwordField.value.length < 6) {
                    passwordField.classList.add('is-invalid');
                    document.querySelector('.password-requirements').innerHTML =
                        '<span style="color: #dc2626;">Password must be at least 6 characters</span>';
                } else {
                    passwordField.classList.remove('is-invalid');
                    document.querySelector('.password-requirements').innerHTML =
                        'Must be at least 6 characters.';
                }

                if (confirmPasswordField.value && passwordField.value !== confirmPasswordField.value) {
                    confirmPasswordField.classList.add('is-invalid');
                } else if (confirmPasswordField.value) {
                    confirmPasswordField.classList.remove('is-invalid');
                }
            }

            passwordField.addEventListener('input', validatePassword);
            confirmPasswordField.addEventListener('input', validatePassword);
        });
    </script>
</body>
</html>
