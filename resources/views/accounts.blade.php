@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Add Account</h2>

    <form method="POST" action="/accounts">
        @csrf
        <input name="name" placeholder="Account Name" required>
        <input name="type" placeholder="Type" required>
        <input name="balance" placeholder="Balance" required>
        <button>Add</button>
    </form>
</div>

@foreach($accounts as $account)
<div class="card">
    {{ $account->name }} — ₹{{ $account->balance }}
</div>
@endforeach
@endsection
