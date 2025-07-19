@extends('layouts.guest')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <i class="fas fa-user-plus fa-3x mb-3"></i>
        <h1>Create Account</h1>
        <p>Join us and start shopping today</p>
    </div>

    <div class="auth-body">
        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">
                    <i class="fas fa-user me-2"></i>Full Name
                </label>
                <input id="name" 
                       class="form-control" 
                       type="text" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required 
                       autofocus 
                       autocomplete="name"
                       placeholder="Enter your full name" />
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope me-2"></i>Email Address
                </label>
                <input id="email" 
                       class="form-control" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autocomplete="username"
                       placeholder="Enter your email address" />
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="fas fa-lock me-2"></i>Password
                </label>
                <input id="password" 
                       class="form-control"
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="new-password"
                       placeholder="Create a strong password" />
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Password must be at least 8 characters long
                </small>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">
                    <i class="fas fa-lock me-2"></i>Confirm Password
                </label>
                <input id="password_confirmation" 
                       class="form-control"
                       type="password" 
                       name="password_confirmation" 
                       required 
                       autocomplete="new-password"
                       placeholder="Confirm your password" />
            </div>

            <!-- Terms and Conditions -->
            <div class="remember-me">
                <input id="terms" 
                       type="checkbox" 
                       class="form-check-input" 
                       name="terms"
                       required>
                <label for="terms" class="form-check-label">
                    I agree to the 
                    <a href="{{ route('terms-of-service') }}" class="btn-link" target="_blank">Terms of Service</a> 
                    and 
                    <a href="{{ route('privacy-policy') }}" class="btn-link" target="_blank">Privacy Policy</a>
                </label>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i>Create Account
            </button>
        </form>

        <div class="divider">
            <span>or</span>
        </div>

        <div class="social-login">
            <button class="btn-social">
                <i class="fab fa-google me-2"></i>Sign up with Google
            </button>
            <button class="btn-social">
                <i class="fab fa-facebook me-2"></i>Sign up with Facebook
            </button>
        </div>
    </div>

    <div class="auth-footer">
        <p class="mb-0">
            Already have an account? 
            <a href="{{ route('login') }}" class="btn-link">
                <i class="fas fa-sign-in-alt me-1"></i>Sign In
            </a>
        </p>
    </div>
</div>
@endsection