@php
    $makers = [
        ['init' => 'MA', 'name' => 'Mira Okafor, Salt Kiln',    'text' => 'Wheel-thrown stoneware fired in a wood kiln outside Multan. Makes 40 mugs a week.',                 'bg' => '#ffc928', 'fg' => '#14233b'],
        ['init' => 'TH', 'name' => 'Tomas Hale, Hale Woodwork', 'text' => 'Third-generation joiner building oak stools and lamp bases from reclaimed barn beams.',            'bg' => '#1f7a6d', 'fg' => '#ffffff'],
        ['init' => 'PR', 'name' => 'Priya Raman, Loomhouse',      'text' => 'Hand-loomed cotton throws and rugs, dyed with madder root and indigo in small lots.',               'bg' => '#7a2f64', 'fg' => '#ffffff'],
        ['init' => 'JL', 'name' => 'Jun Lee,  Green Room',    'text' => 'Grows and pots low-light houseplants in recycled planters, ready to display.',                      'bg' => '#ffffff', 'fg' => '#14233b'],
    ];
@endphp
<section class="makers" id="makers">
    <div class="wrap makers-grid">

        <div class="makers-text">
            <h2>Every product has a name behind it</h2>
            <p>We pay makers within 7 days of delivery and keep our commission at 12%, well below the marketplace average. That's why prices here stay fair.</p>
            <a href="#" class="makers-btn">Browse by studio</a>
        </div>

        <div class="maker-cards">
            @foreach ($makers as $m)
                <article class="maker">
                    <div class="avatar" style="background: {{ $m['bg'] }}; color: {{ $m['fg'] }}">{{ $m['init'] }}</div>
                    <h3>{{ $m['name'] }}</h3>
                    <p>{{ $m['text'] }}</p>
                </article>
            @endforeach
        </div>

    </div>
</section>