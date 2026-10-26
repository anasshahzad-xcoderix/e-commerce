<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics | Yousaf Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
   <style>
           <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</style>
</head>
<body>

<div class="layout">

    <aside class="sidebar" id="sidebar">
        <div class="s-logo">YOUSAF <span>STORE</span></div>

       <nav class="s-nav">
    <a href="#overview" class="nav-link active">Overview</a>
    <a href="{{ route('shop') }}" class="nav-link">Shop</a>
    <a href="{{ route('categories') }}" class="nav-link">Categories</a>
    <a href="{{ route('daily-sale') }}" class="nav-link">Daily sale</a>
    <a href="{{ route('makers') }}" class="nav-link">Makers</a>
    <a href="{{ route('help') }}" class="nav-link">Help</a>
    <a href="#products" class="nav-link">Products</a>
    <a href="#regions" class="nav-link">Regions</a>
    <a href="{{ url('/') }}" class="nav-link">← Back to store</a>
</nav>

        @auth
            <div class="s-user">
                <p>Hello,<b>{{ Auth::user()->name }}</b></p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        @endauth
    </aside>

    <div class="content" id="overview">

        <header class="top">
            <button class="menu-btn" id="menuBtn" aria-label="Menu">☰</button>
            <div>
                <h1>Sales &amp; customer insights</h1>
                <p>Q3 2026</p>
            </div>
        </header>

        <section class="kpis">
            <div class="kpi">
                <small>Total orders</small>
                <strong data-count="12480" data-dec="0">0</strong><span class="chip up">+12%</span>
            </div>
            <div class="kpi">
                <small>Revenue</small>
                <strong>$<span data-count="84210" data-dec="0">0</span></strong><span class="chip up">+9%</span>
            </div>
            <div class="kpi">
                <small>Avg. order</small>
                <strong>$<span data-count="68.4" data-dec="2">0</span></strong><span class="chip up">+4%</span>
            </div>
            <div class="kpi">
                <small>Return rate</small>
                <strong><span data-count="2.8" data-dec="1">0</span>%</strong><span class="chip down">+0.6%</span>
            </div>
        </section>

        <main class="grid">

            <section class="card">
                <h2>Customer score (NPS)</h2>
                <p class="sub">Q3 survey feedback, all regions</p>
                <svg viewBox="0 0 200 200" width="220" height="220" style="display:block; margin:0 auto;">
                    <g transform="rotate(-90 100 100)">
                        <circle cx="100" cy="100" r="70" fill="none" stroke="#1b2545" stroke-width="22"/>
                        <circle class="seg" data-len="54" pathLength="100" cx="100" cy="100" r="70" fill="none"
                                stroke="#2ee6c4ef" stroke-width="22" stroke-dashoffset="0"/>
                        <circle class="seg" data-len="32" pathLength="100" cx="100" cy="100" r="70" fill="none"
                                stroke="#ffb020" stroke-width="22" stroke-dashoffset="-54"/>
                        <circle class="seg" data-len="14" pathLength="100" cx="100" cy="100" r="70" fill="none"
                                stroke="#ff4d7d" stroke-width="22" stroke-dashoffset="-86"/>
                    </g>
                    <text x="100" y="90" text-anchor="middle" fill="#8b97b8" font-size="10" letter-spacing="2">GLOBAL INDEX</text>
                    <text x="100" y="120" text-anchor="middle" fill="#fff" font-size="32" font-weight="800">+48</text>
                    <text x="100" y="140" text-anchor="middle" fill="#2ee6c5" font-size="10" font-weight="700">EXCELLENT</text>
                </svg>
                <div class="legend">
                    <div><span class="dot" style="background:#2ee6c5"></span>Promoters<b>54%</b></div>
                    <div><span class="dot" style="background:#ffb020"></span>Passives<b>32%</b></div>
                    <div><span class="dot" style="background:#ff4d7d"></span>Detractors<b>14%</b></div>
                </div>
            </section>

            <section class="card">
                <h2>Monthly revenue (2026)</h2>
                <p class="sub">Revenue in $ thousands, Jan to Sep</p>
                <svg viewBox="0 0 500 230" width="100%" style="overflow:visible;">
                    <defs>
                        <linearGradient id="g1" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#2ee6c5" stop-opacity=".35"/>
                            <stop offset="100%" stop-color="#2ee6c5" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                    <g stroke="#1f2b4d" stroke-width="1">
                        <line x1="0" y1="40" x2="500" y2="40"/>
                        <line x1="0" y1="100" x2="500" y2="100"/>
                        <line x1="0" y1="160" x2="500" y2="160"/>
                        <line x1="0" y1="200" x2="500" y2="200"/>
                    </g>
                    <polygon class="area" fill="url(#g1)" points="0,193 60,178 120,182 180,157 240,135 300,124 360,114 420,92 480,63 480,200 0,200"/>
                    <polyline class="line" pathLength="1" fill="none" stroke="#2ee6c5" stroke-width="3" stroke-linejoin="round"
                              points="0,193 60,178 120,182 180,157 240,135 300,124 360,114 420,92 480,63"/>
                    <g fill="#2ee6c5">
                        <circle class="dot-pt" style="animation-delay:1.6s" cx="420" cy="92" r="5"/>
                        <circle class="dot-pt" style="animation-delay:1.8s" cx="480" cy="63" r="6"/>
                    </g>
                    <text class="dot-pt" style="animation-delay:1.8s" x="478" y="52" text-anchor="end" fill="#fff" font-size="13" font-weight="700">$78k</text>
                    <g fill="#8b97b8" font-size="11">
                        <text x="0" y="222">Jan</text><text x="60" y="222">Feb</text><text x="120" y="222">Mar</text>
                        <text x="180" y="222">Apr</text><text x="240" y="222">May</text><text x="300" y="222">Jun</text>
                        <text x="360" y="222">Jul</text><text x="420" y="222">Aug</text><text x="470" y="222">Sep</text>
                    </g>
                </svg>
            </section>

            <section class="card">
                <h2>What customers care about</h2>
                <p class="sub">Satisfaction score and impact</p>

                <div class="drv">
                    <div class="drv-top"><span>Delivery speed</span><em class="tag hi">HIGH IMPACT</em></div>
                    <div class="bar"><div class="track"><div class="fill" data-w="88"></div></div><b>88%</b></div>
                </div>
                <div class="drv">
                    <div class="drv-top"><span>Packaging quality</span><em class="tag hi">HIGH IMPACT</em></div>
                    <div class="bar"><div class="track"><div class="fill" data-w="82"></div></div><b>82%</b></div>
                </div>
                <div class="drv">
                    <div class="drv-top"><span>Product photos vs reality</span><em class="tag hi">HIGH IMPACT</em></div>
                    <div class="bar"><div class="track"><div class="fill" data-w="61"></div></div><b>61%</b></div>
                </div>
                <div class="drv">
                    <div class="drv-top"><span>Return process</span><em class="tag md">MED IMPACT</em></div>
                    <div class="bar"><div class="track"><div class="fill" data-w="68"></div></div><b>68%</b></div>
                </div>
                <div class="drv">
                    <div class="drv-top"><span>Maker story &amp; trust</span><em class="tag lo">LOW IMPACT</em></div>
                    <div class="bar"><div class="track"><div class="fill" data-w="79"></div></div><b>79%</b></div>
                </div>
            </section>

            <section class="card span2" id="products">
                <h2>Top products (Q3 2026)</h2>
                <p class="sub">Units sold, customer sentiment and trend vs Q2</p>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Units</th>
                                <th>Sentiment</th>
                                <th>Trend</th>
                                <th class="hide-m">Customer quote</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>Clay mug</b></td>
                                <td>1,420</td>
                                <td><span class="pill" style="color:#2ee6c5;border-color:#2ee6c5">88% positive</span></td>
                                <td style="color:#2ee6c5">+4.2% ↗</td>
                                <td class="quote hide-m">"Feels solid in the hand and looks lovely on the shelf."</td>
                            </tr>
                            <tr>
                                <td><b>Glow lamp</b></td>
                                <td>980</td>
                                <td><span class="pill" style="color:#ffb020;border-color:#ffb020">62% positive</span></td>
                                <td style="color:#ff4d7d">-2.1% ↘</td>
                                <td class="quote hide-m">"Light is warm, but the cord is shorter than I expected."</td>
                            </tr>
                            <tr>
                                <td><b>Woven rug</b></td>
                                <td>850</td>
                                <td><span class="pill" style="color:#2ee6c5;border-color:#2ee6c5">79% positive</span></td>
                                <td style="color:#2ee6c5">+8.0% ↗</td>
                                <td class="quote hide-m">"Colours are exactly as shown. Very soft underfoot."</td>
                            </tr>
                            <tr>
                                <td><b>Oak stool</b></td>
                                <td>620</td>
                                <td><span class="pill" style="color:#ffb020;border-color:#ffb020">54% positive</span></td>
                                <td style="color:#2ee6c5">+0.5% ↗</td>
                                <td class="quote hide-m">"Sturdy, but the finish needed a second coat for me."</td>
                            </tr>
                            <tr>
                                <td><b>Plant pot</b></td>
                                <td>450</td>
                                <td><span class="pill" style="color:#2ee6c5;border-color:#2ee6c5">85% positive</span></td>
                                <td style="color:#2ee6c5">+12.3% ↗</td>
                                <td class="quote hide-m">"Drainage hole fits perfectly. My basil loves it."</td>
                            </tr>
                            <tr>
                                <td><b>Linen throw</b></td>
                                <td>310</td>
                                <td><span class="pill" style="color:#ff4d7d;border-color:#ff4d7d">30% positive</span></td>
                                <td style="color:#ff4d7d">-1.5% ↘</td>
                                <td class="quote hide-m">"Delivery took longer than the three days promised."</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="card" id="regions">
                <h2>Regional performance</h2>
                <p class="sub">Orders and satisfaction by region</p>
                <div class="regions">
                    <div class="region">
                        <header>NORTH <span>4.2k orders</span></header>
                        <div class="nums">
                            <div><b style="color:#2ee6c5">+52</b><small>NPS SCORE</small></div>
                            <div><b>84.2%</b><small>CSAT</small></div>
                        </div>
                        <div class="track"><div class="fill" data-w="84"></div></div>
                    </div>
                    <div class="region">
                        <header>WEST <span>3.9k orders</span></header>
                        <div class="nums">
                            <div><b style="color:#2ee6c5">+49</b><small>NPS SCORE</small></div>
                            <div><b>81.5%</b><small>CSAT</small></div>
                        </div>
                        <div class="track"><div class="fill" data-w="81"></div></div>
                    </div>
                    <div class="region">
                        <header>EAST <span>2.7k orders</span></header>
                        <div class="nums">
                            <div><b style="color:#ffb020">+43</b><small>NPS SCORE</small></div>
                            <div><b>79.8%</b><small>CSAT</small></div>
                        </div>
                        <div class="track"><div class="fill" data-w="80"></div></div>
                    </div>
                    <div class="region">
                        <header>SOUTH <span>1.8k orders</span></header>
                        <div class="nums">
                            <div><b style="color:#ff4d7d">+38</b><small>NPS SCORE</small></div>
                            <div><b>76.4%</b><small>CSAT</small></div>
                        </div>
                        <div class="track"><div class="fill" data-w="76"></div></div>
                    </div>
                </div>
            </section>

        </main>

        <footer class="foot">
            <span>Data source: Yousaf Store orders and customer reviews, Jul to Sep 2026</span>
            <span>Generated on: 30 Sep 2026</span>
        </footer>

    </div>
</div>

<script src="{{ asset('js/dashboard.js') }}"></script>

</body>
</html>