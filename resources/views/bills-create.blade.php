@extends('layouts.app')

@section('page-title', 'Add Bill')

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
    <h2>Add New Bill</h2>
</div>

<div class="card form-card">
    <form method="POST" action="/bills">
        @csrf

        <div class="form-group">
            <label for="name">Bill Name *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="e.g., Electricity Bill, Internet Bill">
            @error('name')
                <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="amount">Amount *</label>
            <input type="number" step="0.01" min="1" name="amount" id="amount" value="{{ old('amount') }}" required placeholder="Enter bill amount">
            @error('amount')
                <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="due_date">Due Date *</label>
            <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" required>
            @error('due_date')
                <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="btn-group">
            <button type="submit" class="btn">
                <i class="fas fa-save"></i> Save Bill
            </button>
            <a href="/bills" class="btn secondary" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection


