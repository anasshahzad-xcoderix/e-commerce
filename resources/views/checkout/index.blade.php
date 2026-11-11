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

@if(session('success'))
    <div class="mb-6 rounded-xl bg-green-50 border border-green-300 text-green-700 px-4 py-3 text-sm">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-6 rounded-xl bg-red-50 border border-red-300 text-red-700 px-4 py-3 text-sm">
        {{ session('error') }}
    </div>
@endif

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

    {{-- LEFT: Shipping details --}}
    <section class="lg:col-span-2 border border-gray-200 rounded-2xl overflow-hidden">
        <header class="bg-[#f6eee2] text-center font-bold text-gray-800 py-4">
            Shipping details
        </header>

        <div class="p-5 sm:p-6">
            <p class="font-semibold text-gray-800 mb-6">
                Enter your contact details and delivery address.
            </p>

            @if($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 border border-red-300 text-red-700 px-4 py-3 text-sm" role="alert">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="addressForm" method="POST" action="{{ route('checkout.place') }}" class="space-y-4" novalidate>
                @csrf

                <div>
                    <label class="{{ $labelClass }}">Full name <span class="text-red-500">*</span></label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" class="{{ $inputClass }} {{ $errors->has('full_name') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}" aria-invalid="{{ $errors->has('full_name') ? 'true' : 'false' }}" aria-describedby="full_name-error" required maxlength="100">
                    @error('full_name') <p id="full_name-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="{{ $inputClass }} {{ $errors->has('email') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" aria-describedby="email-error" required maxlength="150">
                    @error('email') <p id="email-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">Phone <span class="text-red-500">*</span></label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" class="{{ $inputClass }} {{ $errors->has('phone') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}" aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}" aria-describedby="phone-error" required maxlength="20">
                    @error('phone') <p id="phone-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">Area <span class="text-red-500">*</span></label>
                    <select name="area" class="{{ $inputClass }} bg-white {{ $errors->has('area') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}" aria-invalid="{{ $errors->has('area') ? 'true' : 'false' }}" aria-describedby="area-error" required>
                        <option value="">Choose area</option>
                        @foreach($areas as $city => $list)
                            <optgroup label="{{ $city }}">
                                @foreach($list as $area)
                                    <option value="{{ $city }} - {{ $area }}" @selected(old('area') === "$city - $area")>{{ $area }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('area') <p id="area-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">Block number <span class="text-red-500">*</span></label>
                    <input type="text" name="block" value="{{ old('block') }}" placeholder="Enter number" class="{{ $inputClass }} {{ $errors->has('block') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}" aria-invalid="{{ $errors->has('block') ? 'true' : 'false' }}" aria-describedby="block-error" required maxlength="20">
                    @error('block') <p id="block-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">Street name <span class="text-red-500">*</span></label>
                    <input type="text" name="street" value="{{ old('street') }}" placeholder="Enter street name" class="{{ $inputClass }} {{ $errors->has('street') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}" aria-invalid="{{ $errors->has('street') ? 'true' : 'false' }}" aria-describedby="street-error" required maxlength="150">
                    @error('street') <p id="street-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">Building number <span class="text-red-500">*</span></label>
                    <input type="text" name="building" value="{{ old('building') }}" placeholder="Enter number" class="{{ $inputClass }} {{ $errors->has('building') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}" aria-invalid="{{ $errors->has('building') ? 'true' : 'false' }}" aria-describedby="building-error" required maxlength="50">
                    @error('building') <p id="building-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">Floor</label>
                    <input type="text" name="floor" value="{{ old('floor') }}" placeholder="Enter floor" class="{{ $inputClass }} {{ $errors->has('floor') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}" aria-invalid="{{ $errors->has('floor') ? 'true' : 'false' }}" aria-describedby="floor-error">
                    @error('floor') <p id="floor-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">Apartment</label>
                    <input type="text" name="apartment" value="{{ old('apartment') }}" placeholder="Enter apartment" class="{{ $inputClass }} {{ $errors->has('apartment') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}" aria-invalid="{{ $errors->has('apartment') ? 'true' : 'false' }}" aria-describedby="apartment-error">
                    @error('apartment') <p id="apartment-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="{{ $labelClass }}">PACI number</label>
                    <input type="text" name="paci" value="{{ old('paci') }}" placeholder="Enter PACI number" class="{{ $inputClass }} {{ $errors->has('paci') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}" aria-invalid="{{ $errors->has('paci') ? 'true' : 'false' }}" aria-describedby="paci-error">
                    @error('paci') <p id="paci-error" class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                        class="w-full bg-[#e39320] hover:bg-[#cf8214] text-white font-semibold py-3 rounded-full transition">
                    Save
                </button>
            </form>
        </div>
    </section>

    {{-- RIGHT: Discount + Payment summary --}}
    <aside class="space-y-6">

        {{-- Discount code --}}
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

        {{-- Payment summary --}}
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
                    <textarea rows="3" name="notes" form="addressForm"
                              placeholder="e.g. preferred delivery time, gate code, or other instructions"
                              class="{{ $inputClass }} resize-none {{ $errors->has('notes') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : '' }}"
                              aria-invalid="{{ $errors->has('notes') ? 'true' : 'false' }}" aria-describedby="notes-error">{{ old('notes') }}</textarea>
                    @error('notes') <p id="notes-error" class="text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <a href="#addressForm"
                   class="block text-center w-full border-2 border-[#e39320] text-[#e39320] font-semibold py-2.5 rounded-full hover:bg-[#fdf5ea] transition">
                    Add address
                </a>

                <button type="submit" form="addressForm"
                        class="w-full bg-[#e39320] hover:bg-[#cf8214] text-white font-semibold py-3 rounded-full transition">
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