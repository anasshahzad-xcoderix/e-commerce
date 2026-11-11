<script src="https://cdn.tailwindcss.com"></script>

@php
    $activeCat = request('cat');
    $search    = request('q');
    $sort      = request('sort', 'featured');

    $navBase   = 'my-2 block rounded-full border-2 border-transparent bg-zinc-100 px-6 py-2.5 text-xs font-semibold uppercase tracking-wide text-neutral-600 transition-all duration-200 hover:-translate-y-0.5 hover:bg-zinc-200';
    $navActive = 'my-2 block rounded-full border-2 border-amber-400 bg-amber-400 px-6 py-2.5 text-xs font-bold uppercase tracking-wide text-slate-900 shadow-lg transition-all duration-200';

    $applyBtn  = 'inline-flex items-center rounded-full bg-slate-900 px-6 py-2.5 text-sm font-bold text-white shadow transition-all duration-200 hover:-translate-y-0.5 hover:bg-amber-400 hover:text-slate-900 active:scale-95';
    $field     = 'rounded-full border border-slate-300 bg-white px-5 py-2.5 text-sm text-slate-800 outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-100';
@endphp

<div id="shop-wrapper">
<section class="mx-auto max-w-7xl px-6 md:px-10 py-10" id="shop">
    <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
        <div>
            <h2 class="text-4xl font-extrabold tracking-tight text-slate-900">The shop</h2>
            <p class="mt-1 text-sm text-slate-500"><span class="font-semibold text-slate-700">{{ $products->count() }}</span> products</p>
        </div>

        <form method="GET" action="{{ route('shop') }}" class="flex flex-wrap items-center gap-3" data-shop-form>
            @if($activeCat)
                <input type="hidden" name="cat" value="{{ $activeCat }}">
            @endif
            
            <input type="search" name="q" value="{{ $search }}" placeholder="Search products..." class="{{ $field }} w-56">
        
            <select name="sort" class="{{ $field }}">
                <option value="featured" @selected($sort === 'featured')>Featured</option>
                <option value="low" @selected($sort === 'low')>Price: low to high</option>
                <option value="high" @selected($sort === 'high')>Price: high to low</option>
            </select>

            <button type="submit" class="{{ $applyBtn }}">Apply</button>
        </form>
    </div>

    <ul class="mb-8 mt-6 flex list-none flex-wrap gap-3 ps-0" role="tablist">
        <li role="presentation">
            <a href="{{ route('shop', array_filter(['q' => $search, 'sort' => $sort])) }}"
               data-shop-link
               role="tab"
               class="{{ empty($activeCat) ? $navActive : $navBase }}">All</a>
        </li>

        @foreach($categories as $cat)
            <li role="presentation">
                <a href="{{ route('shop', array_filter(['cat' => $cat->slug, 'q' => $search, 'sort' => $sort])) }}"
                   data-shop-link
                   role="tab"
                   class="{{ $activeCat === $cat->slug ? $navActive : $navBase }}">{{ $cat->name }}</a>
            </li>
        @endforeach
    </ul>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @forelse($products as $product)
            @php $cat = $product->getRelationValue('category'); @endphp

           <article class="group flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl">

    <a href="{{ route('product.show', $product) }}" class="relative block h-56 overflow-hidden bg-slate-100">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}"
                 alt="{{ $product->name }}"
                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <div class="flex h-full items-center justify-center">
                <x-icon name="{{ $product->art ?? 'mug' }}" size="96" />
            </div>
        @endif
    </a>

    <div class="flex flex-1 flex-col p-5">
        <span class="text-xs font-semibold uppercase tracking-wider text-amber-600">{{ $cat?->name }}</span>

        <a href="{{ route('product.show', $product) }}">
            <h3 class="mt-1 text-lg font-bold text-slate-900 hover:text-amber-600">{{ $product->name }}</h3>
        </a>

        <p class="mt-1 line-clamp-2 text-sm text-slate-500">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>

        <div class="mt-auto flex items-center justify-between pt-5">
            <span class="text-lg font-extrabold text-slate-900">Rs {{ number_format($product->price) }}</span>

            <form method="POST" action="{{ route('cart.add', $product) }}">
                @csrf
                <button type="submit"
                        class="rounded-full bg-amber-400 px-5 py-2 text-sm font-bold text-slate-900 shadow transition hover:bg-amber-500 active:scale-95">
                    Add to cart
                </button>
            </form>
        </div>
    </div>
</article>
        @empty
            <p class="col-span-full py-16 text-center text-slate-500">there is no product will be find in this filter .</p>
        @endforelse
    </div>

</section>
</div>
<script>
document.addEventListener('click', function (e) {
    const link = e.target.closest('a[data-shop-link]');
    if (!link) return;
    e.preventDefault();
    loadShop(link.href);
});

document.addEventListener('submit', function (e) {
    const form = e.target.closest('form[data-shop-form]');
    if (!form) return;
    e.preventDefault();

    const params = new URLSearchParams(new FormData(form));
    for (const [key, value] of [...params]) {
        if (!value) params.delete(key);
    }

    loadShop(form.action + '?' + params.toString());
});

async function loadShop(url) {
    const wrapper = document.getElementById('shop-wrapper');
    wrapper.style.opacity = '0.5';

    const res = await fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });

    const html = await res.text();
    const doc = new DOMParser().parseFromString(html, 'text/html');
    wrapper.innerHTML = doc.getElementById('shop-wrapper').innerHTML;

    wrapper.style.opacity = '1';
    history.pushState({}, '', url);
}
</script>
