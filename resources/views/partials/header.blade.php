<div class="announce">
    Free delivery on orders over $75 · Free returns for 30 days
</div>

@php
    $cartCount = auth()->check()
        ? (\App\Models\Cart::where('user_id', auth()->id())->first()?->items()->sum('quantity') ?? 0)
        : 0;
@endphp

<header class="site-header">
    <a href="{{ url('/') }}" class="logo">
        <span class="logo-icon"></span>
        <span class="logo-text">Yousaf Store</span>
    </a>

    <nav class="menu" id="menu">
        <a href="{{ route('shop') }}">Shop</a>
        <a href="{{ url('/#categories') }}">Categories</a>
        <a href="{{ route('daily-sale') }}">Daily sale</a>
        <a href="{{ route('makers') }}">Makers</a>
        <a href="{{ route('help') }}">Help</a>
        <a href="{{ route('contact') }}">Contact</a>
    </nav>

    <div class="header-right">
        @guest
            <a href="{{ route('login') }}" class="login-link">Login</a>
        @endguest

        @auth
            <a href="{{ route('analytics') }}" class="login-link">Dashboard</a>
            <span class="user-name">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="login-link">Logout</button>
            </form>
        @endauth

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

        <button class="burger" id="burger" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const burger = document.getElementById('burger');
        const menu = document.getElementById('menu');

        burger.addEventListener('click', () => menu.classList.toggle('open'));
        menu.querySelectorAll('a').forEach(a =>
            a.addEventListener('click', () => menu.classList.remove('open'))
        );

        const io = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    io.unobserve(e.target);
                }
            });
        }, { threshold: 0.15 });

        document.querySelectorAll('.reveal').forEach(el => io.observe(el));
    });
</script>