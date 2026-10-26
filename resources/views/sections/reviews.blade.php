@php
    $reviews = [
        ['rating' => 5, 'name' => 'Hannah R.',  'text' => 'The mugs arrived wrapped in paper, not plastic, and not a single one was chipped. They feel even better than the photos.'],
        ['rating' => 5, 'name' => 'David K.',   'text' => 'I swapped my rug for a different size and the return label was in my inbox within a minute. Completely painless.'],
        ['rating' => 4, 'name' => 'Sofia M.',  'text' => 'The lamp is stunning. Delivery took four days instead of three, but the tracking updates were honest.'],
    ];
@endphp



<section class="reviews" id="reviews">
    <div class="wrap">
        <h2>What customers say after the box is open</h2>

        <div class="review-grid">
            @foreach ($reviews as $r)
                <article class="review">
                    <div class="stars" aria-label="{{ $r['rating'] }} out of 5 stars">
                        @for ($i = 1; $i <= 5; $i++)
                            {{ $i <= $r['rating'] ? '★' : '☆' }}
                        @endfor
                    </div>
                    <blockquote>{{ $r['text'] }}</blockquote>
                    <p class="review-by">{{ $r['name'] }} · Verified buyer</p>
                </article>
            @endforeach
        </div>
    </div>
</section>