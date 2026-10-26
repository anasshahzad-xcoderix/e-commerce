@php
    $columns = [
        'Shop'    => ['New arrivals', 'Categories', 'Daily sale', 'Gift cards'],
        'Support' => ['Delivery', 'Returns', 'Payments', 'Contact us'],
        'Company' => ['Our makers', 'Sell with us', 'Sustainability', 'Careers'],
    ];
    $payments = ['Visa', 'Mastercard', 'Amex', 'PayPal', 'Apple Pay'];
@endphp

<style>
    .site-footer { background: #13284a; color: #c8d3e6; padding: 56px 0 28px; }
    .footer-top { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 40px; }
    .footer-brand .f-logo { color: #fff; font-weight: 800; font-size: 24px; letter-spacing: -0.5px; text-decoration: none; }
    .footer-brand p { margin-top: 18px; font-size: 15px; line-height: 1.7; max-width: 360px; }

    .footer-col h4 { color: #fff; font-size: 15px; font-weight: 700; margin-bottom: 20px; }
    .footer-col ul { list-style: none; }
    .footer-col li { margin-bottom: 12px; }
    .footer-col a { color: #c8d3e6; text-decoration: none; font-size: 15px; transition: 0.2s; }
    .footer-col a:hover { color: #ffc928; }

    .footer-bottom {
        margin-top: 44px; padding-top: 24px; border-top: 1px solid rgba(255, 255, 255, 0.1);
        display: flex; justify-content: space-between; align-items: center;
        gap: 12px 24px; flex-wrap: wrap; font-size: 14px;
    }
    .pay-list { display: flex; flex-wrap: wrap; gap: 4px 6px; }
    .pay-list span:not(:last-child)::after { content: "·"; margin-left: 6px; }

    @media (max-width: 900px) {
        .footer-top { grid-template-columns: 1fr 1fr 1fr; }
        .footer-brand { grid-column: 1 / -1; }
    }
    @media (max-width: 560px) {
        .site-footer { padding: 40px 0 24px; }
        .footer-top { grid-template-columns: 1fr 1fr; gap: 32px 20px; }
        .footer-bottom { flex-direction: column; align-items: flex-start; }
    }
</style>

<footer class="site-footer">
    <div class="wrap">

        <div class="footer-top">
            <div class="footer-brand">
                <a href="/" class="f-logo">Yousaf Store</a>
                <p>An independent marketplace for handmade home goods. Fairly priced, carefully packed, made by people you can name.</p>
            </div>

            @foreach ($columns as $title => $links)
                <div class="footer-col">
                    <h4>{{ $title }}</h4>
                    <ul>
                        @foreach ($links as $link)
                            <li><a href="#">{{ $link }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <div class="footer-bottom">
            <span>© {{ date('Y') }} Yousaf Store. All rights reserved.</span>
            <div class="pay-list">
                @foreach ($payments as $p)
                    <span>{{ $p }}</span>
                @endforeach
            </div>
        </div>

    </div>
</footer>