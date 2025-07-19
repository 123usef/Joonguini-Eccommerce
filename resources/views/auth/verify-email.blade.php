@extends('layouts.guest')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <i class="fas fa-envelope-open fa-3x mb-3"></i>
        <h1>Verify Email</h1>
        <p>Check your inbox for verification</p>
    </div>

    <div class="auth-body">
        <div class="mb-4 text-muted">
            <i class="fas fa-info-circle me-2"></i>
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                A new verification link has been sent to the email address you provided during registration.
            </div>
        @endif

        <div class="mt-4 d-flex justify-content-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-2"></i>
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Log Out
                </button>
            </form>
        </div>
    </div>

    <div class="auth-footer">
        <p class="mb-0 text-muted">
            <i class="fas fa-shield-alt me-2"></i>
            Email verification helps keep your account secure
        </p>
    </div>
</div>
@endsection