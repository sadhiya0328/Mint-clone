@extends('layouts.app')

@section('page-title', 'Transactions')

@section('content')

<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
    }

    .page-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
    }

    .btn-primary {
        padding: 12px 24px;
        background: #0f766e;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background: #115e59;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(15, 118, 110, 0.3);
    }

    .transactions-table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .transactions-table thead {
        background: rgba(15, 118, 110, 0.1);
    }

    .transactions-table th {
        padding: 16px;
        text-align: left;
        font-weight: 600;
        color: #0f766e;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .transactions-table td {
        padding: 16px;
        border-top: 1px solid rgba(15, 118, 110, 0.1);
        color: #111827;
    }

    .transactions-table tbody tr:hover {
        background: rgba(15, 118, 110, 0.05);
    }

    .amount-positive {
        color: #16a34a;
        font-weight: 600;
    }

    .amount-negative {
        color: #dc2626;
        font-weight: 600;
    }

    .category-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 6px;
        background: rgba(15, 118, 110, 0.1);
        color: #0f766e;
        font-size: 12px;
        font-weight: 500;
    }

    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }

    .no-data i {
        font-size: 48px;
        margin-bottom: 16px;
        color: #9ca3af;
    }

    .alert-success {
        padding: 12px 20px;
        background: rgba(22, 163, 74, 0.1);
        color: #16a34a;
        border-radius: 10px;
        margin-bottom: 24px;
        border-left: 4px solid #16a34a;
    }
</style>

<div class="page-header">
    <h2>All Transactions</h2>
    <a href="/transactions/create" class="btn-primary">
        <i class="fas fa-plus"></i>
        Add Transaction
    </a>
</div>

@if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="card" style="padding: 0;">
    @if($transactions->count() > 0)
        <table class="transactions-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Account</th>
                    <th>Category</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->date->format('M d, Y') }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>{{ $transaction->account->name }}</td>
                        <td>
                            @if($transaction->category)
                                <span class="category-badge">{{ $transaction->category->name }}</span>
                            @else
                                <span style="color: #9ca3af;">—</span>
                            @endif
                        </td>
                        <td class="{{ $transaction->amount >= 0 ? 'amount-positive' : 'amount-negative' }}">
                            ₹{{ number_format(abs($transaction->amount), 2) }}
                            @if($transaction->amount >= 0)
                                <i class="fas fa-arrow-up"></i>
                            @else
                                <i class="fas fa-arrow-down"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="padding: 20px; display: flex; justify-content: center;">
            {{ $transactions->links() }}
        </div>
    @else
        <div class="no-data">
            <i class="fas fa-receipt"></i>
            <h3>No transactions found</h3>
            <p>Start by adding your first transaction</p>
            <a href="/transactions/create" class="btn-primary" style="margin-top: 16px;">
                <i class="fas fa-plus"></i>
                Add Transaction
            </a>
        </div>
    @endif
</div>

@endsection


