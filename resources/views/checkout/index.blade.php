@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

@php
    $discount = 0;
    $total    = $subtotal + $shipping - $discount;

    $inputClass = 'w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm placeholder-gray-400 focus:outline-none focus:border-[#e39320] focus:ring-1 focus:ring-[#e39320]';
    $labelClass = 'block text-sm font-semibold text-gray-900 mb-1.5';

    $areas = [
        'Multan'     => ['Gulgasht', 'DHA', 'New Shalimar Colony', 'Lodhi Colony', 'Shah Rukn-e-Alam Colony'],
        'Faisalabad' => ['Tariqabad', 'GM Abad', 'Rachna Town', 'Madinah Colony', 'Model Town'],
        'Karachi'    => ['Gulshan-e-Iqbal', 'Malir Cantt', 'University Road', 'Lasbela', 'Clifton'],
        'Lahore'     => ['DHA', 'Bahria Town', 'Gulberg', 'Model Town'],
        'Rawalpindi' => ['Tariqabad', 'Raja Bazar', 'Satellite Town', 'Saddar', 'Chaklala'],
        'Hyderabad'  => ['Ottoban Road', 'Lateefabad', 'Qasimabad'],
    ];
@endphp

<div class="bg-white min-h-screen">
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-10">

@if(empty($cart))
    <div class="text-center py-20">
        <p class="text-gray-500 mb-6">Your cart is empty now.</p>
        <a href="{{ route('home') }}"
           class="inline-block bg-[#e39320] text-white px-6 py-3 rounded-lg font-medium">
            Start shopping
        </a>
    </div>
@else

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 items-start">

    <section class="lg:col-span-2 border border-gray-200 rounded-2xl overflow-hidden">
        <header class="bg-[#f6eee2] text-center font-bold text-gray-800 py-4">
            Shipping details
        </header>

        <div class="p-5 sm:p-6">
            <p class="font-semibold text-gray-800 mb-6">
                Enter your contact details and delivery address.
            </p>

            <form id="addressForm" class="space-y-4">

                <div>
                    <label class="{{ $labelClass }}">Full name <span class="text-red-500">*</span></label>
                    <input type="text" name="full_name" required class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="{{ $labelClass }}">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="{{ $labelClass }}">Phone <span class="text-red-500">*</span></label>
                    <input type="tel" name="phone" required class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="{{ $labelClass }}">Area <span class="text-red-500">*</span></label>
                    <select name="area" required class="{{ $inputClass }} bg-white">
                        <option value="">Choose area</option>
                        @foreach($areas as $city => $list)
                            <optgroup label="{{ $city }}">
                                @foreach($list as $area)
                                    <option value="{{ $city }} - {{ $area }}">{{ $area }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="{{ $labelClass }}">Block number <span class="text-red-500">*</span></label>
                    <input type="text" name="block" placeholder="Enter number" required class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="{{ $labelClass }}">Street name <span class="text-red-500">*</span></label>
                    <input type="text" name="street" placeholder="Enter street name" required class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="{{ $labelClass }}">Building number <span class="text-red-500">*</span></label>
                    <input type="text" name="building" placeholder="Enter number" required class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="{{ $labelClass }}">Floor</label>
                    <input type="text" name="floor" placeholder="Enter floor" class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="{{ $labelClass }}">Apartment</label>
                    <input type="text" name="apartment" placeholder="Enter apartment" class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="{{ $labelClass }}">PACI number</label>
                    <input type="text" name="paci" placeholder="Enter PACI number" class="{{ $inputClass }}">
                </div>

                                <button type="button" id="saveAddressBtn"
                        class="w-full bg-[#e39320] hover:bg-[#cf8214] text-white font-semibold py-3 rounded-full transition">
                    Save
                </button>
            </form>
        </div>
    </section>

    <aside class="space-y-6">

        <div class="border border-gray-200 rounded-2xl overflow-hidden">
            <header class="bg-[#f6eee2] text-center font-semibold text-gray-800 py-4">
                Discount code
            </header>
            <div class="p-5 space-y-3">
                <input type="text" placeholder="Enter the discount coupon" class="{{ $inputClass }}">
                <button type="button"
                        class="w-full bg-[#e39320] hover:bg-[#cf8214] text-white font-semibold py-2.5 rounded-lg transition">
                    Apply
                </button>
            </div>
        </div>

        <div class="border border-gray-200 rounded-2xl overflow-hidden">
            <header class="bg-[#f6eee2] text-center font-bold text-gray-800 py-4">
                Payment summary
            </header>

            <div class="p-5 space-y-3">
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Subtotal</span>
                    <span>Rs {{ number_format($subtotal) }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Delivery fee</span>
                    <span>Rs {{ number_format($shipping) }}</span>
                </div>
                <div class="flex justify-between text-sm font-semibold text-red-500">
                    <span>Discount code</span>
                    <span>Rs {{ number_format($discount) }}</span>
                </div>
                <div class="flex justify-between border-t border-gray-200 pt-3 font-bold text-gray-900">
                    <span>Total</span>
                    <span>Rs {{ number_format($total) }}</span>
                </div>

                <div class="pt-2">
                    <label class="{{ $labelClass }}">Delivery notes (optional)</label>
                    <textarea rows="3" name="notes"
                              placeholder="e.g. preferred delivery time, gate code, or other instructions"
                              class="{{ $inputClass }} resize-none"></textarea>
                </div>

                <p id="addressWarning" class="text-sm text-red-500 leading-relaxed">                    Please add a complete shipping address (area, block, street, and building) before confirming your order.
                </p>

                <a href="#addressForm"
                   class="block text-center w-full border-2 border-[#e39320] text-[#e39320] font-semibold py-2.5 rounded-full hover:bg-[#fdf5ea] transition">
                    Add address
                </a>

                             <button type="button" id="confirmBtn" disabled
                        class="w-full bg-[#e39320] text-white font-semibold py-3 rounded-full transition disabled:opacity-50 disabled:cursor-not-allowed">
                    Confirm payment
                </button>
            </div>
        </div>

    </aside>
</div>

@endif

</div>
</div>


@endsection