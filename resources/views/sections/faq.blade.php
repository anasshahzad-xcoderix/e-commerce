@php
    $faqs = [
        ['q' => 'How long does delivery take?',        'a' => 'Most orders arrive within three working days. Large furniture can take up to seven days because it ships directly from the maker.'],
        ['q' => 'Can I return a handmade item?',       'a' => 'Yes. You have 30 days to return any item in its original packaging. Print a prepaid label from your order page and we refund you within two business days of the parcel scan.'],
        ['q' => 'Which payment methods do you accept?', 'a' => 'We accept all major debit and credit cards, bank transfer and cash on delivery in selected cities.'],
        ['q' => 'Do you ship internationally?',        'a' => 'Not yet. We currently deliver within Pakistan, and we are working on adding more countries soon.'],
        ['q' => 'How do I sell on Yousaf Store?',      'a' => 'Apply from the Makers page with a few photos of your work. Our team reviews every application within five working days.'],
    ];
@endphp
<section class="faq" id="faq">
    <div class="wrap">
        <div class="faq-box">
            <h2>Questions before you buy</h2>

            <div class="faq-list">
                @foreach ($faqs as $f)
                    <div class="faq-item">
                        <button class="faq-q" aria-expanded="false">
                            <span>{{ $f['q'] }}</span>
                            <span class="faq-icon">+</span>
                        </button>
                        <div class="faq-a">
                            <p>{{ $f['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    const items = document.querySelectorAll('.faq-item');

    items.forEach(item => {
        const btn = item.querySelector('.faq-q');
        const answer = item.querySelector('.faq-a');

        btn.addEventListener('click', () => {
            const isOpen = item.classList.contains('open');

            // Baqi sab band karo (ek waqt mein ek hi khula rahe)
            items.forEach(i => {
                i.classList.remove('open');
                i.querySelector('.faq-a').style.maxHeight = null;
                i.querySelector('.faq-q').setAttribute('aria-expanded', 'false');
            });

            // Agar ye band tha to kholo
            if (!isOpen) {
                item.classList.add('open');
                answer.style.maxHeight = answer.scrollHeight + 'px';
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });
})();
</script>