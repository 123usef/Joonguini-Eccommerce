@extends('layouts.guest')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <i class="fas fa-user-circle fa-3x mb-3"></i>
        <h1>Welcome Back</h1>
        <p>Sign in to your account to continue</p>
    </div>

    <div class="auth-body">
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

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

        <form method="POST" action="{{ route('login') }}">
            @csrf

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
                       autofocus 
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
                       autocomplete="current-password"
                       placeholder="Enter your password" />
            </div>

            <!-- Remember Me -->
            <div class="remember-me">
                <input id="remember_me" 
                       type="checkbox" 
                       class="form-check-input" 
                       name="remember">
                <label for="remember_me" class="form-check-label">
                    Remember me
                </label>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                @if (Route::has('password.request'))
                    <a class="btn-link" href="{{ route('password.request') }}">
                        <i class="fas fa-key me-1"></i>Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sign-in-alt me-2"></i>Sign In
            </button>
        </form>

        <div class="divider">
            <span>or</span>
        </div>

        <div class="social-login">
            <button class="btn-social">
                <i class="fab fa-google me-2"></i>Continue with Google
            </button>
            <button class="btn-social">
                <i class="fab fa-facebook me-2"></i>Continue with Facebook
            </button>
        </div>
    </div>

    <div class="auth-footer">
        <p class="mb-0">
            Don't have an account? 
            <a href="{{ route('register') }}" class="btn-link">
                <i class="fas fa-user-plus me-1"></i>Create Account
            </a>
        </p>
    </div>
</div>
@endsection