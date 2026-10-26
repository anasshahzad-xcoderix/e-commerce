<div class="announce">
    Free delivery on orders over $75 · Free returns for 30 days
</div>

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

        <a href="#" class="cart-btn">Cart <span class="cart-count">0</span></a>

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