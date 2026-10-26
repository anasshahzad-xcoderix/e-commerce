@php
    $benefits = [
        [
            'title' => 'One checkout, many makers',
            'text'  => 'Buy from a dozen makers in a single order. We combine shipments so you pay delivery once and get one tracking link.',
            'bg'    => '#f5b73b',
            'fg'    => '#14233b',
            'icon'  => '<rect x="2" y="7" width="13" height="9" rx="2"/><path d="M15 10h4l3 3v3h-7z"/><circle cx="7" cy="18" r="2"/><circle cx="18" cy="18" r="2"/>',
        ],
        [
            'title' => 'Easy returns, no paperwork',
            'text'  => 'Print a prepaid label from your order page. Refunds reach your card within two business days of the parcel scan.',
            'bg'    => '#1f7a6d',
            'fg'    => '#ffffff',
            'icon'  => '<path d="M20 11a8 8 0 0 0-14-4L4 9"/><path d="M4 4v5h5"/><path d="M4 13a8 8 0 0 0 14 4l2-2"/><path d="M20 20v-5h-5"/>',
        ],
        [
            'title' => 'Protected from click to doorstep',
            'text'  => 'If a piece arrives chipped or never arrives, we replace it or refund you. No photos of the box needed for orders under $150.',
            'bg'    => '#5a2a4e',
            'fg'    => '#ffffff',
            'icon'  => '<path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/><path d="M8.5 12l2.5 2.5 4.5-5"/>',
        ],
    ];
@endphp


<section class="benefits" id="benefits">
    <div class="wrap">
        <h2>Shopping online should feel as good as unwrapping the box</h2>

        <div class="benefit-grid">
            @foreach ($benefits as $b)
                <article class="benefit">
                    <div class="benefit-icon" style="background: {{ $b['bg'] }}; color: {{ $b['fg'] }}">
                        <svg viewBox="0 0 24 24">{!! $b['icon'] !!}</svg>
                    </div>
                    <h3>{{ $b['title'] }}</h3>
                    <p>{{ $b['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>