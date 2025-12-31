@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')

<style>
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: transform 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
    }

    .stat-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .stat-card-title {
        font-size: 14px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
    }

    .icon-balance {
        background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
    }

    .icon-income {
        background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
    }

    .icon-expense {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    }

    .stat-card-value {
        font-size: 32px;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .stat-card-value.income {
        color: #16a34a;
    }

    .stat-card-value.expense {
        color: #dc2626;
    }

    .stat-card-value.remaining {
        color: #16a34a;
    }

    .stat-card-value.remaining.negative {
        color: #dc2626;
    }

    /* Dashboard Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 24px;
        margin-bottom: 32px;
    }

    .widget {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .widget-full {
        grid-column: span 12;
    }

    .widget-half {
        grid-column: span 6;
    }

    .widget-third {
        grid-column: span 4;
    }

    .widget-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .widget-title {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
    }

    .widget-link {
        font-size: 14px;
        color: #0f766e;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .widget-link:hover {
        color: #115e59;
    }

    /* Upcoming Bills Widget */
    .bill-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid rgba(15, 118, 110, 0.1);
    }

    .bill-item:last-child {
        border-bottom: none;
    }

    .bill-info {
        flex: 1;
    }

    .bill-name {
        font-size: 15px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 4px;
    }

    .bill-date {
        font-size: 13px;
        color: #6b7280;
    }

    .bill-amount {
        font-size: 18px;
        font-weight: 700;
        color: #0f766e;
    }

    .bill-amount.overdue {
        color: #dc2626;
    }

    /* Recent Transactions Widget */
    .transaction-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid rgba(15, 118, 110, 0.1);
    }

    .transaction-item:last-child {
        border-bottom: none;
    }

    .transaction-info {
        flex: 1;
        margin-left: 12px;
    }

    .transaction-description {
        font-size: 15px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 4px;
    }

    .transaction-meta {
        font-size: 13px;
        color: #6b7280;
    }

    .transaction-amount {
        font-size: 16px;
        font-weight: 700;
    }

    .transaction-amount.positive {
        color: #16a34a;
    }

    .transaction-amount.negative {
        color: #dc2626;
    }

    /* Budget Progress Widget */
    .budget-item {
        margin-bottom: 20px;
    }

    .budget-item:last-child {
        margin-bottom: 0;
    }

    .budget-header-small {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .budget-name-small {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
    }

    .budget-percentage {
        font-size: 14px;
        font-weight: 600;
        color: #0f766e;
    }

    .progress-bar-small {
        width: 100%;
        height: 8px;
        background: rgba(15, 118, 110, 0.1);
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #0f766e 0%, #14b8a6 100%);
        border-radius: 4px;
        transition: width 0.3s;
    }

    .progress-bar-fill.over {
        background: linear-gradient(90deg, #dc2626 0%, #ef4444 100%);
    }

    /* Goals Progress Widget */
    .goal-item {
        margin-bottom: 20px;
    }

    .goal-item:last-child {
        margin-bottom: 0;
    }

    .goal-header-small {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .goal-name-small {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
    }

    .goal-amounts-small {
        font-size: 13px;
        color: #6b7280;
    }

    /* Empty States */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 36px;
        margin-bottom: 12px;
        color: #9ca3af;
    }

    .empty-state p {
        font-size: 14px;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .widget-half {
            grid-column: span 12;
        }
        
        .widget-third {
            grid-column: span 6;
        }
    }

    @media (max-width: 768px) {
        .widget-third {
            grid-column: span 12;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-title">Total Balance</span>
            <div class="stat-card-icon icon-balance">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
        <p class="stat-card-value">₹{{ number_format($balance, 2) }}</p>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-title">Total Expense</span>
            <div class="stat-card-icon icon-expense">
                <i class="fas fa-arrow-down"></i>
            </div>
        </div>
        <p class="stat-card-value expense">₹{{ number_format($expense, 2) }}</p>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-card-title">Remaining (Balance - Expense)</span>
            <div class="stat-card-icon icon-income">
                <i class="fas fa-wallet"></i>
            </div>
        </div>
        @php
            // Remaining = Total Balance - Total Expense
            $remaining = $balance - $expense;
        @endphp
        <p class="stat-card-value remaining {{ $remaining < 0 ? 'negative' : '' }}">₹{{ number_format($remaining, 2) }}</p>
    </div>
</div>

<!-- Dashboard Widgets Grid -->
<div class="dashboard-grid">
    <!-- Upcoming Bills Widget -->
    <div class="widget widget-half">
        <div class="widget-header">
            <h3 class="widget-title">Upcoming Bills</h3>
            <a href="/bills" class="widget-link">View all</a>
        </div>
        @if($upcomingBills->count() > 0)
            @foreach($upcomingBills as $billData)
                @php 
                    $bill = $billData['bill'];
                    $isOverdue = $billData['is_overdue'] ?? false;
                    $daysUntilDue = $billData['days_until_due'];
                @endphp
                <div class="bill-item">
                    <div class="bill-info">
                        <div class="bill-name">{{ $bill->name }}</div>
                        <div class="bill-date">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $bill->due_date->format('M d, Y') }} 
                            @if($isOverdue)
                                • Was due {{ abs($daysUntilDue) }} day(s) ago
                            @else
                                • {{ $daysUntilDue == 0 ? 'Due today' : ($daysUntilDue . ' day(s) left') }}
                            @endif
                        </div>
                    </div>
                    <div class="bill-amount {{ $isOverdue ? 'overdue' : '' }}">₹{{ number_format($bill->amount, 2) }}</div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-file-invoice-dollar"></i>
                <p>No upcoming bills</p>
            </div>
        @endif
    </div>

    <!-- Recent Transactions Widget -->
    <div class="widget widget-half">
        <div class="widget-header">
            <h3 class="widget-title">Recent Transactions</h3>
            <a href="/transactions" class="widget-link">View all</a>
        </div>
        @if($recentTransactions->count() > 0)
            @foreach($recentTransactions as $transaction)
                <div class="transaction-item">
                    <div class="transaction-icon" style="width: 40px; height: 40px; border-radius: 10px; background: rgba(15, 118, 110, 0.1); display: flex; align-items: center; justify-content: center; color: #0f766e;">
                        <i class="fas {{ $transaction->amount >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                    </div>
                    <div class="transaction-info">
                        <div class="transaction-description">{{ $transaction->description }}</div>
                        <div class="transaction-meta">
                            {{ $transaction->account->name }}
                            @if($transaction->category)
                                • {{ $transaction->category->name }}
                            @endif
                        </div>
                    </div>
                    <div class="transaction-amount {{ $transaction->amount >= 0 ? 'positive' : 'negative' }}">
                        ₹{{ number_format(abs($transaction->amount), 2) }}
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-receipt"></i>
                <p>No recent transactions</p>
            </div>
        @endif
    </div>

    <!-- Budget Progress Widget -->
    @if($budgetSummaries->count() > 0)
        <div class="widget widget-half">
            <div class="widget-header">
                <h3 class="widget-title">Budget Progress</h3>
                <a href="/budgets" class="widget-link">View all</a>
            </div>
            @foreach($budgetSummaries as $budgetData)
                @php
                    $budget = $budgetData['budget'];
                    $percentage = $budgetData['percentage'];
                    $isOver = $percentage > 100;
                @endphp
                <div class="budget-item">
                    <div class="budget-header-small">
                        <span class="budget-name-small">
                            {{ $budget->category ? $budget->category->name : 'All Categories' }}
                        </span>
                        <span class="budget-percentage">{{ number_format($percentage, 1) }}%</span>
                    </div>
                    <div class="progress-bar-small">
                        <div class="progress-bar-fill {{ $isOver ? 'over' : '' }}" style="width: {{ min(100, $percentage) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Goals Progress Widget -->
    @if($goals->count() > 0)
        <div class="widget widget-half">
            <div class="widget-header">
                <h3 class="widget-title">Goals Progress</h3>
                <a href="/goals" class="widget-link">View all</a>
            </div>
            @foreach($goals as $goalData)
                @php
                    $goal = $goalData['goal'];
                    $percentage = $goalData['percentage'];
                @endphp
                <div class="goal-item">
                    <div class="goal-header-small">
                        <span class="goal-name-small">{{ $goal->name }}</span>
                        <span class="goal-amounts-small">
                            ₹{{ number_format($goal->current_amount, 0) }} / ₹{{ number_format($goal->target_amount, 0) }}
                        </span>
                    </div>
                    <div class="progress-bar-small">
                        <div class="progress-bar-fill" style="width: {{ min(100, $percentage) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
