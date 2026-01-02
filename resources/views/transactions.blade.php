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
        font-size: 28px;
        font-weight: 700;
        color: #ffffff;
    }

    .btn-primary {
        padding: 12px 24px;
        background: #10b981;
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
        background: #34d399;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    .transactions-table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .transactions-table thead {
        background: rgba(255, 255, 255, 0.08);
    }

    .transactions-table th {
        padding: 16px;
        text-align: left;
        font-weight: 600;
        color: #10b981;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .transactions-table td {
        padding: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        color: #e5e7eb;
    }

    .transactions-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    .amount-positive {
        color: #10b981;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .amount-negative {
        color: #ef4444;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .category-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        font-size: 12px;
        font-weight: 500;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: #9ca3af;
    }

    .no-data h3 {
        color: #ffffff;
        margin: 16px 0 8px;
    }

    .no-data i {
        font-size: 48px;
        margin-bottom: 16px;
        color: #6b7280;
    }

    .alert-success {
        padding: 12px 20px;
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border-radius: 10px;
        margin-bottom: 24px;
        border-left: 4px solid #10b981;
    }

    /* Mobile Card View */
    .transaction-card {
        display: none;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 12px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.2s;
    }

    .transaction-card:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(16, 185, 129, 0.3);
    }

    .transaction-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .transaction-card-description {
        font-size: 16px;
        font-weight: 600;
        color: #ffffff;
        flex: 1;
    }

    .transaction-card-amount {
        font-size: 18px;
        font-weight: 700;
        white-space: nowrap;
        margin-left: 12px;
    }

    .transaction-card-meta {
        display: flex;
        flex-direction: column;
        gap: 6px;
        font-size: 13px;
        color: #9ca3af;
    }

    .transaction-card-date {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .transactions-table {
            display: none;
        }

        .transaction-card {
            display: block;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .page-header h2 {
            font-size: 24px;
        }

        .btn-primary {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .page-header h2 {
            font-size: 20px;
        }

        .transaction-card {
            padding: 14px;
        }

        .transaction-card-description {
            font-size: 15px;
        }

        .transaction-card-amount {
            font-size: 16px;
        }

        .transaction-card-meta {
            font-size: 12px;
        }
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

<div class="card" style="padding: 0; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
    @if($transactions->count() > 0)
        <!-- Desktop Table View -->
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
                                <span style="color: #6b7280;">—</span>
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

        <!-- Mobile Card View -->
        <div style="padding: 16px;" id="mobileTransactionsView">
            @foreach($transactions as $transaction)
                <div class="transaction-card">
                    <div class="transaction-card-header">
                        <div class="transaction-card-description">{{ $transaction->description }}</div>
                        <div class="transaction-card-amount {{ $transaction->amount >= 0 ? 'amount-positive' : 'amount-negative' }}">
                            {{ $transaction->amount >= 0 ? '+' : '-' }}₹{{ number_format(abs($transaction->amount), 2) }}
                        </div>
                    </div>
                    <div class="transaction-card-meta">
                        <div class="transaction-card-date">
                            <i class="fas fa-calendar"></i>
                            {{ $transaction->date->format('M d, Y') }}
                        </div>
                        <div>
                            <i class="fas fa-wallet"></i> {{ $transaction->account->name }}
                            @if($transaction->category)
                                • <span class="category-badge">{{ $transaction->category->name }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

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

<script>
    // Show/hide mobile or desktop view based on screen size
    function toggleTransactionView() {
        const table = document.querySelector('.transactions-table');
        const mobileView = document.getElementById('mobileTransactionsView');
        
        if (window.innerWidth <= 768) {
            if (table) table.style.display = 'none';
            if (mobileView) mobileView.style.display = 'block';
        } else {
            if (table) table.style.display = 'table';
            if (mobileView) mobileView.style.display = 'none';
        }
    }

    window.addEventListener('resize', toggleTransactionView);
    document.addEventListener('DOMContentLoaded', toggleTransactionView);
</script>

@endsection
