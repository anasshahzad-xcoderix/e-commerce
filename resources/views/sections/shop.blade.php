<link rel="stylesheet" href="{{ asset('css/shop-cards.css') }}">

<section class="shop" id="shop">

    <div class="shop-head">
        <div>
            <h2>The shop</h2>
            <p class="shop-count"><span id="visibleCount">{{ $products->count() }}</span> products</p>
        </div>
        <div class="shop-tools">
            <input type="search" id="shopSearch" class="shop-search" placeholder="Search products...">
            <select id="shopSort" class="shop-sort">
                <option value="featured">Featured</option>
                <option value="low">Price: low to high</option>
                <option value="high">Price: high to low</option>
            </select>
        </div>
    </div>

    <div class="shop-filters" id="shopFilters">
        <button type="button" class="pill active" data-cat="all">All</button>
        @foreach($categories as $cat)
            <button type="button" class="pill" data-cat="{{ $cat->slug }}">{{ $cat->name }}</button>
        @endforeach
    </div>

    <div class="yp-grid" id="shopGrid">
        @forelse($products as $product)
            @php $cat = $product->getRelationValue('category'); @endphp
            <article class="yp-card"
                     data-name="{{ strtolower($product->name) }}"
                     data-price="{{ $product->price }}"
                     data-cat="{{ $cat?->slug }}">

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
            <p class="yp-empty">Abhi koi product nahi hai.</p>
        @endforelse
    </div>

</section>

<script src="{{ asset('js/shop.js') }}"></script>