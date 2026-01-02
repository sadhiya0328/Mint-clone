@extends('layouts.app')

@section('page-title', 'Create Goal')

@section('content')

<style>
    .page-header {
        margin-bottom: 32px;
    }

    .page-header h2 {
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
    }

    .form-card {
        max-width: 600px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #e5e7eb;
        font-size: 14px;
    }

    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 32px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header h2 {
            font-size: 24px;
        }

        .form-card {
            max-width: 100%;
        }

        .btn-group {
            flex-direction: column;
        }

        .btn-group button,
        .btn-group a {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .page-header h2 {
            font-size: 20px;
        }

        .form-group label {
            font-size: 13px;
        }
    }
</style>

<div class="page-header">
    <h2>Create New Financial Goal</h2>
</div>

<div class="card form-card">
    <form method="POST" action="/goals">
        @csrf

        <div class="form-group">
            <label for="name">Goal Name *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="e.g., Emergency Fund, Vacation Savings, Down Payment">
            @error('name')
                <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="target_amount">Target Amount *</label>
            <input type="number" step="0.01" min="1" name="target_amount" id="target_amount" value="{{ old('target_amount') }}" required placeholder="Enter your target amount">
            @error('target_amount')
                <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="current_amount">Current Amount (Optional)</label>
            <input type="number" step="0.01" min="0" name="current_amount" id="current_amount" value="{{ old('current_amount', 0) }}" placeholder="Enter current saved amount (default: 0)">
            <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">
                Leave empty or set to 0 if you're starting from scratch
            </small>
            @error('current_amount')
                <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="btn-group">
            <button type="submit" class="btn">
                <i class="fas fa-save"></i> Create Goal
            </button>
            <a href="/goals" class="btn secondary" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection


