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
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
                    const badge = document.getElementById('cart-badge');
                    if (badge) {
      
                  if (Number(count) > 0) {
                            badge.textContent = count;
      
                      } else {
                            badge.remove();
        
                    }
                        return;
                    }

    
                    const cartLink = document.getElementById('cart-icon-btn');
                    if (cartLink && Number(count) > 0) {
                        const badgeEl = document.createElement('span');
    
                        badgeEl.id = 'cart-badge';
                        badgeEl.className = 'cart-badge';
    
                        badgeEl.textContent = count;
                        cartLink.appendChild(badgeEl);

                    }
                }

                
function formatCurrency(value) {
      return 'Rs ' + Number(value || 0).toLocaleString('en-US');
}
                

     function syncCartSummary(data) {
                    if (!data) return;
     

                   const subtotalEl = document.querySelector('[data-summary-subtotal]');
                    const shippingEl = document.querySelector('[data-summary-shipping]');
    
                const totalEl = document.querySelector('[data-summary-total]');

                
                    if (subtotalEl && typeof data.subtotal !== 'undefined') subtotalEl.textContent = formatCurrency(data.subtotal);
    
                if (shippingEl && typeof data.shipping !== 'undefined') shippingEl.textContent = formatCurrency(data.shipping);
    
                if (totalEl && typeof data.total !== 'undefined') totalEl.textContent = formatCurrency(data.total);
                }

                function syncCartItem(data) {
                    if (!data || !data.item) return;

        
                const itemRow = document.querySelector('[data-cart-item-id="' + data.item.id + '"]');
                    if (!itemRow) return;

                    const qtyEl = itemRow.querySelector('[data-item-qty]');
                    const totalEl = itemRow.querySelector('[data-item-total]');

                    if (qtyEl) qtyEl.textContent = data.item.qty;
                    if (totalEl) totalEl.textContent = formatCurrency(data.item.line_total);

                    const minusInput = itemRow.querySelector('form[id^="updateCartForm-decrement-"] input[name="qty"]');
                    const plusInput = itemRow.querySelector('form[id^="updateCartForm-increment-"] input[name="qty"]');
                    if (minusInput) minusInput.value = Math.max(0, Number(data.item.qty) - 1);
                    if (plusInput) plusInput.value = Number(data.item.qty) + 1;
                }

                $(document).on('submit', 'form[id^="addToCartForm"]', function (event) {
                    event.preventDefault();

                    const cartForm = this;
                    const csrfToken = $(cartForm).find('input[name="_token"]').val()
                        || $('meta[name="csrf-token"]').attr('content')
                        || '';
                    const button = $(cartForm).find('button[type="submit"]');
                    const originalText = button.html();

                    button.prop('disabled', true).html('Adding...');

                    $.ajax({
                        url: cartForm.action,
                        method: 'POST',
                        data: new FormData(cartForm),
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                        

                      .done(function (response) {
                        updateCartBadge(Number(response.count || 0));
                        showCartToast(
                            response.messsage || 'Product added to cart.',
                            response.success === false ? 'error' : 'success'
                        );
                      })

                        .fail(function (xhr) {
                            if (xhr.status === 419) {
                                showCartToast('Your page session expired. Reloading...', 'error');
                                setTimeout(function () {
                                    window.location.reload();
                                }, 800);
                                return;
                            }
                        

                            const message = xhr.responseJSON?.message || 'Something went wrong. Please try again.';
                            showCartToast(message, 'error');
                        })
                        .always(function () {
                            button.prop('disabled', false).html(originalText);
                        });
                });

                $(document).on('submit', 'form[id^="updateCartForm-"]', function (event) {
                    event.preventDefault();

                    const updateForm = this;
                    const csrfToken = $(updateForm).find('input[name="_token"]').val()
                        || $('meta[name="csrf-token"]').attr('content')
                        || '';

                    $.ajax({
                        url: updateForm.action,
                        method: 'POST',
                        data: new FormData(updateForm),
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })

                        .done(function (response) {
                            if (!response || !response.success) {
                                showCartToast(response?.message || 'Unable to update cart.', 'error');
                                return;
                            }

                            if (Number(response.item?.qty) === 0) {
                                document.querySelector('[data-cart-item-id="' + response.item.id + '"]')?.remove();
                            } else {
                                syncCartItem(response);
                            }

                            syncCartSummary(response);
                            updateCartBadge(Number(response.count || 0));
                        })
                        .fail(function (xhr) {
                            if (xhr.status === 419) {
                                showCartToast('Your page session expired. Reloading...', 'error');
                                setTimeout(function () {
                                    window.location.reload();
                                }, 800);
                                return;
                            }
                            const message = xhr.responseJSON?.message || 'Unable to update cart.';
                            showCartToast(message, 'error');
                        });
                });

                $(document).on('submit', 'form[id^="removeCartForm-"]', function (event) {
                    event.preventDefault();

                    const removeForm = this;
                    const csrfToken = $(removeForm).find('input[name="_token"]').val()
                        || $('meta[name="csrf-token"]').attr('content')
                        || '';
                    const itemId = removeForm.action.split('/').pop();


                    $.ajax({
                        url: removeForm.action,
                        method: 'POST',
                        data: new FormData(removeForm),
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })





                        .done(function (response) {
                            if (!response || !response.success) {
                                showCartToast(response?.message || 'Unable to remove item.', 'error');
                                return;
                            }

                            document.querySelector('[data-cart-item-id="' + itemId + '"]')?.remove();
                            syncCartSummary(response);
                            updateCartBadge(Number(response.count || 0));
                        })
                        .fail(function (xhr) {
                            if (xhr.status === 419) {
                                showCartToast('Your page session expired. Reloading...', 'error');
                                setTimeout(function () {
                                    window.location.reload();
                                }, 800);
                                return;
                            }
                            const message = xhr.responseJSON?.message || 'Unable to remove item.';
                            showCartToast(message, 'error');
                        });
                });
            </script>
            @if(session('already_in_cart'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        showCartToast(
                            @json(session('already_in_cart') . ' is already in your cart. You can change its quantity from the cart page'),
                            'error'
                        );
                    });
                </script>
            @endif
        </body>
        </html>



