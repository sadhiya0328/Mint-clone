@extends('layouts.app')

@section('content')

<style>
    body {
        background: #93C572;
    }

    .register-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .register-card {
        width: 420px;
        padding: 35px 40px;
        border-radius: 10px;
        background: 4B742F;
        box-shadow: 0 20px 40px rgba(0,0,0,0.35);
    }

    .register-card h2 {
        text-align: center;
        margin-bottom: 25px;
        font-weight: 700;
        color: #0f5132;
    }

    .form-group {
        margin-bottom: 16px;
    }

    label {
        font-size: 14px;
        font-weight: 600;
        color: #0f5132;
        margin-bottom: 5px;
        display: block;
    }

    input {
        width: 100%;
        padding: 12px;
        border-radius: 5px;
        border: 2px solid #198754;
        font-size: 14px;
        outline: none;
    }

    input:focus {
        border-color: #146c43;
    }

    /* Error style */
    .is-invalid {
        border-color: #dc3545;
        background: #f8d7da;
    }

    .error-text {
        font-size: 12px;
        color: #dc3545;
        margin-top: 4px;
    }

    button {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 5px;
        background: #198754;
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 10px;
    }

    button:hover {
        background: #146c43;
    }

    .footer-text {
        text-align: center;
        margin-top: 14px;
        font-size: 13px;
        color: #0f5132;
    }

    .footer-text a {
        color: #0f5132;
        font-weight: 600;
        text-decoration: none;
    }

    .footer-text a:hover {
        text-decoration: underline;
    }
</style>

<div class="register-wrapper">
    <div class="register-card">

        <h2>Hurry Up! Register Now!</h2>

        <form method="POST" action="/register">
            @csrf

            {{-- Name --}}
            <div class="form-group">
                <label>Username</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="@error('name') is-invalid @enderror"
                    placeholder="Enter username"
                    required
                >
                @error('name')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="@error('email') is-invalid @enderror"
                    placeholder="Enter email"
                    required
                >
                @error('email')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label>Password</label>
                <input
                    type="password"
                    name="password"
                    class="@error('password') is-invalid @enderror"
                    placeholder="Enter password"
                    required
                >
                @error('password')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Submit</button>
        </form>

        <div class="footer-text">
            Already have an account?
            <a href="/login">Login</a>
        </div>

    </div>
</div>

@endsection
