<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mint Clone</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            margin: 0;
            min-height: 100vh;
        }

        /* Main Layout */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 2px 0 20px rgba(0, 0, 0, 0.05);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 28px 24px;
            border-bottom: 1px solid rgba(15, 118, 110, 0.1);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand img {
            width: 40px;
            height: 40px;
        }

        .brand span {
            font-size: 24px;
            font-weight: 700;
            color: #0f766e;
            letter-spacing: 0.5px;
        }

        .nav-menu {
            padding: 20px 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 24px;
            color: #6b7280;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .nav-item i {
            width: 20px;
            font-size: 18px;
        }

        .nav-item:hover {
            background: rgba(15, 118, 110, 0.05);
            color: #0f766e;
        }

        .nav-item.active {
            background: rgba(15, 118, 110, 0.1);
            color: #0f766e;
            border-left-color: #0f766e;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: 260px;
            background: transparent;
        }

        /* Top Header */
        .top-header {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 20px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left h1 {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 4px;
        }

        .header-left p {
            font-size: 14px;
            color: #6b7280;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(15, 118, 110, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0f766e;
            cursor: pointer;
            transition: all 0.2s;
        }

        .header-icon:hover {
            background: rgba(15, 118, 110, 0.2);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-profile:hover {
            background: rgba(255, 255, 255, 1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        .user-role {
            font-size: 12px;
            color: #6b7280;
        }

        /* Container */
        .container {
            padding: 32px;
        }

        /* Card - Glassmorphism */
        .card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 24px;
            margin-bottom: 20px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Form Elements */
        input, select, textarea {
            width: 100%;
            padding: 12px 16px;
            margin-bottom: 16px;
            font-size: 14px;
            border: 1px solid rgba(15, 118, 110, 0.2);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.9);
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #0f766e;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.1);
        }

        button, .btn {
            padding: 12px 24px;
            background: #0f766e;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        button:hover, .btn:hover {
            background: #115e59;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 118, 110, 0.3);
        }

        button.secondary {
            background: rgba(15, 118, 110, 0.1);
            color: #0f766e;
        }

        button.secondary:hover {
            background: rgba(15, 118, 110, 0.2);
        }
    </style>
</head>
<body>

@auth
<div class="app-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="brand">
                <img src="{{ asset('images/mint-logo.png') }}" alt="Mint Logo" onerror="this.style.display='none'">
                <span>Mint Clone</span>
            </div>
        </div>
        
        <nav class="nav-menu">
            <a href="/dashboard" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>
            <a href="/accounts" class="nav-item {{ request()->is('accounts*') ? 'active' : '' }}">
                <i class="fas fa-wallet"></i>
                <span>Accounts</span>
            </a>
            <a href="/transactions" class="nav-item {{ request()->is('transactions*') ? 'active' : '' }}">
                <i class="fas fa-exchange-alt"></i>
                <span>Transactions</span>
            </a>
            <a href="/budgets" class="nav-item {{ request()->is('budgets*') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i>
                <span>Budgets</span>
            </a>
            <a href="/bills" class="nav-item {{ request()->is('bills*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Bills</span>
            </a>
            <a href="/goals" class="nav-item {{ request()->is('goals*') ? 'active' : '' }}">
                <i class="fas fa-bullseye"></i>
                <span>Goals</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-left">
                <h1>@yield('page-title', 'Dashboard')</h1>
                <p>Welcome back, {{ Auth::user()->name }} 👋</p>
            </div>
            <div class="header-right">
                <div class="header-icon">
                    <i class="fas fa-search"></i>
                </div>
                <div class="header-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="user-profile">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">User</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="container">
            @yield('content')
        </div>
    </div>
</div>
@else
    <!-- Public pages (login/register) - no navbar/sidebar -->
    @yield('content')
@endauth

</body>
</html>
