    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title') | Yousaf Store</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://code.jquery.com/jquery-3.12.1.min.js"></script>
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

        <script>
            function showCartToast(message, type = 'success') {
                if (window.Swal) {
                    window.Swal.fire({
                        title: type === 'error' ? 'Already in your cart' : 'Added to cart',
                        text: message,
                        icon: type === 'error' ? 'info' : 'success',
                        confirmButtonText: 'Got it',
                        confirmButtonColor: '#e39320'
                    });
                    return;
                }

                alert(message);
            }

            function updateCartBadge(count) {
                const $badge = $('.cart-badge');

                if ($badge.length) {
                    $badge.text(count);
                    return;
                }

                const $cartLink = $('.cart-icon-btn');
                if ($cartLink.length && count > 0) {
                    $cartLink.append('<span class="cart-badge">' + count + '</span>');
                }
            }

            $(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('form[data-ajax-cart-form]').on('submit', function (event) {
                    event.preventDefault();

                    const $form = $(this);
                    const $button = $form.find('button[type="submit"]');
                    const originalText = $button.html();

                    $button.prop('disabled', true).html('Adding...');

                    $.ajax({
                        url: $form.attr('action'),
                        type: 'POST',
                        data: $form.serialize(),
                        dataType: 'json',
                        success: function (response) {
                            const count = response.count || 0;
                            updateCartBadge(count);
                            showCartToast(response.message || 'Product added to cart.', response.success === false ? 'error' : 'success');
                        },
                        error: function (xhr) {
                            const response = xhr.responseJSON || {};
                            showCartToast(response.message || 'Something went wrong. Please try again.', 'error');
                        },
                        complete: function () {
                            $button.prop('disabled', false).html(originalText);
                        }
                    });
                });
            });
        </script>

        @if(session('already_in_cart'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    showCartToast(@json(session('already_in_cart') . ' is already in your cart. You can change its quantity from the cart page.'), 'error');
                });
            </script>
        @endif
    </body>
    </html>