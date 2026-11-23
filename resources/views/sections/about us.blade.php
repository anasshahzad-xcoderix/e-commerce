<main class="about-page">
    <section class="about-hero" aria-labelledby="about-title">
        <div class="wrap about-hero-grid">
            <div class="about-hero-copy">
                <p class="about-eyebrow">ABOUT YOUSAF STORE</p>
                <h1 id="about-title">Good spaces start with thoughtful pieces.</h1>
                <p class="about-intro">
                    We bring home decor and furniture together in one place, so you can discover pieces that feel right for your space and the people behind them.
                </p>
                <div class="about-actions">
                    <a class="about-button about-button-primary" href="{{ route('shop') }}">Explore the shop</a>
                    <a class="about-button about-button-secondary" href="{{ route('makers') }}">Meet our makers</a>
                </div>
            </div>

            <figure class="about-hero-image">
                <img
                    src="{{ asset('images/home-shopping-story.jpg') }}"
                    alt="Customers exploring handcrafted furniture and home decor"
                >
            </figure>
        </div>
    </section>

    <section class="about-values" aria-labelledby="about-values-title">
        <div class="wrap">
            <div class="about-values-heading">
                <p class="about-eyebrow">WHAT MATTERS TO US</p>
                <h2 id="about-values-title">A more thoughtful way to shop for home.</h2>
                <p>From the first browse to the finishing touches, we want discovering something for your home to feel simple and personal.</p>
            </div>

            <div class="about-value-grid">
                <article class="about-value-card">
                    <span class="about-value-number">01</span>
                    <h3>Pieces with character</h3>
                    <p>Explore furniture and decor chosen to bring warmth, function, and personality to your space.</p>
                </article>
                <article class="about-value-card">
                    <span class="about-value-number">02</span>
                    <h3>People behind the work</h3>
                    <p>Discover independent makers and learn more about the care and craft behind what they create.</p>
                </article>
                <article class="about-value-card">
                    <span class="about-value-number">03</span>
                    <h3>Shopping made clear</h3>
                    <p>Browse by category, compare product details, and get support when you need a hand.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="about-cta" aria-labelledby="about-cta-title">
        <div class="wrap about-cta-content">
            <div>
                <p class="about-eyebrow">MAKE YOURSELF AT HOME</p>
                <h2 id="about-cta-title">Your next favorite piece is waiting.</h2>
            </div>
            <a class="about-button about-button-light" href="{{ route('shop') }}">Browse the collection</a>
        </div>
    </section>
</main>