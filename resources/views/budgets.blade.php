@extends('layouts.app')

@section('page-title', 'Budgets')

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

    .budgets-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
    }

    .budget-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s;
    }

    .budget-card:hover {
        border-color: rgba(16, 185, 129, 0.3);
        box-shadow: 0 12px 40px rgba(16, 185, 129, 0.15);
    }

    .budget-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 20px;
    }

    .budget-title {
        font-size: 18px;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 4px;
    }

    .budget-category {
        font-size: 14px;
        color: #9ca3af;
    }

    .budget-amount {
        font-size: 24px;
        font-weight: 700;
        color: #10b981;
    }

    .progress-container {
        margin: 20px 0;
    }

    .progress-bar-wrapper {
        width: 100%;
        height: 12px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 6px;
        overflow: hidden;
        position: relative;
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
        border-radius: 6px;
        transition: width 0.3s ease;
    }

    .progress-bar.over-budget {
        background: linear-gradient(90deg, #ef4444 0%, #f87171 100%);
    }

    .progress-info {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        color: #9ca3af;
        margin-top: 8px;
    }

    .budget-stats {
        display: flex;
        justify-content: space-between;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .stat-item {
        text-align: center;
    }

    .stat-label {
        font-size: 12px;
        color: #9ca3af;
        margin-bottom: 4px;
    }

    .stat-value {
        font-size: 16px;
        font-weight: 600;
        color: #ffffff;
    }

    .stat-value.remaining {
        color: #10b981;
    }

    .stat-value.over {
        color: #ef4444;
    }

    .alert-success {
        padding: 12px 20px;
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
        border-radius: 10px;
        margin-bottom: 24px;
        border-left: 4px solid #10b981;
    }

    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: #9ca3af;
        grid-column: 1 / -1;
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

    /* Responsive */
    @media (max-width: 768px) {
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

        .budgets-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .budget-card {
            padding: 20px;
        }

        .budget-title {
            font-size: 16px;
        }

        .budget-amount {
            font-size: 20px;
        }

        .budget-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .budget-stats {
            flex-direction: column;
            gap: 16px;
        }

        .stat-item {
            text-align: left;
        }
    }

    @media (max-width: 480px) {
        .page-header h2 {
            font-size: 20px;
        }

        .budget-card {
            padding: 16px;
        }

        .budget-title {
            font-size: 15px;
        }

        .budget-amount {
            font-size: 18px;
        }

        .stat-value {
            font-size: 14px;
        }
    }
</style>

<div class="page-header">
    <h2>My Budgets</h2>
    <a href="/budgets/create" class="btn-primary">
        <i class="fas fa-plus"></i>
        Create Budget
    </a>
</div>

@if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="budgets-grid">
    @forelse($budgetsWithSpent as $budgetData)
        @php
            $budget = $budgetData['budget'];
            $spent = $budgetData['spent'];
            $remaining = $budgetData['remaining'];
            $percentage = $budgetData['percentage'];
            $isOverBudget = $remaining < 0;
        @endphp

        <div class="budget-card">
            <div class="budget-header">
                <div>
                    <div class="budget-title">
                        {{ $budget->category ? $budget->category->name : 'All Categories' }}
                    </div>
                    <div class="budget-category">
                        Budget Amount
                    </div>
                </div>
                <div class="budget-amount">
                    ₹{{ number_format($budget->amount, 2) }}
                </div>
            </div>

            <div class="progress-container">
                <div class="progress-bar-wrapper">
                    <div class="progress-bar {{ $isOverBudget ? 'over-budget' : '' }}" 
                         style="width: {{ min(100, $percentage) }}%"></div>
                </div>
                <div class="progress-info">
                    <span>Spent: ₹{{ number_format($spent, 2) }}</span>
                    <span>{{ number_format($percentage, 1) }}%</span>
                </div>
            </div>

            <div class="budget-stats">
                <div class="stat-item">
                    <div class="stat-label">Spent</div>
                    <div class="stat-value">₹{{ number_format($spent, 2) }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Remaining</div>
                    <div class="stat-value {{ $isOverBudget ? 'over' : 'remaining' }}">
                        ₹{{ number_format(abs($remaining), 2) }}
                        @if($isOverBudget)
                            <i class="fas fa-exclamation-triangle"></i>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="no-data">
            <i class="fas fa-chart-pie"></i>
            <h3>No budgets created yet</h3>
            <p>Start by creating your first budget</p>
            <a href="/budgets/create" class="btn-primary" style="margin-top: 16px;">
                <i class="fas fa-plus"></i>
                Create Budget
            </a>
        </div>
    @endforelse
</div>

@endsection
