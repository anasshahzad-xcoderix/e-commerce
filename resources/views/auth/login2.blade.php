
@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="l2-wrap">
    <div class="l2-card">
        <div class="l2-logo">YS</div>
        <h2>Wapas khush amdeed</h2>
        <p class="l2-sub">Yousaf Store account mein login karein aur apne orders aur pasandida cheezein dekhein.</p>

        <a href="{{ route('google.login') }}" class="l2-google">Google se login karein</a>

        <div class="l2-divider"><span>ya email se</span></div>

        @if ($errors->any())
            <div class="l2-errors">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label class="l2-remember">
                <input type="checkbox" name="remember" value="1">
                Mujhe yaad rakhein
            </label>

            <button type="submit">Login</button>
        </form>

        <ul class="l2-points">
            <li>Apne orders ek jagah dekhein</li>
            <li>Pasandida cheezein save karein</li>
            <li>Agle checkout par tez login</li>
        </ul>

        <p class="l2-foot">Account nahi hai? <a href="{{ route('register') }}">Register karein</a></p>
    </div>
</div>