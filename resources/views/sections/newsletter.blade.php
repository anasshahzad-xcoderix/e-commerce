

<section class="news" id="newsletter">
    <div class="wrap">
        <div class="news-card">

            <div class="news-text">
                <h2>Get 10% off your first order</h2>
                <p>One email each Friday with new makers and restocks. Unsubscribe any time.</p>
            </div>

            <div class="news-right" id="newsRight">
                <form class="news-form" id="newsForm" novalidate>
                    <input type="email" id="newsEmail" placeholder="you@example.com" aria-label="Email address">
                    <button type="submit">Send my code</button>
                </form>
                <p class="news-msg" id="newsMsg"></p>
                <p class="news-done">🎉 Thank you! Your 10% discount code has been sent to your email.</p>
            </div>

        </div>
    </div>
</section>

<script>
(function () {
    const form = document.getElementById('newsForm');
    const input = document.getElementById('newsEmail');
    const msg = document.getElementById('newsMsg');
    const box = document.getElementById('newsRight');
    const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const email = input.value.trim();

        if (!valid.test(email)) {
            input.classList.add('error');
            msg.textContent = 'Please enter a valid email address.';
            return;
        }
        input.classList.remove('error');
        msg.textContent = '';
        box.classList.add('sent');
    });

    input.addEventListener('input', function () {
        input.classList.remove('error');
        msg.textContent = '';
    });
})();
</script>