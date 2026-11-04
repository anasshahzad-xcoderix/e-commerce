<script src="https://cdn.tailwindcss.com"></script>

@php $cat = $product->category; @endphp

<section class="mx-auto max-w-6xl px-6 py-10 md:px-10">

    <a href="{{ route('home') }}#shop" class="text-sm font-semibold text-slate-500 hover:text-slate-900">← Back to shop</a>

    <div class="mt-6 grid gap-10 md:grid-cols-2">

        <div class="overflow-hidden rounded-3xl bg-slate-100 ring-1 ring-slate-200">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                     class="aspect-square h-full w-full object-cover">
            @else
                <div class="flex aspect-square items-center justify-center">
                    <x-icon name="{{ $product->art ?? 'mug' }}" size="180" />
                </div>
            @endif
        </div>

        <div class="flex flex-col">
            <span class="text-xs font-semibold uppercase tracking-wider text-amber-600">{{ $cat?->name }}</span>
            <h1 class="mt-2 text-4xl font-extrabold tracking-tight text-slate-900">{{ $product->name }}</h1>
            <p class="mt-4 text-3xl font-extrabold text-slate-900">Rs {{ number_format($product->price) }}</p>

            <p class="mt-3 text-sm font-semibold {{ $product->stock > 0 ? 'text-emerald-600' : 'text-red-600' }}">
                {{ $product->stock > 0 ? 'Stock: ' . $product->stock : 'Stock end' }}
            </p>

            <p class="mt-6 leading-relaxed text-slate-600">{{ $product->description }}</p>

            <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-8">
                @csrf
                <button type="submit" @disabled($product->stock < 1)
                        class="rounded-full bg-amber-400 px-8 py-3 font-bold text-slate-900 shadow transition hover:bg-amber-500 active:scale-95 disabled:cursor-not-allowed disabled:bg-slate-300">
                    Add to cart
                </button>
            </form>
        </div>
    </div>

    @if($related->count())
        <div class="mt-16">
            <h2 class="mb-6 text-2xl font-extrabold text-slate-900">Related Products</h2>

            <div class="grid grid-cols-2 gap-6 md:grid-cols-4">
                @foreach($related as $item)
                    <a href="{{ route('product.show', $item) }}"
                       class="group block overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200 transition hover:-translate-y-1 hover:shadow-xl">
                        <div class="aspect-square overflow-hidden bg-slate-100">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                     class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="flex h-full items-center justify-center">
                                    <x-icon name="{{ $item->art ?? 'mug' }}" size="64" />
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-900">{{ $item->name }}</h3>
                            <p class="text-sm font-semibold text-slate-600">Rs {{ number_format($item->price) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</section>