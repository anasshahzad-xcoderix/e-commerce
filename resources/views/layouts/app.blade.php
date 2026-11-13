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
    const badge = document.querySelector('.cart-badge');
    if (badge) {
        badge.textContent = count;
        return;
    }

    const cartLink = document.querySelector('.cart-icon-btn');
    if (cartLink && count > 0) {
        const badgeEl = document.createElement('span');
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

    const minusInput = itemRow.querySelector('form[data-cart-update-form][data-cart-update-action="decrement"] input[name="qty"]');
    const plusInput = itemRow.querySelector('form[data-cart-update-form][data-cart-update-action="increment"] input[name="qty"]');

    if (minusInput) minusInput.value = Math.max(0, Number(data.item.qty) - 1);
    if (plusInput) plusInput.value = Number(data.item.qty) + 1;
}

function removeCartItemRow(data) {
    if (!data || !data.item || !data.item.id) return;

    const itemRow = document.querySelector('[data-cart-item-id="' + data.item.id + '"]');
    if (itemRow) itemRow.remove();
}

document.addEventListener('submit', function (event) {
    const cartForm = event.target.closest('form[data-ajax-cart-form]');
    if (cartForm) {
        event.preventDefault();
        event.stopPropagation();

        const button = cartForm.querySelector('button[type="submit"]');
        const originalText = button ? button.innerHTML : '';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (button) {
            button.disabled = true;
            button.innerHTML = 'Adding...';
        }

        fetch(cartForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken || '',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: new FormData(cartForm),
            credentials: 'same-origin'
        })
            .then(async (response) => {
                const data = await response.json().catch(() => ({}));
                const count = Number(data.count || 0);
                updateCartBadge(count);
                showCartToast(data.message || 'Product added to cart.', data.success === false ? 'error' : 'success');
            })
            .catch(() => {
                showCartToast('Something went wrong. Please try again.', 'error');
            })
            .finally(() => {
                if (button) {
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            });

        return;
    }

    const updateForm = event.target.closest('form[data-cart-update-form]');
    if (updateForm) {
        event.preventDefault();
        event.stopPropagation();

        const method = updateForm.method || 'POST';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch(updateForm.action, {
            method: method.toUpperCase(),
            headers: {
                'X-CSRF-TOKEN': csrfToken || '',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: new FormData(updateForm),
            credentials: 'same-origin'
        })
            .then(async (response) => {
                const data = await response.json().catch(() => ({}));
                if (!data || !data.success) {
                    showCartToast(data.message || 'Unable to update cart.', 'error');
                    return;
                }

                syncCartItem(data);
                syncCartSummary(data);
                updateCartBadge(Number(data.count || 0));
            })
            .catch(() => {
                showCartToast('Unable to update cart.', 'error');
            });

        return;
    }

    const removeForm = event.target.closest('form[data-cart-remove-form]');
    if (removeForm) {
        event.preventDefault();
        event.stopPropagation();

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const itemId = removeForm.action.split('/').pop();

        fetch(removeForm.action, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken || '',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: new FormData(removeForm),
            credentials: 'same-origin'
        })
            .then(async (response) => {
                const data = await response.json().catch(() => ({}));
                if (!data || !data.success) {
                    showCartToast(data.message || 'Unable to remove item.', 'error');
                    return;
                }

                const itemRow = document.querySelector('[data-cart-item-id="' + itemId + '"]');
                if (itemRow) itemRow.remove();
                syncCartSummary(data);
                updateCartBadge(Number(data.count || 0));
            })
            .catch(() => {
                showCartToast('Unable to remove item.', 'error');
            });
    }
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