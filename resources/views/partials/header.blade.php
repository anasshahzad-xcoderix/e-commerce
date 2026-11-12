@php
    $cartCount = auth()->check()
        ? (\App\Models\Cart::where('user_id', auth()->id())->first()?->items()->sum('quantity') ?? 0)
        : 0;
@endphp

<header class="site-header">
    <a href="{{ url('/') }}" class="logo">
        <img class="logo-image" src="{{ asset('images/yousaf-store-logo.jpg') }}" alt="Yousaf Store">
    </a>

    <nav class="menu" id="menu" aria-label="Main navigation">
        <a href="{{ route('shop') }}">Shop</a>
        <a href="{{ url('/#categories') }}">Categories</a>
        <a href="{{ route('daily-sale') }}">Daily sale</a>
        <a href="{{ route('makers') }}">Makers</a>
        <a href="{{ route('help') }}">Help</a>
        <a href="{{ route('contact') }}">Contact</a>
    </nav>

    <form class="header-search" method="GET" action="{{ route('shop') }}" role="search">
        <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="7"/>
            <path d="m20 20-4-4"/>
        </svg>
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search products..." aria-label="Search products">
    </form>

    <div class="header-right">
        <details class="account-menu">
            <summary class="account-trigger" aria-label="Account menu">
                <img src="{{ asset('images/account-icon.png') }}" alt="account">
            </summary>
            <div class="account-dropdown">
                @guest
                    <a href="{{ route('login') }}" class="account-dropdown-signin">Sign In</a>
                @endguest

                @auth
                    <span class="account-dropdown-name">{{ Auth::user()->name }}</span>
                    <a href="{{ route('analytics') }}" class="account-dropdown-link">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="account-dropdown-link">Logout</button>
                    </form>
                @endauth
            </div>
        </details>

        <a href="{{ route('cart.index') }}" class="cart-icon-btn" aria-label="Cart">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"/>
                <circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
            @if($cartCount > 0)
                <span class="cart-badge">{{ $cartCount }}</span>
            @endif
        </a>

        <button class="burger" id="burger" type="button" aria-label="Menu" aria-controls="menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>
