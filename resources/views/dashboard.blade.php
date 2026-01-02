@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')

<style>
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        padding: 28px;
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #ec4899 0%, #a855f7 100%);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(236, 72, 153, 0.2);
        border-color: rgba(236, 72, 153, 0.3);
    }

    .stat-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .stat-card-title {
        font-size: 13px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stat-card-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .icon-balance {
        background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
    }

    .icon-expense {
        background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
    }

    .icon-remaining {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    }

    .stat-card-value {
        font-size: 36px;
        font-weight: 700;
        color: #ffffff;
        margin: 0;
        line-height: 1.2;
    }

    .stat-card-value.expense {
        color: #ef4444;
    }

    .stat-card-value.remaining {
        color: #10b981;
    }

    .stat-card-value.remaining.negative {
        color: #ef4444;
    }

    /* Dashboard Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 24px;
        margin-bottom: 32px;
    }

    .widget {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        padding: 28px;
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s;
    }

    .widget:hover {
        border-color: rgba(236, 72, 153, 0.3);
        box-shadow: 0 12px 40px rgba(236, 72, 153, 0.15);
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
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .widget-title {
        font-size: 20px;
        font-weight: 700;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .widget-title i {
        color: #ec4899;
        font-size: 18px;
    }

    .widget-link {
        font-size: 14px;
        color: #ec4899;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .widget-link:hover {
        color: #f472b6;
        transform: translateX(2px);
    }

    /* Upcoming Bills Widget */
    .bill-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.2s;
    }

    .bill-item:hover {
        padding-left: 8px;
    }

    .bill-item:last-child {
        border-bottom: none;
    }

    .bill-info {
        flex: 1;
    }

    .bill-name {
        font-size: 16px;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 6px;
    }

    .bill-date {
        font-size: 13px;
        color: #9ca3af;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .bill-date i {
        color: #a855f7;
    }

    .bill-amount {
        font-size: 20px;
        font-weight: 700;
        color: #a855f7;
    }

    .bill-amount.overdue {
        color: #ef4444;
    }

    /* Recent Transactions Widget */
    .transaction-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.2s;
    }

    .transaction-item:hover {
        padding-left: 8px;
    }

    .transaction-item:last-child {
        border-bottom: none;
    }

    .transaction-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .transaction-icon.positive {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .transaction-icon.negative {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .transaction-info {
        flex: 1;
        min-width: 0;
    }

    .transaction-description {
        font-size: 16px;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .transaction-meta {
        font-size: 13px;
        color: #9ca3af;
    }

    .transaction-amount {
        font-size: 18px;
        font-weight: 700;
        white-space: nowrap;
    }

    .transaction-amount.positive {
        color: #10b981;
    }

    .transaction-amount.negative {
        color: #ef4444;
    }

    /* Budget Progress Widget */
    .budget-item {
        margin-bottom: 24px;
        padding: 16px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.2s;
    }

    .budget-item:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(236, 72, 153, 0.2);
    }

    .budget-item:last-child {
        margin-bottom: 0;
    }

    .budget-header-small {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .budget-name-small {
        font-size: 15px;
        font-weight: 600;
        color: #ffffff;
    }

    .budget-percentage {
        font-size: 15px;
        font-weight: 700;
        color: #ec4899;
    }

    .progress-bar-small {
        width: 100%;
        height: 10px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        overflow: hidden;
        position: relative;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #10b981 0%, #34d399 50%, #a855f7 100%);
        border-radius: 8px;
        transition: width 0.5s ease;
        box-shadow: 0 0 10px rgba(168, 85, 247, 0.4);
    }

    .progress-bar-fill.over {
        background: linear-gradient(90deg, #ef4444 0%, #f87171 100%);
        box-shadow: 0 0 10px rgba(239, 68, 68, 0.4);
    }

    /* Goals Progress Widget */
    .goal-item {
        margin-bottom: 24px;
        padding: 16px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.2s;
    }

    .goal-item:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(16, 185, 129, 0.2);
    }

    .goal-item:last-child {
        margin-bottom: 0;
    }

    .goal-header-small {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .goal-name-small {
        font-size: 15px;
        font-weight: 600;
        color: #ffffff;
    }

    .goal-amounts-small {
        font-size: 13px;
        color: #9ca3af;
        font-weight: 500;
    }

    /* Empty States */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        color: #4b5563;
        opacity: 0.5;
    }

    .empty-state p {
        font-size: 15px;
        margin: 0;
        color: #9ca3af;
    }

    /* Responsive - Tablet */
    @media (max-width: 1024px) {
        .widget-half {
            grid-column: span 12;
        }
        
        .widget-third {
            grid-column: span 6;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }

        .stat-card-value {
            font-size: 32px;
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            font-size: 20px;
        }
    }

    /* Responsive - Mobile */
    @media (max-width: 768px) {
        .widget-third {
            grid-column: span 12;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .stat-card {
            padding: 20px;
        }

        .stat-card-value {
            font-size: 28px;
        }

        .stat-card-icon {
            width: 44px;
            height: 44px;
            font-size: 18px;
        }

        .widget {
            padding: 20px;
        }

        .widget-title {
            font-size: 18px;
        }

        .widget-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .widget-link {
            font-size: 13px;
        }

        .bill-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .bill-amount {
            font-size: 18px;
        }

        .transaction-item {
            flex-wrap: wrap;
        }

        .transaction-icon {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .transaction-amount {
            width: 100%;
            margin-top: 8px;
            font-size: 16px;
        }
    }

    /* Responsive - Small Mobile */
    @media (max-width: 480px) {
        .stat-card {
            padding: 16px;
        }

        .stat-card-value {
            font-size: 24px;
        }

        .stat-card-title {
            font-size: 11px;
        }

        .widget {
            padding: 16px;
        }

        .widget-title {
            font-size: 16px;
        }

        .bill-name {
            font-size: 15px;
        }

        .bill-date {
            font-size: 12px;
        }

        .transaction-description {
            font-size: 14px;
        }

        .transaction-meta {
            font-size: 12px;
        }

        .budget-name-small,
        .goal-name-small {
            font-size: 14px;
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
            <span class="stat-card-title">Remaining Balance</span>
            <div class="stat-card-icon icon-remaining">
                <i class="fas fa-piggy-bank"></i>
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
            <h3 class="widget-title">
                <i class="fas fa-file-invoice-dollar"></i>
                Upcoming Bills
            </h3>
            <a href="/bills" class="widget-link">
                View all
                <i class="fas fa-arrow-right"></i>
            </a>
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
                            <span>
                                {{ $bill->due_date->format('M d, Y') }} 
                                @if($isOverdue)
                                    • Was due {{ abs($daysUntilDue) }} day(s) ago
                                @else
                                    • {{ $daysUntilDue == 0 ? 'Due today' : ($daysUntilDue . ' day(s) left') }}
                                @endif
                            </span>
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
            <h3 class="widget-title">
                <i class="fas fa-exchange-alt"></i>
                Recent Transactions
            </h3>
            <a href="/transactions" class="widget-link">
                View all
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        @if($recentTransactions->count() > 0)
            @foreach($recentTransactions as $transaction)
                <div class="transaction-item">
                    <div class="transaction-icon {{ $transaction->amount >= 0 ? 'positive' : 'negative' }}">
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
                        {{ $transaction->amount >= 0 ? '+' : '-' }}₹{{ number_format(abs($transaction->amount), 2) }}
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
                <h3 class="widget-title">
                    <i class="fas fa-chart-pie"></i>
                    Budget Progress
                </h3>
                <a href="/budgets" class="widget-link">
                    View all
                    <i class="fas fa-arrow-right"></i>
                </a>
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
                <h3 class="widget-title">
                    <i class="fas fa-bullseye"></i>
                    Goals Progress
                </h3>
                <a href="/goals" class="widget-link">
                    View all
                    <i class="fas fa-arrow-right"></i>
                </a>
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
