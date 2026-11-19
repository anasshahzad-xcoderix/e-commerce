<section class="best-sellers" aria-labelledby="best-sellers-title">
    <div class="wrap">
        <div class="best-sellers-heading">
            <p class="best-sellers-eyebrow">CUSTOMER FAVORITES</p>
            <h2 id="best-sellers-title">Best Sellers</h2>
        </div>

        <div class="best-sellers-grid">
            @for ($slot = 1; $slot <= 4; $slot++)
                <article class="best-seller-card">
                    <div
                        class="best-seller-image-slot"
                        role="img"
                        aria-label="Space reserved for best seller image {{ $slot }}"
                    ></div>
                </article>
            @endfor
        </div>
    </div>
</section>
