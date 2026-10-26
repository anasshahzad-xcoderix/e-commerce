<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Yousaf Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
     @stack('styles')
</head>
<body>

    @include('partials.header')

    @yield('content')

    @include('partials.footer')
    @stack('scripts')
</body>
</body>
<style>
    .header-right { display: flex; align-items: center; gap: 14px; }
.login-link { padding: 9px 18px; border-radius: 999px; border: 1.5px solid #14233b; background: #fff;
              color: #14233b; font-weight: 600; font-size: 15px; text-decoration: none; cursor: pointer; }
.login-link:hover { background: #14233b; color: #fff; }
.logout-form { margin: 0; }
.user-name { font-weight: 600; color: #14233b; font-size: 15px; }
@media (max-width: 700px) { .user-name { display: none; } }
.header-right { display: flex; align-items: center; gap: 14px; flex-shrink: 0; }
.site-header .wrap { flex-wrap: nowrap; }
.site-header nav { flex-wrap: nowrap; }
.site-header .cart-btn { white-space: nowrap; } 
</style>
</html>