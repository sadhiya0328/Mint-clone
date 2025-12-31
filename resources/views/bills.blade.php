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

    .bills-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .bill-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.2s;
    }

    .bill-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.12);
    }

    .bill-card.overdue {
        border-left: 4px solid #dc2626;
        background: rgba(220, 38, 38, 0.05);
    }

    .bill-card.due-soon {
        border-left: 4px solid #f59e0b;
        background: rgba(245, 158, 11, 0.05);
    }

    .bill-card.upcoming {
        border-left: 4px solid #0f766e;
    }

    .bill-info {
        flex: 1;
    }

    .bill-name {
        font-size: 18px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 8px;
    }

    .bill-due-date {
        font-size: 14px;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .bill-amount {
        font-size: 24px;
        font-weight: 700;
        color: #0f766e;
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
        background: rgba(220, 38, 38, 0.1);
        color: #dc2626;
    }

    .status-due-soon {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .status-upcoming {
        background: rgba(15, 118, 110, 0.1);
        color: #0f766e;
    }

    .alert-success {
        padding: 12px 20px;
        background: rgba(22, 163, 74, 0.1);
        color: #16a34a;
        border-radius: 10px;
        margin-bottom: 24px;
        border-left: 4px solid #16a34a;
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

<div class="card" style="padding: 0;">
    @if($bills->count() > 0)
        <div class="bills-list" style="padding: 24px;">
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


