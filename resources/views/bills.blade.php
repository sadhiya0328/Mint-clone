@extends('layouts.app')

@section('page-title', 'Bills')

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

    .bills-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .bill-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s;
    }

    .bill-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        border-color: rgba(16, 185, 129, 0.3);
    }

    .bill-card.overdue {
        border-left: 4px solid #ef4444;
        background: rgba(239, 68, 68, 0.1);
    }

    .bill-card.due-soon {
        border-left: 4px solid #f59e0b;
        background: rgba(245, 158, 11, 0.1);
    }

    .bill-card.upcoming {
        border-left: 4px solid #10b981;
    }

    .bill-info {
        flex: 1;
    }

    .bill-name {
        font-size: 18px;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 8px;
    }

    .bill-due-date {
        font-size: 14px;
        color: #9ca3af;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .bill-amount {
        font-size: 24px;
        font-weight: 700;
        color: #10b981;
        margin-right: 24px;
    }

    .bill-status {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-overdue {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .status-due-soon {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .status-upcoming {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
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

        .bill-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
            padding: 20px;
        }

        .bill-info {
            width: 100%;
        }

        .bill-name {
            font-size: 16px;
        }

        .bill-amount {
            font-size: 20px;
            margin-right: 0;
            margin-bottom: 8px;
        }

        .bill-card > div:last-child {
            width: 100%;
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .bill-status {
            align-self: flex-start;
        }
    }

    @media (max-width: 480px) {
        .page-header h2 {
            font-size: 20px;
        }

        .bill-card {
            padding: 16px;
        }

        .bill-name {
            font-size: 15px;
        }

        .bill-amount {
            font-size: 18px;
        }

        .bill-due-date {
            font-size: 13px;
        }
    }
</style>

<div class="page-header">
    <h2>My Bills</h2>
    <a href="/bills/create" class="btn-primary">
        <i class="fas fa-plus"></i>
        Add Bill
    </a>
</div>

@if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="card" style="padding: 24px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
    @if($bills->count() > 0)
        <div class="bills-list">
            @foreach($bills as $billData)
                @php
                    $bill = $billData['bill'];
                    $daysUntilDue = $billData['days_until_due'];
                    $isOverdue = $billData['is_overdue'];
                    $isDueSoon = $billData['is_due_soon'];

                    if ($isOverdue) {
                        $cardClass = 'overdue';
                        $statusClass = 'status-overdue';
                        $statusText = 'Overdue';
                        $dueText = 'Was due ' . abs($daysUntilDue) . ' day(s) ago';
                    } elseif ($isDueSoon) {
                        $cardClass = 'due-soon';
                        $statusClass = 'status-due-soon';
                        $statusText = 'Due Soon';
                        $dueText = 'Due in ' . $daysUntilDue . ' day(s)';
                    } else {
                        $cardClass = 'upcoming';
                        $statusClass = 'status-upcoming';
                        $statusText = 'Upcoming';
                        $dueText = 'Due in ' . $daysUntilDue . ' day(s)';
                    }
                @endphp

                <div class="bill-card {{ $cardClass }}">
                    <div class="bill-info">
                        <div class="bill-name">{{ $bill->name }}</div>
                        <div class="bill-due-date">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $bill->due_date->format('M d, Y') }} • {{ $dueText }}
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 24px;">
                        <div class="bill-amount">₹{{ number_format($bill->amount, 2) }}</div>
                        <div class="bill-status {{ $statusClass }}">{{ $statusText }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-data">
            <i class="fas fa-file-invoice-dollar"></i>
            <h3>No bills found</h3>
            <p>Start by adding your first bill</p>
            <a href="/bills/create" class="btn-primary" style="margin-top: 16px;">
                <i class="fas fa-plus"></i>
                Add Bill
            </a>
        </div>
    @endif
</div>

@endsection
