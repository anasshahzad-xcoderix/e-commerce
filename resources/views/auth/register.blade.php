@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <h2>Create Account</h2>

        @if ($errors->any())
            <div class="auth-errors">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required>

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>

            <button type="submit">Register</button>
        </form>
    </div>
</div>

<style>
    .auth-wrap { min-height: 70vh; display: flex; align-items: center; justify-content: center; padding: 40px 16px; }
    .auth-card { width: 100%; max-width: 420px; background: #fff; padding: 32px; border-radius: 16px; box-shadow: 0 10px 30px rgba(20,35,59,0.08); }
    .auth-card h2 { color: #14233b; margin-bottom: 20px; }
    .auth-card label { display: block; font-size: 14px; font-weight: 600; margin: 14px 0 6px; color: #14233b; }
    .auth-card input { width: 100%; padding: 11px 14px; border: 1.5px solid #d6dde8; border-radius: 10px; font-size: 15px; }
    .auth-card input:focus { outline: none; border-color: #1f7a6d; }
    .auth-card button { width: 100%; margin-top: 22px; padding: 12px; border: 0; border-radius: 999px; background: #14233b; color: #fff; font-size: 15px; font-weight: 700; cursor: pointer; }
    .auth-card button:hover { background: #1f7a6d; }
    .auth-errors { background: #fdecec; color: #b42318; padding: 12px 14px; border-radius: 10px; margin-bottom: 10px; font-size: 14px; }
    .auth-errors p { margin: 2px 0; }
</style>
@endsection