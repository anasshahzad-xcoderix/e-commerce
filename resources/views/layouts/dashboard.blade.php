<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Yousaf Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @stack('styles')
</head>
<body>

<div class="layout">

    <aside class="sidebar" id="sidebar">
        <div class="s-logo">YOUSAF <span>STORE</span></div>

        <nav class="s-nav">
            <a href="{{ route('analytics') }}" class="nav-link {{ request()->routeIs('analytics') ? 'active' : '' }}">Overview</a>
            <a href="{{ route('shop') }}" class="nav-link">Shop</a>
<a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Categories</a>            <a href="{{ route('daily-sale') }}" class="nav-link">Daily sale</a>
            <a href="{{ route('makers') }}" class="nav-link">Makers</a>
            <a href="{{ route('help') }}" class="nav-link">Help</a>
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">Products</a>

            <a href="{{ route('analytics') }}#regions" class="nav-link">Regions</a>
            <a href="{{ url('/') }}" class="nav-link">← Back to store</a>
        </nav>

        @auth
            <div class="s-user">
                <p>Hello, <b>{{ Auth::user()->name }}</b></p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        @endauth
    </aside>

    <div class="content">

        <header class="top">
            <button class="menu-btn" id="menuBtn" aria-label="Menu">☰</button>
            <div>
                <h1>@yield('page-title', 'Dashboard')</h1>
                <p>@yield('page-sub', 'Q3 2026')</p>
            </div>
        </header>

        @yield('content')

    </div>
</div>

@stack('scripts')
<script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>

