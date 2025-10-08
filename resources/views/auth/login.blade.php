<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - 8PLY Tires & Services</title>
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
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.1) 0%, transparent 50%);
            animation: rotate 20s linear infinite;
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
            max-width: 400px;
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
            width: 60px;
            height: 60px;
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

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
        }

        .forgot-password:hover {
            text-decoration: underline;
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

        .form-check-label {
            font-size: 14px;
            color: var(--dark);
        }

        .invalid-feedback {
            font-size: 13px;
            color: #dc2626;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="auth-container">
                    <div class="auth-header">
                        <div class="logo">
                            <div class="logo-icon">
                                <i class="fas fa-tire fa-2x"></i>
                            </div>
                            <div class="logo-text">8PLY</div>
                        </div>
                        <p class="mb-0" style="opacity: 0.9;">Tires & Services</p>
                    </div>

                    <div class="auth-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <strong>Error!</strong> {{ $errors->first() }}
                            </div>
                        @endif

                        @if(session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('auth.login') }}">
                            @csrf

                            <label for="username" class="form-label">Username</label>
<input type="text" class="form-control @error('username') is-invalid @enderror"
       id="username" name="username" value="{{ old('username') }}"
       placeholder="Enter your username" required autofocus>
@error('username')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror


                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" placeholder="Enter your password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div class="remember-forgot">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="forgot-password">Forgot password?</a>
                            </div> --}}

                            <button type="submit" class="btn btn-primary w-100 mb-3">Sign In</button>
                        </form>

                        <div class="divider">
                            <span class="divider-text">Or continue with</span>
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
                        Don't have an account? <a href="{{ route('auth.register') }}">Sign up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
