    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title') | Yousaf Store</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cloudflare.com"></script>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite('resources/js/app.js')
        @endif

        @stack('styles')
    </head>
    <body>

        @include('partials.header')

        @yield('content')

        @include('partials.footer')
        @stack('scripts')
        @if(session('already_in_cart'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    if (window.Swal) {
                        window.Swal.fire({
                            title: 'Already in your cart',
                            text: @json(session('already_in_cart') . ' is already in your cart. You can change its quantity from the cart page.'),
                            icon: 'info',
                            confirmButtonText: 'Got it',
                            confirmButtonColor: '#e39320'
                        });
                    } else {
                        console.error('SweetAlert could not be loaded.');
                    }
                });
            </script>
        @endif
    </body>
    </body>
    </html>