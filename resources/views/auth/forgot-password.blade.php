@extends('layouts.guest')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <i class="fas fa-key fa-3x mb-3"></i>
        <h1>Forgot Password</h1>
        <p>We'll send you a reset link to your email</p>
    </div>

    <div class="auth-body">
        <div class="mb-4 text-muted">
            <i class="fas fa-info-circle me-2"></i>
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
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

        <form method="POST" action="{{ route('password.email') }}">
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
                       placeholder="Enter your email address" />
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane me-2"></i>Send Reset Link
            </button>
        </form>
    </div>

    <div class="auth-footer">
        <p class="mb-0">
            Remember your password? 
            <a href="{{ route('login') }}" class="btn-link">
                <i class="fas fa-sign-in-alt me-1"></i>Back to Sign In
            </a>
        </p>
    </div>
</div>
@endsection