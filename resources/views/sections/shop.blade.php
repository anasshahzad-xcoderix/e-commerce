<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="{{ asset('css/shop-cards.css') }}">

@php
    $activeCat = request('cat');
    $search    = request('q');
    $sort      = request('sort', 'featured');

    $navBase   = 'my-2 block rounded bg-zinc-100 px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 transition-colors duration-200 hover:bg-zinc-200 md:me-4';
    $navActive = 'my-2 block rounded bg-amber-100 px-7 pb-3.5 pt-4 text-xs font-bold uppercase leading-tight text-amber-700 md:me-4';

    $applyBtn  = 'inline-flex items-center rounded-full border-2 border-slate-900 bg-white px-5 py-2 text-sm font-bold text-slate-900 transition-all duration-200 hover:-translate-y-0.5 hover:bg-amber-400 active:scale-95';
@endphp

<section class="shop" id="shop">

    <div class="shop-head">
        <div>
            <h2>The shop</h2>
            <p class="shop-count"><span>{{ $products->count() }}</span> products</p>
        </div>

        <form method="GET" action="{{ route('shop') }}" class="shop-tools">
            @if($activeCat)
                <input type="hidden" name="cat" value="{{ $activeCat }}">
            @endif

            <input type="search" name="q" value="{{ $search }}" class="shop-search" placeholder="Search products...">

            <select name="sort" class="shop-sort">
                <option value="featured" @selected($sort === 'featured')>Featured</option>
                <option value="low" @selected($sort === 'low')>Price: low to high</option>
                <option value="high" @selected($sort === 'high')>Price: high to low</option>
            </select>

            <button type="submit" class="{{ $applyBtn }}">Apply</button>
        </form>
    </div>

    <ul class="mb-5 flex list-none flex-col flex-wrap ps-0 md:flex-row" role="tablist">
        <li role="presentation">
            <a href="{{ route('shop', array_filter(['q' => $search, 'sort' => $sort])) }}"
               role="tab"
               class="{{ empty($activeCat) ? $navActive : $navBase }}">All</a>
        </li>

        @foreach($categories as $cat)
            <li role="presentation">
                <a href="{{ route('shop', array_filter(['cat' => $cat->slug, 'q' => $search, 'sort' => $sort])) }}"
                   role="tab"
                   class="{{ $activeCat === $cat->slug ? $navActive : $navBase }}">{{ $cat->name }}</a>
            </li>
        @endforeach
    </ul>

    <div class="yp-grid" id="shopGrid">
        @forelse($products as $product)
            @php $cat = $product->getRelationValue('category'); @endphp
            <article class="yp-card">

                <div class="yp-media">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="yp-img">
                    @else
                        <x-icon name="{{ $product->art ?? 'mug' }}" class="product-art" />
                    @endif
                </div>

                <div class="yp-info">
                    <span class="yp-cat">{{ $cat?->name }}</span>
                    <h3 class="yp-title">{{ $product->name }}</h3>
                    <p class="yp-desc">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>

                    <div class="yp-bottom">
                        <span class="yp-price">Rs {{ number_format($product->price) }}</span>
                        <form method="POST" action="{{ route('cart.add', $product) }}">
                            @csrf
                            <button type="submit" class="add-btn">Add to cart</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <p class="yp-empty">Is filter mein koi product nahi mila.</p>
        @endforelse
    </div>

</section>