@php
    $product = 'Glow table lamp';
    $oldPrice = 120;
    $discount = 30;
    $newPrice = $oldPrice - ($oldPrice * $discount / 100);
@endphp



<section class="sale" id="sale">
    <div class="wrap">
        <div class="sale-card">

            <div class="sale-text">
                <h2>Today only: {{ $discount }}% off the {{ $product }}</h2>
                <p>Hand-blown glass shade, oak base and a warm dimmable bulb included. When the clock runs out, the price goes back up.</p>

                <div class="timer">
                    <div class="tbox"><strong id="sHours">00</strong><span>Hours</span></div>
                    <div class="tbox"><strong id="sMins">00</strong><span>Minutes</span></div>
                    <div class="tbox"><strong id="sSecs">00</strong><span>Seconds</span></div>
                </div>

                <div class="sale-buy">
                    <span class="new-price">Rs {{ number_format($newPrice) }}</span>
                    <span class="old-price">Rs {{ number_format($oldPrice) }}</span>
                    <button class="sale-btn" id="saleBtn">Add lamp to cart</button>
                </div>
            </div>

            <div class="sale-art">
                <img
                    src="{{ asset('images/daily-sale-lamp.jpg') }}"
                    alt="Modern black floor lamp beside a cozy armchair"
                >
            </div>

        </div>
    </div>
</section>

<script>
(function () {
    const h = document.getElementById('sHours');
    const m = document.getElementById('sMins');
    const s = document.getElementById('sSecs');
    const pad = n => String(n).padStart(2, '0');

    function tick() {
        const now = new Date();
        const end = new Date(now);
        end.setHours(24, 0, 0, 0);             
        const diff = Math.floor((end - now) / 1000);

        h.textContent = pad(Math.floor(diff / 3600));
        m.textContent = pad(Math.floor((diff % 3600) / 60));
        s.textContent = pad(diff % 60);
    }
    tick();
    setInterval(tick, 1000);

    document.getElementById('saleBtn').addEventListener('click', () => {
        const badge = document.querySelector('.cart-count');
        if (badge) badge.textContent = (parseInt(badge.textContent) || 0) + 1;
    });
})();
</script>