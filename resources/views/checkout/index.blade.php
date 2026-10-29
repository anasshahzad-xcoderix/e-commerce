@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">

<main class="co">

    @if(session('added'))
        <div class="co-toast">✓ {{ session('added') }} Order add in the cart</div>
    @endif

    @if(session('error'))
        <div class="co-toast co-toast-err">{{ session('error') }}</div>
    @endif

    @if(session('ordered'))
        <div class="co-overlay">
            <div class="co-success">
                <svg viewBox="0 0 52 52" class="co-check">
                    <circle cx="26" cy="26" r="24"/>
                    <path d="M14 27 l8 8 l16 -18"/>
                </svg>
                <h2>Order has been placed!</h2>
                <p>.</p>
                <a href="{{ url('/shop') }}" class="co-btn">continue to shopping</a>
            </div>
        </div>
    @endif

    <header class="co-head">
        <h1>Checkout</h1>
        <a href="{{ url('/shop') }}" class="co-back">← Back to shop</a>
    </header>

    @if(count($cart) === 0)
        <div class="co-empty">
            <h2>Empty Cart</h2>
            <a href="{{ url('/shop') }}" class="co-btn">Show the shop</a>
        </div>
    @else
        <div class="co-grid">

            <section class="co-items">
                @foreach($cart as $i => $item)
                    <article class="co-item" style="--d: {{ $i * 90 }}ms">
                        <div class="co-thumb">
                            @if(!empty($item['image']))
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                            @else
                                <x-icon name="{{ $item['art'] ?? 'basket' }}" size="40" />
                            @endif
                        </div>

                        <div class="co-info">
                            <h3>{{ $item['name'] }}</h3>
                            <p>Rs {{ number_format($item['price']) }}</p>
                        </div>

                        <div class="co-qty">
                            <form method="POST" action="{{ route('cart.update', $item['id']) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="qty" value="{{ $item['qty'] - 1 }}">
                                <button class="qbtn" aria-label="less">−</button>
                            </form>

                            <span>{{ $item['qty'] }}</span>

                            <form method="POST" action="{{ route('cart.update', $item['id']) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="qty" value="{{ $item['qty'] + 1 }}">
                                <button class="qbtn" aria-label="More">+</button>
                            </form>
                        </div>

                        <div class="co-line">Rs {{ number_format($item['price'] * $item['qty']) }}</div>

                        <form method="POST" action="{{ route('cart.remove', $item['id']) }}">
                            @csrf
                            @method('DELETE')
                            <button class="co-remove" aria-label="Remove">✕</button>
                        </form>
                    </article>
                @endforeach
            </section>

            <aside class="co-summary">
                <h2>Order summary</h2>

                <div class="co-row"><span>Subtotal</span><span>Rs {{ number_format($subtotal) }}</span></div>
                <div class="co-row"><span>Delivery</span><span>Rs {{ number_format($shipping) }}</span></div>
                <div class="co-row co-total"><span>Total</span><span>Rs {{ number_format($subtotal + $shipping) }}</span></div>

                <form method="POST" action="{{ route('checkout.place') }}" class="co-form">
                    @csrf
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Your Name">
                    @error('name') <small class="co-err">{{ $message }}</small> @enderror

                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone number">
                    @error('phone') <small class="co-err">{{ $message }}</small> @enderror

                    <textarea name="address" rows="3" placeholder="Your Adress">{{ old('address') }}</textarea>
                    @error('address') <small class="co-err">{{ $message }}</small> @enderror

                    <button type="submit" class="co-btn co-pay">Comfirm Order</button>
                </form>
            </aside>

        </div>
    @endif
</main>
@endsection