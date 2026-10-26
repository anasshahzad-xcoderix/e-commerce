@extends('layouts.dashboard')
@section('title', 'Account')
@section('page-title', 'Welcome, ' . Auth::user()->name)
@section('page-sub', 'Aapka account')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
@endpush

@section('content')
<div class="db-wrap">

    <div class="db-cards">
        <div class="db-card"><span>Orders</span><strong>0</strong></div>
        <div class="db-card"><span>Favorite</span><strong>0</strong></div>
        <div class="db-card"><span>in the cart</span><strong>0</strong></div>
    </div>

    <div class="db-box">
        <h3>Account Information</h3>
        <p><b>Name:</b> {{ Auth::user()->name }}</p>
        <p><b>Email:</b> {{ Auth::user()->email }}</p>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/account.js') }}"></script>
@endpush