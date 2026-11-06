@extends('layouts.app')

@section('title', 'Cart')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-6xl mx-auto px-4 py-10">

    <h1 class="text-3xl font-bold mb-6">Your Cart.</h1>

    @if(session('added'))
        <div class="mb-6 rounded-lg bg-green-100 text-green-800 px-4 py-3">
            "{{ session('added') }}" Product has been added to Your cart.
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-100 text-red-800 px-4 py-3">
            {{ session('error') }}
        </div>
    @endif

    @if(empty($cart))
        <div class="text-center py-20 bg-white rounded-xl shadow">
            <p class="text-gray-500 text-lg mb-6">Your Cart is Empty Now.</p>
            <a href="{{ route('home') }}"
               class="inline-block bg-black text-white px-6 py-3 rounded-lg">
                Start Shopping
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $item)
                    <div class="bg-white rounded-xl shadow p-4 flex gap-4 items-center">

                        <div class="w-24 h-24 flex-shrink-0 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}"
                                     alt="{{ $item['name'] }}"
                                     class="w-full h-full object-cover">
                            @else
                                <x-icon name="{{ $item['art'] ?? 'mug' }}" size="60" />
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold truncate">{{ $item['name'] }}</h3>
                            <p class="text-gray-600 mt-1">Rs {{ number_format($item['price']) }}</p>

                            <div class="flex items-center gap-3 mt-3">
                                {{-- Quantity: minus --}}
                                <form method="POST" action="{{ route('cart.update', $item['id']) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="qty" value="{{ $item['qty'] - 1 }}">
                                    <button type="submit" class="w-8 h-8 border rounded hover:bg-gray-100">-</button>
                                </form>

                                <span class="w-8 text-center font-medium">{{ $item['qty'] }}</span>

                                {{-- Quantity: plus --}}
                                <form method="POST" action="{{ route('cart.update', $item['id']) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="qty" value="{{ $item['qty'] + 1 }}">
                                    <button type="submit" class="w-8 h-8 border rounded hover:bg-gray-100">+</button>
                                </form>

                                {{-- Remove --}}
                                <form method="POST" action="{{ route('cart.remove', $item['id']) }}" class="ml-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 text-sm hover:underline">Remove</button>
                                </form>
                            </div>
                        </div>

                        <div class="font-bold whitespace-nowrap">
                            Rs {{ number_format($item['price'] * $item['qty']) }}
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Summary --}}
            <aside class="bg-white rounded-xl shadow p-6 h-fit">
                <h2 class="text-xl font-bold mb-4">Summary</h2>

                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Subtotal</span>
                    <span>Rs {{ number_format($subtotal) }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Delivery</span>
                    <span>Rs {{ number_format($shipping) }}</span>
                </div>
                <div class="flex justify-between py-3 border-t mt-2 font-bold text-lg">
                    <span>Total</span>
                    <span>Rs {{ number_format($subtotal + $shipping) }}</span>
                </div>

               
              
            </aside>

        </div>
    @endif

</div>
@endsection