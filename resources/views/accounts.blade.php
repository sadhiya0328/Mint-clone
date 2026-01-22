@extends('layouts.app')

@section('page-title', 'Accounts')

@section('content')

<style>
    /* Alpine.js cloak - hide elements until Alpine initializes */
    [x-cloak] {
        display: none !important;
    }

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
        background: #00CED1;
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
        background: #40EBEE;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 206, 209, 0.4);
    }

    .accounts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .account-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s;
    }

    .account-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 206, 209, 0.15);
        border-color: rgba(0, 206, 209, 0.3);
    }

    .account-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .account-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn-delete {
        padding: 6px 12px;
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-delete:hover {
        background: rgba(239, 68, 68, 0.3);
        transform: translateY(-1px);
    }

    .account-name {
        font-size: 18px;
        font-weight: 600;
        color: #ffffff;
    }

    .account-type {
        font-size: 12px;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 4px 10px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 6px;
    }

    .account-balance {
        font-size: 32px;
        font-weight: 700;
        color: #00CED1;
        margin-top: 8px;
    }

    .form-card {
        max-width: 600px;
        margin-bottom: 32px;
        display: none;
    }

    .form-card.show {
        display: block;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #e5e7eb;
        font-size: 14px;
    }

    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 32px;
    }

    .alert-success {
        padding: 12px 20px;
        background: rgba(0, 206, 209, 0.15);
        color: #00CED1;
        border-radius: 10px;
        margin-bottom: 24px;
        border-left: 4px solid #00CED1;
    }

    .alert-error {
        padding: 12px 20px;
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        border-radius: 10px;
        margin-bottom: 24px;
        border-left: 4px solid #ef4444;
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

        .accounts-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .account-card {
            padding: 20px;
        }

        .account-balance {
            font-size: 28px;
        }

        .form-card {
            max-width: 100%;
        }

        .btn-group {
            flex-direction: column;
        }

        .btn-group button,
        .btn-group a {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .page-header h2 {
            font-size: 20px;
        }

        .account-card {
            padding: 16px;
        }

        .account-name {
            font-size: 16px;
        }

        .account-balance {
            font-size: 24px;
        }
    }
</style>

<div class="page-header">
    <h2>My Accounts</h2>
    <button type="button" class="btn-primary" onclick="toggleAddAccountForm()">
        <i class="fas fa-plus"></i>
        Add Account
    </button>
</div>

@if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert-error">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
@endif

@if($accounts->count() > 0)
    <div class="accounts-grid">
        @foreach($accounts as $account)
            <div class="account-card">
                <div class="account-header">
                    <div>
                        <div class="account-name">{{ $account->name }}</div>
                        <div class="account-type">{{ $account->type }}</div>
                    </div>
                    <div class="account-actions">
                        <form method="POST" action="/accounts/{{ $account->id }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this account? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" title="Delete Account">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="account-balance">
                    <span x-show="!balanceHidden">₹{{ number_format($account->balance, 2) }}</span>
                    <span x-show="balanceHidden" x-cloak>••••••</span>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="no-data">
        <i class="fas fa-wallet"></i>
        <h3>No accounts found</h3>
        <p>Start by adding your first account</p>
    </div>
@endif

<div id="add-account" class="card form-card {{ $errors->any() ? 'show' : '' }}">
    <h2 style="font-size: 24px; font-weight: 700; color: #ffffff; margin-bottom: 24px;">Add New Account</h2>

    <form method="POST" action="/accounts">
        @csrf

        <div class="form-group">
            <label for="name">Account Name *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="e.g., Savings Account, Checking Account" required>
            @error('name')
                <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="type">Account Type *</label>
            <select name="type" id="type" required>
                <option value="">Select account type</option>
                <option value="Savings" {{ old('type') == 'Savings' ? 'selected' : '' }}>Savings</option>
                <option value="Checking" {{ old('type') == 'Checking' ? 'selected' : '' }}>Checking</option>
                <option value="Credit Card" {{ old('type') == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                <option value="Investment" {{ old('type') == 'Investment' ? 'selected' : '' }}>Investment</option>
                <option value="Cash" {{ old('type') == 'Cash' ? 'selected' : '' }}>Cash</option>
                <option value="Other" {{ old('type') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('type')
                <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="balance">Initial Balance *</label>
            <input type="number" step="0.01" name="balance" id="balance" value="{{ old('balance', 0) }}" placeholder="Enter initial balance" required>
            @error('balance')
                <span style="color: #dc2626; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="btn-group">
            <button type="submit" class="btn">
                <i class="fas fa-save"></i> Add Account
            </button>
            <button type="button" class="btn secondary" onclick="toggleAddAccountForm()">
                Cancel
            </button>
        </div>
    </form>
</div>

<script>
    function toggleAddAccountForm() {
        const formCard = document.getElementById('add-account');
        formCard.classList.toggle('show');
        
        if (formCard.classList.contains('show')) {
            formCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            // Focus on the first input field
            setTimeout(() => {
                document.getElementById('name').focus();
            }, 300);
        }
    }
</script>

@endsection
