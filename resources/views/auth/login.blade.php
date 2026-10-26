@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <h2>Login</h2>

        @if ($errors->any())
            <div class="auth-errors">
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

            <label style="display:flex; align-items:center; gap:8px; font-weight:400;">
                <input type="checkbox" name="remember" value="1" style="width:auto;">
                remember me
            </label>

            <button type="submit">Login</button>
        </form>

        <p style="margin-top:18px; font-size:14px; text-align:center;">
            don't have an account? <a href="{{ route('register') }}">Register</a>
        </p>
    </div>
</div>


@endsection