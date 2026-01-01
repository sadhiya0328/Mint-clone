@extends('layouts.app')

@section('content')

<style>
    body {
        background: #1a3d1a !important;
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
        min-height: calc(100vh - 0px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .auth-panel {
        width: 100%;
        max-width: 1200px;
        height: 700px;
        display: flex;
        flex-direction: row-reverse;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        animation: slideInFromRight 0.6s ease-out;
    }

    @keyframes slideInFromRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Left Panel - Visual */
    .left-panel {
        width: 35%;
        background-color: #d4f4dd;
        background-image: url('https://i.ibb.co/cSrBbMRC/logincc.jpg');
        background-position: center;
        background-size: contain;
        background-repeat: no-repeat;
        position: relative;
        display: flex;
        align-items: flex-start;
        padding: 50px;
        transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .nav-button {
        background: #90EE90;
        color: #000;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: background 0.3s;
    }

    .nav-button:hover {
        background: #7CFC00;
    }

    .nav-button::before {
        content: '←';
        font-size: 16px;
    }

    /* Right Panel - Form */
    .right-panel {
        width: 58%;
        background: #000000;
        padding: 80px 70px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-title {
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 42px;
        color: #FFFFFF;
        margin: 0 0 15px 0;
        font-weight: normal;
    }

    .form-subtitle {
        font-size: 14px;
        color: #FFFFFF;
        margin-bottom: 40px;
        line-height: 1.5;
    }

    .form-group {
        margin-bottom: 35px;
    }

    .form-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #FFFFFF;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .form-input {
        width: 100%;
        background: transparent;
        border: none;
        border-bottom: 1px solid #90EE90;
        padding: 10px 0;
        color: #FFFFFF;
        font-size: 16px;
        outline: none;
        font-family: inherit;
    }

    .form-input:focus {
        border-bottom-color: #7CFC00;
    }

    .form-input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .is-invalid {
        border-bottom-color: #dc3545;
    }

    .error-text {
        font-size: 12px;
        color: #dc3545;
        margin-top: 6px;
    }

    .submit-button {
        width: 100%;
        padding: 16px;
        border: none;
        border-radius: 50px;
        background: linear-gradient(90deg, #2d5a2d 0%, #90EE90 100%);
        color: #FFFFFF;
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        cursor: pointer;
        margin-top: 10px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .submit-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(144, 238, 144, 0.4);
    }
</style>

<div class="auth-container">
    <div class="auth-panel">
        <!-- Left Panel -->
        <div class="left-panel">
            <a href="/register" class="nav-button">SIGN UP</a>
        </div>

        <!-- Right Panel -->
        <div class="right-panel">
            <h1 class="form-title">Log in</h1>
            <p class="form-subtitle">Welcome! Create an account here before you can write in the forum with others and exchange ideas.</p>

            <form method="POST" action="/login">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-input @error('email') is-invalid @enderror"
                        required
                    >
                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-input @error('password') is-invalid @enderror"
                        required
                    >
                    @error('password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="submit-button">LOG IN</button>
            </form>
        </div>
    </div>
</div>

@endsection
