<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            background: #0f0f23;
            margin: 0;
            min-height: 100vh;
            color: #e5e7eb;
        }

        /* Main Layout */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: rgba(26, 26, 46, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 2px 0 20px rgba(0, 0, 0, 0.3);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 28px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .brand {
            display: flex;
            align-items: center;
        }

        .brand span {
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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
            color: #9ca3af;
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
            background: rgba(236, 72, 153, 0.1);
            color: #ec4899;
        }

        .nav-item.active {
            background: rgba(236, 72, 153, 0.15);
            color: #ec4899;
            border-left-color: #ec4899;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: 260px;
            background: transparent;
        }

        /* Top Header */
        .top-header {
            background: rgba(26, 26, 46, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 20px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Welcome Message */
        .welcome-section {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .welcome-title {
            font-size: 28px;
            font-weight: 600;
            color: #ec4899;
            margin: 0;
            line-height: 1.2;
            letter-spacing: 0.5px;
        }

        .welcome-tagline {
            font-size: 14px;
            font-weight: 500;
            color: #9ca3af;
            margin: 0;
            line-height: 1.4;
            letter-spacing: 0.2px;
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
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e5e7eb;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header-icon:hover {
            background: rgba(236, 72, 153, 0.2);
            border-color: rgba(236, 72, 153, 0.3);
            color: #ec4899;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.05);
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-profile:hover {
            background: rgba(236, 72, 153, 0.15);
            border-color: rgba(236, 72, 153, 0.3);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ec4899 0%, #a855f7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: #ffffff;
        }

        .user-role {
            font-size: 11px;
            color: #9ca3af;
        }

        /* Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: rgba(26, 26, 46, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            min-width: 200px;
            padding: 8px;
            display: none;
            z-index: 1000;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #e5e7eb;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background: rgba(236, 72, 153, 0.2);
            color: #ec4899;
        }

        .dropdown-item i {
            width: 20px;
            font-size: 16px;
        }

        .dropdown-item.logout {
            color: #ef4444;
        }

        .dropdown-item.logout:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        /* Container */
        .container {
            padding: 32px;
        }

        /* Card - Glassmorphism Dark */
        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 24px;
            margin-bottom: 20px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Form Elements Dark */
        input, select, textarea {
            width: 100%;
            padding: 12px 16px;
            margin-bottom: 16px;
            font-size: 14px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            color: #e5e7eb;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            background: rgba(255, 255, 255, 0.08);
        }

        input::placeholder {
            color: #6b7280;
        }

        button, .btn {
            padding: 12px 24px;
            background: #10b981;
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
            background: #34d399;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        button.secondary {
            background: rgba(255, 255, 255, 0.05);
            color: #e5e7eb;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        button.secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Search Modal Dark */
        .search-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            z-index: 2000;
            align-items: flex-start;
            justify-content: center;
            padding-top: 100px;
        }

        .search-modal.show {
            display: flex;
        }

        .search-modal-content {
            background: rgba(26, 26, 46, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .search-modal-header {
            padding: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .search-input-wrapper {
            flex: 1;
            position: relative;
        }

        .search-input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 48px;
            font-size: 16px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.05);
            color: #e5e7eb;
            font-family: 'Inter', sans-serif;
        }

        .search-input:focus {
            outline: none;
            border-color: #ec4899;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.2);
            background: rgba(255, 255, 255, 0.08);
        }

        .search-input::placeholder {
            color: #6b7280;
        }

        .search-close-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e5e7eb;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.2s;
        }

        .search-close-btn:hover {
            background: rgba(236, 72, 153, 0.2);
            border-color: rgba(236, 72, 153, 0.3);
            color: #ec4899;
        }

        .search-results {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
        }

        .search-section {
            margin-bottom: 32px;
        }

        .search-section:last-child {
            margin-bottom: 0;
        }

        .search-section-title {
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .search-section-title i {
            color: #ec4899;
        }

        .search-result-item {
            padding: 16px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            margin-bottom: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            cursor: pointer;
            transition: all 0.2s;
        }

        .search-result-item:hover {
            background: rgba(236, 72, 153, 0.15);
            border-color: rgba(236, 72, 153, 0.3);
            transform: translateX(4px);
        }

        .search-result-item-title {
            font-size: 15px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .search-result-item-meta {
            font-size: 13px;
            color: #9ca3af;
            margin-bottom: 4px;
        }

        .search-result-item-amount {
            font-size: 16px;
            font-weight: 700;
            color: #10b981;
            margin-top: 8px;
        }

        .search-result-item-amount.negative {
            color: #ef4444;
        }

        .search-empty {
            text-align: center;
            padding: 40px 20px;
            color: #9ca3af;
        }

        .search-empty i {
            font-size: 48px;
            margin-bottom: 16px;
            color: #6b7280;
        }

        .search-empty p {
            font-size: 14px;
            margin: 0;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e5e7eb;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.2s;
        }

        .mobile-menu-toggle:hover {
            background: rgba(236, 72, 153, 0.2);
            border-color: rgba(236, 72, 153, 0.3);
            color: #ec4899;
        }

        /* Sidebar Overlay for Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        /* Responsive - Tablet and Below */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1000;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-toggle {
                display: flex;
            }

            .top-header {
                padding: 16px 20px;
            }

            .welcome-title {
                font-size: 22px;
            }

            .welcome-tagline {
                font-size: 13px;
            }

            .header-right {
                gap: 12px;
            }

            .user-profile {
                padding: 6px 12px;
            }

            .user-info {
                display: none;
            }

            .user-avatar {
                width: 32px;
                height: 32px;
                font-size: 12px;
            }

            .container {
                padding: 20px;
            }
        }

        /* Responsive - Mobile */
        @media (max-width: 768px) {
            .top-header {
                padding: 12px 16px;
                flex-wrap: wrap;
            }

            .header-left {
                width: 100%;
                margin-bottom: 12px;
            }

            .welcome-section {
                width: 100%;
            }

            .welcome-title {
                font-size: 18px;
            }

            .welcome-tagline {
                font-size: 12px;
            }

            .header-right {
                width: 100%;
                justify-content: space-between;
            }

            .header-icon {
                width: 36px;
                height: 36px;
                font-size: 16px;
            }

            .user-profile {
                padding: 6px 10px;
            }

            .container {
                padding: 16px;
            }

            .sidebar {
                width: 280px;
            }

            .sidebar-header {
                padding: 20px;
            }

            .nav-item {
                padding: 12px 20px;
                font-size: 14px;
            }

            .search-modal-content {
                width: 95%;
                max-height: 90vh;
            }

            .search-modal-header {
                padding: 16px;
            }

            .search-results {
                padding: 16px;
            }
        }

        /* Responsive - Small Mobile */
        @media (max-width: 480px) {
            .welcome-title {
                font-size: 16px;
            }

            .welcome-tagline {
                display: none;
            }

            .header-icon {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }

            .container {
                padding: 12px;
            }

            .card {
                padding: 16px;
                border-radius: 12px;
            }

            .sidebar {
                width: 100%;
            }
        }
    </style>
</head>
<body>

@auth
<div class="app-wrapper">
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="brand">
                <span>MintClone</span>
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
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="welcome-section">
                    <h1 class="welcome-title">Welcome back, {{ Auth::user()->name }}!</h1>
                    <p class="welcome-tagline">It is the best time to manage your finances</p>
                </div>
            </div>
            <div class="header-right">
                <div class="header-icon" id="searchBtn">
                    <i class="fas fa-search"></i>
                </div>
                <div class="header-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="user-profile profile-dropdown" id="profileDropdown">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">User</div>
                    </div>
                    <i class="fas fa-chevron-down" style="font-size: 12px; color: #9ca3af;"></i>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <div class="dropdown-item logout" id="logoutBtn">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </div>
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

<!-- Search Modal -->
<div class="search-modal" id="searchModal">
    <div class="search-modal-content">
        <div class="search-modal-header">
            <div class="search-input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" id="searchInput" placeholder="Search bills, budgets, transactions, goals...">
            </div>
            <button class="search-close-btn" id="searchCloseBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="search-results" id="searchResults">
            <div class="search-empty">
                <i class="fas fa-search"></i>
                <p>Start typing to search...</p>
            </div>
        </div>
    </div>
</div>

@else
    <!-- Public pages (login/register) - no navbar/sidebar -->
    @yield('content')
@endauth

<script>
    // Profile Dropdown Toggle
    document.addEventListener('DOMContentLoaded', function() {
        const profileDropdown = document.getElementById('profileDropdown');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const logoutBtn = document.getElementById('logoutBtn');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        // Mobile Menu Toggle
        if (mobileMenuToggle && sidebar && sidebarOverlay) {
            function toggleSidebar() {
                sidebar.classList.toggle('open');
                sidebarOverlay.classList.toggle('show');
            }

            mobileMenuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleSidebar();
            });

            // Close sidebar when clicking overlay
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('show');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 1024) {
                    if (sidebar.classList.contains('open') && 
                        !sidebar.contains(e.target) && 
                        !mobileMenuToggle.contains(e.target)) {
                        sidebar.classList.remove('open');
                        sidebarOverlay.classList.remove('show');
                    }
                }
            });

            // Close sidebar when window is resized to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 1024) {
                    sidebar.classList.remove('open');
                    sidebarOverlay.classList.remove('show');
                }
            });
        }

        // Search Modal Toggle
        const searchBtn = document.getElementById('searchBtn');
        const searchModal = document.getElementById('searchModal');
        const searchCloseBtn = document.getElementById('searchCloseBtn');
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        let searchTimeout;

        if (searchBtn && searchModal) {
            // Open search modal
            searchBtn.addEventListener('click', function() {
                searchModal.classList.add('show');
                setTimeout(() => searchInput.focus(), 100);
            });

            // Close search modal
            searchCloseBtn.addEventListener('click', function() {
                searchModal.classList.remove('show');
                searchInput.value = '';
                searchResults.innerHTML = '<div class="search-empty"><i class="fas fa-search"></i><p>Start typing to search...</p></div>';
            });

            // Close on outside click
            searchModal.addEventListener('click', function(e) {
                if (e.target === searchModal) {
                    searchModal.classList.remove('show');
                    searchInput.value = '';
                    searchResults.innerHTML = '<div class="search-empty"><i class="fas fa-search"></i><p>Start typing to search...</p></div>';
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && searchModal.classList.contains('show')) {
                    searchModal.classList.remove('show');
                    searchInput.value = '';
                    searchResults.innerHTML = '<div class="search-empty"><i class="fas fa-search"></i><p>Start typing to search...</p></div>';
                }
            });

            // Search functionality
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();

                clearTimeout(searchTimeout);

                if (query.length < 2) {
                    searchResults.innerHTML = '<div class="search-empty"><i class="fas fa-search"></i><p>Start typing to search...</p></div>';
                    return;
                }

                searchTimeout = setTimeout(function() {
                    fetch('/dashboard/search?query=' + encodeURIComponent(query), {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        displaySearchResults(data);
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        searchResults.innerHTML = '<div class="search-empty"><i class="fas fa-exclamation-circle"></i><p>Error performing search. Please try again.</p></div>';
                    });
                }, 300);
            });
        }

        function displaySearchResults(data) {
            let html = '';
            let hasResults = false;

            // Transactions
            if (data.transactions && data.transactions.length > 0) {
                hasResults = true;
                html += '<div class="search-section">';
                html += '<div class="search-section-title"><i class="fas fa-exchange-alt"></i> Transactions (' + data.transactions.length + ')</div>';
                data.transactions.forEach(function(item) {
                    html += '<div class="search-result-item" onclick="window.location.href=\'/transactions\'">';
                    html += '<div class="search-result-item-title">' + escapeHtml(item.description) + '</div>';
                    html += '<div class="search-result-item-meta">' + escapeHtml(item.account) + (item.category ? ' • ' + escapeHtml(item.category) : '') + ' • ' + item.date + '</div>';
                    html += '<div class="search-result-item-amount ' + (item.amount < 0 ? 'negative' : '') + '">₹' + Math.abs(item.amount).toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</div>';
                    html += '</div>';
                });
                html += '</div>';
            }

            // Bills
            if (data.bills && data.bills.length > 0) {
                hasResults = true;
                html += '<div class="search-section">';
                html += '<div class="search-section-title"><i class="fas fa-file-invoice-dollar"></i> Bills (' + data.bills.length + ')</div>';
                data.bills.forEach(function(item) {
                    html += '<div class="search-result-item" onclick="window.location.href=\'/bills\'">';
                    html += '<div class="search-result-item-title">' + escapeHtml(item.name) + '</div>';
                    html += '<div class="search-result-item-meta">Due: ' + item.due_date + '</div>';
                    html += '<div class="search-result-item-amount">₹' + item.amount.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</div>';
                    html += '</div>';
                });
                html += '</div>';
            }

            // Budgets
            if (data.budgets && data.budgets.length > 0) {
                hasResults = true;
                html += '<div class="search-section">';
                html += '<div class="search-section-title"><i class="fas fa-chart-pie"></i> Budgets (' + data.budgets.length + ')</div>';
                data.budgets.forEach(function(item) {
                    html += '<div class="search-result-item" onclick="window.location.href=\'/budgets\'">';
                    html += '<div class="search-result-item-title">' + escapeHtml(item.category) + '</div>';
                    html += '<div class="search-result-item-amount">₹' + item.amount.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '</div>';
                    html += '</div>';
                });
                html += '</div>';
            }

            // Goals
            if (data.goals && data.goals.length > 0) {
                hasResults = true;
                html += '<div class="search-section">';
                html += '<div class="search-section-title"><i class="fas fa-bullseye"></i> Goals (' + data.goals.length + ')</div>';
                data.goals.forEach(function(item) {
                    const percentage = item.target_amount > 0 ? Math.min(100, (item.current_amount / item.target_amount) * 100) : 0;
                    html += '<div class="search-result-item" onclick="window.location.href=\'/goals\'">';
                    html += '<div class="search-result-item-title">' + escapeHtml(item.name) + '</div>';
                    html += '<div class="search-result-item-meta">₹' + item.current_amount.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' / ₹' + item.target_amount.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' (' + percentage.toFixed(1) + '%)</div>';
                    html += '</div>';
                });
                html += '</div>';
            }

            if (!hasResults) {
                html = '<div class="search-empty"><i class="fas fa-search"></i><p>No results found</p></div>';
            }

            searchResults.innerHTML = html;
        }

        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        if (profileDropdown && dropdownMenu) {
            // Toggle dropdown on profile click
            profileDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!profileDropdown.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });

            // Handle logout
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Get JWT token from localStorage or sessionStorage
                    const token = localStorage.getItem('token') || sessionStorage.getItem('token');
                    
                    if (token) {
                        // Call API logout endpoint
                        fetch('/api/logout', {
                            method: 'POST',
                            headers: {
                                'Authorization': 'Bearer ' + token,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Clear token from storage
                            localStorage.removeItem('token');
                            sessionStorage.removeItem('token');
                            
                            // Redirect to register page
                            window.location.href = '/register';
                        })
                        .catch(error => {
                            console.error('Logout API error:', error);
                            // Fallback to web logout if API fails
                            window.location.href = '/logout';
                        });
                    } else {
                        // No token found, use web logout route
                        window.location.href = '/logout';
                    }
                });
            }
        }
    });
</script>

</body>
</html>
