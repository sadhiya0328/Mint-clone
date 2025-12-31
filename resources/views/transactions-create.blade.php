@extends('layouts.app')

@section('page-title', 'Add Transaction')

@section('content')

<style>
    .page-header {
        margin-bottom: 32px;
    }

    .page-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
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
        color: #111827;
        font-size: 14px;
    }

    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 32px;
    }
</style>

<div class="page-header">
    <h2>Add New Transaction</h2>
</div>

<div class="card form-card">
    <form method="POST" action="/transactions">
        @csrf

        <div class="form-group">
            <label for="account_id">Account *</label>
            <select name="account_id" id="account_id" required>
                <option value="">Select an account</option>
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                        {{ $account->name }} (₹{{ number_format($account->balance, 2) }})
                    </option>
                @endforeach
            </select>
            @error('account_id')
                <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description *</label>
            <input type="text" name="description" id="description" value="{{ old('description') }}" required placeholder="Enter transaction description">
            @error('description')
                <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="amount">Amount *</label>
            <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" required placeholder="Enter amount (positive for income, negative for expense)">
            <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">
                Use positive numbers for income, negative for expenses
            </small>
            @error('amount')
                <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="date">Date *</label>
            <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required>
            @error('date')
                <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id">
                <option value="">No category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="btn-group">
            <button type="submit" class="btn">
                <i class="fas fa-save"></i> Save Transaction
            </button>
            <a href="/transactions" class="btn secondary" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection


