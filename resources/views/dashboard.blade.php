@extends('layouts.app')

@section('content')

<style>
    /* ===== HERO SECTION ===== */
    .hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(90deg, #eef2f3, #f9fafb);
        padding: 50px;
        border-radius: 18px;
        margin-bottom: 40px;
    }

    .hero-text {
        max-width: 55%;
    }

    .hero-text h1 {
        font-size: 40px;
        font-weight: 700;
        color: #0f766e;
        margin-bottom: 14px;
    }

    .hero-text p {
        font-size: 17px;
        color: #4b5563;
        line-height: 1.6;
        margin-bottom: 22px;
    }

    .hero-text button {
        padding: 12px 22px;
        background: #0f766e;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
    }

    .hero-text button:hover {
        background: #115e59;
    }

    .hero-image img {
        max-width: 340px;
    }

    /* ===== DASHBOARD CARDS ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #fff;
        padding: 22px;
        border-radius: 14px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }

    .stat-card h3 {
        font-size: 15px;
        color: #6b7280;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .stat-card h1,
    .stat-card p {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .income {
        color: #16a34a;
    }

    .expense {
        color: #dc2626;
    }

    /* ===== QUICK ACTIONS ===== */
    .actions-card {
        background: #fff;
        padding: 24px;
        border-radius: 14px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }

    .actions-card h3 {
        margin-bottom: 16px;
        font-size: 18px;
        font-weight: 700;
        color: #111827;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 14px;
    }

    .action-link {
        display: block;
        padding: 14px;
        border-radius: 10px;
        background: #f9fafb;
        text-align: center;
        font-weight: 600;
        color: #0f766e;
        text-decoration: none;
        border: 1px solid #e5e7eb;
    }

    .action-link:hover {
        background: #ecfdf5;
    }
</style>

<!-- ===== HERO ===== -->
<div class="hero">
    <div class="hero-text">
        <h1>Welcome to your Dashboard</h1>
        <p>
            Review your transactions, monitor your spending,
            and track your financial progress — all in one place.
        </p>
        <button>Check insights</button>
    </div>

    <div class="hero-image">
        <img src="{{ asset('images/dashboard-hero.png') }}" alt="Dashboard">
    </div>
</div>

<!-- ===== STATS ===== -->
<div class="stats-grid">

    <div class="stat-card">
        <h3>Total Balance</h3>
        <h1>₹{{ $balance }}</h1>
    </div>

    <div class="stat-card">
        <h3>Income</h3>
        <p class="income">₹{{ $income }}</p>
    </div>

    <div class="stat-card">
        <h3>Expense</h3>
        <p class="expense">₹{{ $expense }}</p>
    </div>

</div>

<!-- ===== QUICK ACTIONS ===== -->
<div class="actions-card">
    <h3>Quick Actions</h3>

    <div class="actions-grid">
        <a href="/accounts" class="action-link">Manage Accounts</a>
        <a href="/transactions" class="action-link">View Transactions</a>
        <a href="/budgets" class="action-link">Budgets</a>
        <a href="/bills" class="action-link">Bills</a>
        <a href="/goals" class="action-link">Goals</a>
    </div>
</div>

@endsection
