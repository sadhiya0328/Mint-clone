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
        left: 50%;
        transform: translateX(-50%);
        width: 600px;
        height: 600px;
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        border-radius: 50%;
        opacity: 0.1;
        z-index: 0;
    }

    .message-panel {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        padding: 60px 50px;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 1;
        text-align: center;
        max-width: 500px;
        width: 100%;
    }

    .message-title {
        font-size: 32px;
        color: #ffffff;
        margin: 0 0 30px 0;
        font-weight: 600;
    }

    .message-text {
        font-size: 18px;
        color: #e5e7eb;
        margin-bottom: 40px;
        line-height: 1.6;
    }

    .auth-links {
        display: flex;
        gap: 20px;
        justify-content: center;
    }

    .auth-link {
        padding: 12px 32px;
        background: #10b981;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        display: inline-block;
    }

    .auth-link:hover {
        background: #34d399;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    .auth-link.secondary {
        background: rgba(255, 255, 255, 0.05);
        color: #e5e7eb;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .auth-link.secondary:hover {
        background: rgba(255, 255, 255, 0.1);
    }
</style>

<div class="auth-container">
    <div class="message-panel">
        <h1 class="message-title">Please Login!</h1>
        <p class="message-text">You need to be logged in to access the dashboard.</p>
        <div class="auth-links">
            <a href="/login" class="auth-link">Login</a>
            <a href="/register" class="auth-link secondary">Register</a>
        </div>
    </div>
</div>

@endsection

