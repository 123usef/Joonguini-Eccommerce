<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            :root {
                --primary-color: #4f46e5;
                --primary-hover: #4338ca;
                --secondary-color: #f8fafc;
                --text-color: #1f2937;
                --border-color: #e5e7eb;
                --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }

            body {
                font-family: 'Figtree', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                margin: 0;
                padding: 0;
            }

            .auth-container {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }

            .auth-card {
                background: white;
                border-radius: 20px;
                box-shadow: var(--shadow);
                overflow: hidden;
                max-width: 450px;
                width: 100%;
                border: none;
            }

            .auth-header {
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
                color: white;
                padding: 40px 30px 30px;
                text-align: center;
                position: relative;
            }

            .auth-header::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
                opacity: 0.3;
            }

            .auth-header h1 {
                margin: 0;
                font-size: 2rem;
                font-weight: 600;
                position: relative;
                z-index: 1;
            }

            .auth-header p {
                margin: 10px 0 0;
                opacity: 0.9;
                position: relative;
                z-index: 1;
            }

            .auth-body {
                padding: 40px 30px;
            }

            .form-group {
                margin-bottom: 25px;
            }

            .form-label {
                font-weight: 500;
                color: var(--text-color);
                margin-bottom: 8px;
                display: block;
            }

            .form-control {
                border: 2px solid var(--border-color);
                border-radius: 12px;
                padding: 12px 16px;
                font-size: 16px;
                transition: all 0.3s ease;
                background: #f8fafc;
            }

            .form-control:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
                background: white;
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
                border: none;
                border-radius: 12px;
                padding: 14px 24px;
                font-weight: 600;
                font-size: 16px;
                width: 100%;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
            }

            .btn-link {
                color: var(--primary-color);
                text-decoration: none;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .btn-link:hover {
                color: var(--primary-hover);
                text-decoration: underline;
            }

            .divider {
                text-align: center;
                margin: 30px 0;
                position: relative;
            }

            .divider::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                height: 1px;
                background: var(--border-color);
            }

            .divider span {
                background: white;
                padding: 0 20px;
                color: #6b7280;
                font-size: 14px;
            }

            .alert {
                border-radius: 12px;
                border: none;
                padding: 15px 20px;
                margin-bottom: 20px;
            }

            .alert-danger {
                background: #fef2f2;
                color: #dc2626;
                border-left: 4px solid #dc2626;
            }

            .alert-success {
                background: #f0fdf4;
                color: #059669;
                border-left: 4px solid #059669;
            }

            .auth-footer {
                background: #f8fafc;
                padding: 20px 30px;
                text-align: center;
                border-top: 1px solid var(--border-color);
            }

            .social-login {
                margin-top: 20px;
            }

            .btn-social {
                border: 2px solid var(--border-color);
                background: white;
                color: var(--text-color);
                border-radius: 12px;
                padding: 12px;
                width: 100%;
                margin-bottom: 10px;
                transition: all 0.3s ease;
                font-weight: 500;
            }

            .btn-social:hover {
                border-color: var(--primary-color);
                background: var(--secondary-color);
                transform: translateY(-1px);
            }

            .remember-me {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 20px;
            }

            .form-check-input {
                border: 2px solid var(--border-color);
                border-radius: 6px;
            }

            .form-check-input:checked {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }

            @media (max-width: 576px) {
                .auth-header {
                    padding: 30px 20px 20px;
                }
                
                .auth-body {
                    padding: 30px 20px;
                }
                
                .auth-footer {
                    padding: 15px 20px;
                }
                
                .auth-header h1 {
                    font-size: 1.5rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="auth-container">
            @yield('content')
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>