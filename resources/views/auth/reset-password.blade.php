@extends('layouts.guest')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <i class="fas fa-shield-alt fa-3x mb-3"></i>
        <h1>Reset Password</h1>
        <p>Create a new secure password</p>
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

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope me-2"></i>Email Address
                </label>
                <input id="email" 
                       class="form-control" 
                       type="email" 
                       name="email" 
                       value="{{ old('email', $request->email) }}" 
                       required 
                       autofocus 
                       autocomplete="username"
                       placeholder="Enter your email address" />
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="fas fa-lock me-2"></i>New Password
                </label>
                <input id="password" 
                       class="form-control" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="new-password"
                       placeholder="Enter your new password" />
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
                       placeholder="Confirm your new password" />
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-shield-alt me-2"></i>Reset Password
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