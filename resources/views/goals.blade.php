@extends('layouts.app')

@section('page-title', 'Goals')

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

    .goals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 24px;
    }

    .goal-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .goal-header {
        margin-bottom: 20px;
    }

    .goal-title {
        font-size: 20px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 8px;
    }

    .goal-amounts {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .goal-current {
        font-size: 28px;
        font-weight: 700;
        color: #0f766e;
    }

    .goal-target {
        font-size: 16px;
        color: #6b7280;
    }

    .progress-container {
        margin: 20px 0;
    }

    .progress-bar-wrapper {
        width: 100%;
        height: 16px;
        background: rgba(15, 118, 110, 0.1);
        border-radius: 8px;
        overflow: hidden;
        position: relative;
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #0f766e 0%, #14b8a6 100%);
        border-radius: 8px;
        transition: width 0.3s ease;
    }

    .progress-percentage {
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        color: #0f766e;
        margin-top: 8px;
    }

    .goal-stats {
        display: flex;
        justify-content: space-between;
        padding-top: 20px;
        border-top: 1px solid rgba(15, 118, 110, 0.1);
    }

    .stat-item {
        text-align: center;
    }

    .stat-label {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .stat-value {
        font-size: 16px;
        font-weight: 600;
        color: #111827;
    }

    .stat-value.remaining {
        color: #16a34a;
    }

    .update-form {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid rgba(15, 118, 110, 0.1);
    }

    .update-form form {
        display: flex;
        gap: 12px;
    }

    .update-form input {
        flex: 1;
        margin-bottom: 0;
    }

    .update-form button {
        padding: 12px 20px;
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
        grid-column: 1 / -1;
    }

    .no-data i {
        font-size: 48px;
        margin-bottom: 16px;
        color: #9ca3af;
    }

    .completed-badge {
        display: inline-block;
        padding: 4px 12px;
        background: rgba(22, 163, 74, 0.1);
        color: #16a34a;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 12px;
    }
</style>

<div class="page-header">
    <h2>My Financial Goals</h2>
    <a href="/goals/create" class="btn-primary">
        <i class="fas fa-plus"></i>
        Create Goal
    </a>
</div>

@if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="goals-grid">
    @forelse($goals as $goalData)
        @php
            $goal = $goalData['goal'];
            $percentage = $goalData['percentage'];
            $remaining = $goalData['remaining'];
            $isCompleted = $percentage >= 100;
        @endphp

        <div class="goal-card">
            <div class="goal-header">
                @if($isCompleted)
                    <div class="completed-badge">
                        <i class="fas fa-check-circle"></i> Completed!
                    </div>
                @endif
                <div class="goal-title">{{ $goal->name }}</div>
            </div>

            <div class="goal-amounts">
                <div>
                    <div class="goal-current">₹{{ number_format($goal->current_amount, 2) }}</div>
                    <div class="goal-target">of ₹{{ number_format($goal->target_amount, 2) }}</div>
                </div>
            </div>

            <div class="progress-container">
                <div class="progress-bar-wrapper">
                    <div class="progress-bar" style="width: {{ min(100, $percentage) }}%"></div>
                </div>
                <div class="progress-percentage">{{ number_format($percentage, 1) }}% Complete</div>
            </div>

            <div class="goal-stats">
                <div class="stat-item">
                    <div class="stat-label">Target</div>
                    <div class="stat-value">₹{{ number_format($goal->target_amount, 2) }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Remaining</div>
                    <div class="stat-value remaining">₹{{ number_format($remaining, 2) }}</div>
                </div>
            </div>

            @if(!$isCompleted)
                <div class="update-form">
                    <form method="POST" action="/goals/{{ $goal->id }}">
                        @csrf
                        @method('PUT')
                        <input type="number" step="0.01" min="0" name="current_amount" 
                               value="{{ $goal->current_amount }}" 
                               placeholder="Update progress" required>
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> Update
                        </button>
                    </form>
                </div>
            @endif
        </div>
    @empty
        <div class="no-data">
            <i class="fas fa-bullseye"></i>
            <h3>No goals set yet</h3>
            <p>Start by creating your first financial goal</p>
            <a href="/goals/create" class="btn-primary" style="margin-top: 16px;">
                <i class="fas fa-plus"></i>
                Create Goal
            </a>
        </div>
    @endforelse
</div>

@endsection


