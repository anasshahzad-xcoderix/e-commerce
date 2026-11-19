<section class="best-sellers" aria-labelledby="best-sellers-title">
    <div class="wrap">
        <div class="best-sellers-heading">
            <p class="best-sellers-eyebrow">CUSTOMER FAVORITES</p>
            <h2 id="best-sellers-title">Best Products</h2>
        </div>

        <div class="best-sellers-grid">
            @for ($slot = 1; $slot <= 4; $slot++)
                <article class="best-seller-card">
                    @if ($slot === 1)
                        <img
                            class="best-seller-image-slot"
                            src="{{ asset('images/best-seller-rug.jpg') }}"
                            alt="Flower-shaped rug in a cozy living room"
                        >
                    @elseif ($slot === 2)
                        <img
                            class="best-seller-image-slot"
                            src="{{ asset('images/best-seller-bar-stool.jpg') }}"
                            alt="White bar stool in a modern interior"
                        >

                      @elseif ($slot === 3)

                      <img 
                      class="best-seller-image-slot"
                      src="{{ asset('images/best-seller.jpg') }}"
                      alt="artificial plants">

                @elseif ($slot === 4)
                <img 
                class="best-seller-image-slot"
                src="{{ asset('images/rugs.jpg') }}"
                alt="rugs">



                    @else
                        <div
                            class="best-seller-image-slot"
                            role="img"
                            aria-label="Space reserved for best seller image {{ $slot }}"
                        ></div>
                    @endif
                </article>
            @endfor
        </div>
    </div>
</section>
