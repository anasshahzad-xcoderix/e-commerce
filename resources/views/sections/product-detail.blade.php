<script src="https://cdn.tailwindcss.com"></script>

@php $cat = $product->category; @endphp

<section class="mx-auto max-w-7xl px-4 pb-24 pt-6 sm:px-6 lg:px-8 lg:pb-12">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex flex-wrap items-center gap-1.5 text-xs text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-slate-900">Home</a>
        <span>/</span>
        <a href="{{ route('home') }}#shop" class="hover:text-slate-900">Shop</a>
        @if($cat)
            <span>/</span>
            <a href="{{ route('home', ['cat' => $cat->slug]) }}#shop" class="hover:text-slate-900">{{ $cat->name }}</a>
        @endif
        <span>/</span>
        <span class="font-semibold text-slate-800">{{ $product->name }}</span>
    </nav>

    <div class="grid gap-8 lg:grid-cols-2 lg:gap-12">

        {{-- Left: image --}}
        <div>
            <div class="relative overflow-hidden rounded-2xl bg-slate-100 ring-1 ring-slate-200">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}"
                         class="aspect-[4/3] w-full object-contain p-4 sm:aspect-[16/10]">
                @else
                    <div class="flex aspect-[4/3] items-center justify-center sm:aspect-[16/10]">
                        <x-icon name="{{ $product->art ?? 'mug' }}" size="160" />
                    </div>
                @endif

                @if($product->stock < 1)
                    <span class="absolute left-4 top-4 rounded bg-slate-900 px-3 py-1 text-xs font-bold uppercase tracking-wide text-white">Sold out</span>
                @endif
            </div>
        </div>

        {{-- Right: info --}}
        <div class="flex flex-col">

            @if($cat)
                <span class="w-fit rounded-md border border-amber-300 bg-amber-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-amber-700">
                    {{ $cat->name }}
                </span>
            @endif

            <h1 class="mt-3 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl lg:text-4xl">
                {{ $product->name }}
            </h1>

            {{-- Price box --}}
            @php $onSale = $product->compare_price && $product->compare_price > $product->price; @endphp

            <div class="mt-5 rounded-2xl border-l-4 border-amber-400 bg-slate-50 p-5">
                <div class="flex flex-wrap items-end gap-3">
                    <p class="text-3xl font-extrabold text-slate-900">Rs {{ number_format($product->price) }}</p>
                    @if($onSale)
                        <p class="pb-1 text-sm text-slate-400 line-through">Rs {{ number_format($product->compare_price) }}</p>
                    @endif
                </div>

                @if($onSale)
                    <div class="mt-3 flex flex-wrap items-center gap-2 text-sm">
                        <span class="rounded-full bg-emerald-50 px-3 py-1 font-semibold text-emerald-700">
                            You save Rs {{ number_format($product->compare_price - $product->price) }}
                        </span>
                        <span class="font-semibold text-red-600">
                            {{ round((1 - $product->price / $product->compare_price) * 100) }}% OFF
                        </span>
                    </div>
                @endif

                <p class="mt-3 text-sm font-semibold {{ $product->stock > 0 ? 'text-emerald-600' : 'text-red-600' }}">
                    {{ $product->stock > 0 ? 'in stock (' . $product->stock . ')' : 'Sold out' }}
                </p>
            </div>

            <p class="mt-5 leading-relaxed text-slate-600">{{ $product->description }}</p>

            {{-- Store card --}}
            <div class="mt-6 flex items-center gap-4 rounded-xl border border-slate-200 p-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-slate-900 text-sm font-bold text-amber-400">YS</div>
                <div class="min-w-0">
                    <p class="truncate font-bold text-slate-900">Yousaf Store</p>
                    <p class="text-xs font-semibold text-emerald-600">✓ Verified</p>
                </div>
                <a href="{{ route('home') }}#shop"
                   class="ml-auto shrink-0 rounded-full border border-slate-300 px-4 py-2 text-xs font-bold text-slate-900 transition hover:bg-slate-900 hover:text-white">
                    view Shop
                </a>
            </div>

            {{-- Buy bar --}}
            <div class="sticky bottom-0 z-10 -mx-4 mt-6 border-t border-slate-200 bg-white/95 px-4 py-3 backdrop-blur sm:-mx-0 sm:border-0 sm:bg-transparent sm:p-0 lg:static">
                <form method="POST" action="{{ route('cart.add', $product) }}" class="flex items-center gap-3" data-ajax-cart-form>
                    @csrf
                    <button type="submit" @disabled($product->stock < 1)
                            class="flex flex-1 items-center justify-center gap-3 rounded-xl bg-amber-400 px-5 py-3.5 font-bold text-slate-900 shadow transition hover:bg-amber-500 active:scale-[0.98] disabled:cursor-not-allowed disabled:bg-slate-300">
                        <span>Add to cart</span>
                        <span class="rounded-md bg-slate-900 px-2.5 py-1 text-xs text-amber-400">Rs {{ number_format($product->price) }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Details --}}
    <div class="mt-14 grid gap-4 sm:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 p-5">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Collection</p>
            <p class="mt-2 font-bold text-slate-900">{{ $cat?->name ?? '-' }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200 p-5">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Availability</p>
            <p class="mt-2 font-bold text-slate-900">{{ $product->stock > 0 ? 'In stock' : 'Out of stock' }}</p>
        </div>
    </div>

    {{-- Related products --}}
    @if($related->count())
        <div class="mt-14">
            <h2 class="mb-6 text-xl font-extrabold text-slate-900 sm:text-2xl">Related products</h2>

            <div class="grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-4">
                @foreach($related as $item)
                    <a href="{{ route('product.show', $item) }}"
                       class="group block overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200 transition hover:-translate-y-1 hover:shadow-xl">
                        <div class="aspect-square overflow-hidden bg-slate-100">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}"
                                     alt="{{ $item->name }}"
                                     class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="flex h-full items-center justify-center">
                                    <x-icon name="{{ $item->art ?? 'mug' }}" size="64" />
                                </div>
                            @endif
                        </div>
                        <div class="p-3 sm:p-4">
                            <h3 class="truncate font-bold text-slate-900">{{ $item->name }}</h3>
                            <p class="text-sm font-semibold text-slate-600">Rs {{ number_format($item->price) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</section>