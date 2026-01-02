@extends('layouts.app')

@section('page-title', 'Create Budget')

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

    .info-box {
        padding: 16px;
        background: rgba(16, 185, 129, 0.15);
        border-radius: 10px;
        border-left: 4px solid #10b981;
        margin-bottom: 24px;
        color: #10b981;
        font-size: 14px;
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

        .info-box {
            padding: 12px;
            font-size: 13px;
        }
    }
</style>

<div class="page-header">
    <h2>Create New Budget</h2>
</div>

<div class="card form-card">
    <div class="info-box">
        <i class="fas fa-info-circle"></i>
        Select a category to set a budget for that specific category, or leave it empty to set a budget for all categories.
    </div>

    <form method="POST" action="/budgets">
        @csrf

        <div class="form-group">
            <label for="category_id">Category (Optional)</label>
            <select name="category_id" id="category_id">
                <option value="">All Categories</option>
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

        <div class="form-group">
            <label for="amount">Budget Amount *</label>
            <input type="number" step="0.01" min="1" name="amount" id="amount" value="{{ old('amount') }}" required placeholder="Enter budget amount">
            <small style="color: #6b7280; font-size: 12px; margin-top: 4px; display: block;">
                Enter the maximum amount you want to spend for this budget
            </small>
            @error('amount')
                <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="btn-group">
            <button type="submit" class="btn">
                <i class="fas fa-save"></i> Create Budget
            </button>
            <a href="/budgets" class="btn secondary" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                Cancel
            </a>
        </div>
    </form>
</div>

@endsection


