@extends('layouts.app')

@section('content')

<style>
    body {
        background: #0f0f23 !important;
        margin: 0;
        padding: 0;
        font-family: 'Inter', Arial, sans-serif;
    }

    nav {
        display: none !important;
    }

    .sidebar {
        display: none !important;
    }

    .top-header {
        display: none !important;
    }

    .app-wrapper {
        display: block !important;
    }

    .main-content {
        margin-left: 0 !important;
    }

    .container {
        padding: 0 !important;
    }

    .auth-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        background: #0f0f23;
        position: relative;
        overflow: hidden;
    }

    /* Abstract shape in background */
    .auth-container::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 600px;
        height: 600px;
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        border-radius: 50%;
        opacity: 0.1;
        z-index: 0;
    }

    .auth-panel {
        width: 100%;
        max-width: 1000px;
        height: 600px;
        display: flex;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        position: relative;
        z-index: 1;
    }

    /* Left Panel - Welcome (Green Gradient) */
    .welcome-panel {
        width: 50%;
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
        border-radius: 20px 0 0 20px;
    }

    /* Abstract shapes */
    .welcome-panel::before {
        content: '';
        position: absolute;
        top: -50px;
        left: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .welcome-panel::after {
        content: '';
        position: absolute;
        bottom: -80px;
        right: -80px;
        width: 250px;
        height: 250px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .welcome-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .welcome-title {
        font-size: 42px;
        font-weight: 700;
        color: #FFFFFF;
        margin: 0 0 20px 0;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .welcome-subtitle {
        font-size: 16px;
        color: #FFFFFF;
        margin: 0 0 40px 0;
        opacity: 0.95;
        line-height: 1.6;
    }

    .welcome-button {
        padding: 14px 40px;
        border: 2px solid #FFFFFF;
        border-radius: 8px;
        background: transparent;
        color: #FFFFFF;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }

    .welcome-button:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-1px);
    }

    /* Right Panel - Form (Dark Glassmorphism) */
    .form-panel {
        width: 50%;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-radius: 0 20px 20px 0;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    .form-title {
        font-size: 32px;
        color: #ffffff;
        margin: 0 0 40px 0;
        font-weight: 600;
        text-align: center;
        text-decoration: underline;
        text-underline-offset: 8px;
    }

    .form-group {
        margin-bottom: 30px;
        position: relative;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        color: #9ca3af;
        font-size: 18px;
        z-index: 2;
    }

    .form-input {
        width: 100%;
        padding: 14px 14px 14px 50px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        font-family: inherit;
        background: rgba(255, 255, 255, 0.05);
        color: #e5e7eb;
        position: relative;
        border-left: 3px solid #10b981;
    }

    .form-input:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        background: rgba(255, 255, 255, 0.08);
    }

    .form-input::placeholder {
        color: #6b7280;
    }

    .is-invalid {
        border-color: #dc3545;
        border-left-color: #dc3545;
    }

    .error-text {
        font-size: 12px;
        color: #dc3545;
        margin-top: 6px;
        padding-left: 3px;
    }

    .submit-button {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 8px;
        background: #10b981;
        color: #FFFFFF;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        cursor: pointer;
        margin-top: 10px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .submit-button:hover {
        background: #34d399;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    .submit-button i {
        font-size: 18px;
    }

    /* Responsive - Tablet */
    @media (max-width: 1024px) {
        .auth-container {
            padding: 30px;
        }

        .auth-panel {
            max-width: 900px;
            height: auto;
            min-height: 500px;
        }

        .form-panel,
        .welcome-panel {
            padding: 50px 40px;
        }

        .form-title {
            font-size: 28px;
        }

        .welcome-title {
            font-size: 36px;
        }
    }

    /* Responsive - Mobile */
    @media (max-width: 768px) {
        .auth-container {
            padding: 20px;
        }

        .auth-panel {
            flex-direction: column;
            max-width: 100%;
            height: auto;
        }

        .welcome-panel {
            width: 100%;
            border-radius: 20px 20px 0 0;
            padding: 40px 30px;
            order: 1;
        }

        .form-panel {
            width: 100%;
            border-radius: 0 0 20px 20px;
            padding: 40px 30px;
            order: 2;
        }

        .form-title {
            font-size: 24px;
            margin-bottom: 30px;
        }

        .welcome-title {
            font-size: 28px;
        }

        .welcome-subtitle {
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 24px;
        }
    }

    /* Responsive - Small Mobile */
    @media (max-width: 480px) {
        .auth-container {
            padding: 16px;
        }

        .form-panel,
        .welcome-panel {
            padding: 30px 20px;
        }

        .form-title {
            font-size: 20px;
            margin-bottom: 24px;
        }

        .welcome-title {
            font-size: 24px;
        }

        .welcome-subtitle {
            font-size: 13px;
        }

        .form-input {
            padding: 12px 12px 12px 45px;
            font-size: 14px;
        }

        .input-icon {
            font-size: 16px;
            left: 12px;
        }

        .submit-button {
            padding: 12px;
            font-size: 14px;
        }

        .welcome-button {
            padding: 12px 30px;
            font-size: 14px;
        }
    }
</style>

<div class="auth-container">
    <div class="auth-panel">
        <!-- Left Panel - Welcome -->
        <div class="welcome-panel">
            <div class="welcome-content">
                <h2 class="welcome-title">WELCOME!</h2>
                <p class="welcome-subtitle">Enter your details and start journey with us</p>
                <a href="/login" class="welcome-button">LOG IN</a>
            </div>
        </div>

        <!-- Right Panel - Form -->
        <div class="form-panel">
            <h1 class="form-title">Register please</h1>

            <form method="POST" action="/register">
                @csrf

                {{-- Name --}}
                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="form-input @error('name') is-invalid @enderror"
                            placeholder="Input your name"
                            required
                        >
                    </div>
                    @error('name')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-input @error('email') is-invalid @enderror"
                            placeholder="Input your user ID or Email"
                            required
                        >
                    </div>
                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-key input-icon"></i>
                        <input
                            type="password"
                            name="password"
                            class="form-input @error('password') is-invalid @enderror"
                            placeholder="Input your password"
                            required
                        >
                    </div>
                    @error('password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="submit-button">
                    <i class="fas fa-user"></i>
                    REGISTER
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
