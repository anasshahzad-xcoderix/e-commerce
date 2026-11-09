@extends('layouts.app')

@section('title', 'Cart')

@section('content')

<div class="min-h-screen bg-[#f7f3ec]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-10">

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">Your Cart</h1>

        @if(session('added'))
            <div class="mb-6 rounded-xl bg-green-50 border border-green-300 text-green-800 px-4 py-3 text-sm">
                "{{ session('added') }}" cart mein add ho gaya.
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-xl bg-red-50 border border-red-300 text-red-800 px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if(empty($cart))
            <div class="text-center py-16 sm:py-24 bg-white rounded-2xl border-2 border-gray-300">
                <p class="text-gray-500 text-lg mb-6">Your cart is empty.</p>
                <a href="{{ route('home') }}"
                   class="inline-block bg-[#e39320] hover:bg-[#cf8214] text-white px-6 py-3 rounded-full text-sm font-semibold transition">
                    Start Shopping
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 items-start">

                {{-- Cart items --}}
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cart as $item)
                        <div class="bg-white rounded-2xl border-2 border-gray-300 shadow-sm p-4 sm:p-5 flex flex-col sm:flex-row gap-4">

                            {{-- Image + name + price --}}
                            <div class="flex gap-4 flex-1 min-w-0">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-shrink-0 rounded-xl border border-gray-300 bg-gray-50 overflow-hidden flex items-center justify-center">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}"
                                             alt="{{ $item['name'] }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <x-icon name="{{ $item['art'] ?? 'mug' }}" size="48" />
                                    @endif
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h3 class="font-semibold text-gray-900 truncate">{{ $item['name'] }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">Rs {{ number_format($item['price']) }}</p>
                                </div>
                            </div>

                            {{-- Quantity, total, delete --}}
                            <div class="flex items-center justify-between sm:justify-end gap-4 sm:gap-6">

                                <div class="flex items-center border-2 border-gray-300 rounded-full overflow-hidden bg-white">
                                    <form method="POST" action="{{ route('cart.update', $item['id']) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="qty" value="{{ $item['qty'] - 1 }}">
                                        <button type="submit"
                                                class="w-9 h-9 hover:bg-gray-100 text-gray-700 font-semibold transition">−</button>
                                    </form>

                                    <span class="w-9 text-center text-sm font-medium">{{ $item['qty'] }}</span>

                                    <form method="POST" action="{{ route('cart.update', $item['id']) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="qty" value="{{ $item['qty'] + 1 }}">
                                        <button type="submit"
                                                class="w-9 h-9 hover:bg-gray-100 text-gray-700 font-semibold transition">+</button>
                                    </form>
                                </div>

                                <div class="font-bold text-gray-900 whitespace-nowrap min-w-[90px] text-right">
                                    Rs {{ number_format($item['price'] * $item['qty']) }}
                                </div>

                                                                <form method="POST"
                                      action="{{ route('cart.remove', $item['id']) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-9 h-9 flex items-center justify-center rounded-full border-2 border-red-200 text-red-600 hover:bg-red-50 transition"
                                            title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Summary --}}
                <aside class="bg-white rounded-2xl border-2 border-gray-300 shadow-sm p-6 lg:sticky lg:top-24">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Summary</h2>

                    <div class="flex justify-between py-2 text-sm text-gray-600">
                        <span>Subtotal</span>
                        <span>Rs {{ number_format($subtotal) }}</span>
                    </div>
                    <div class="flex justify-between py-2 text-sm text-gray-600">
                        <span>Delivery</span>
                        <span>Rs {{ number_format($shipping) }}</span>
                    </div>
                    <div class="flex justify-between py-3 mt-2 border-t-2 border-gray-300 font-bold text-gray-900 text-lg">
                        <span>Total</span>
                        <span>Rs {{ number_format($subtotal + $shipping) }}</span>
                    </div>

                    <a href="{{ route('checkout') }}"
                       class="block text-center w-full mt-5 bg-[#e39320] hover:bg-[#cf8214] text-white py-3 rounded-full font-semibold transition">
                        Checkout
                    </a>

                    <a href="{{ route('home') }}"
                       class="block text-center mt-4 text-sm text-gray-600 hover:text-gray-900 hover:underline">
                        ← Continue Shopping
                    </a>
                </aside>

            </div>
        @endif

    </div>
</div>
@endsection