// (function () {
//     const grid = document.getElementById('shopGrid');
//     if (!grid) return;

//     const search = document.getElementById('shopSearch');
//     const sort = document.getElementById('shopSort');
//     const pills = document.querySelectorAll('#shopFilters .pill');
//     const count = document.getElementById('visibleCount');
//     const badge = document.querySelector('.cart-count');
// const cards = Array.from(grid.querySelectorAll('.yp-card'));    
// let activeCat = 'all';

//     function applyFilters() {
//         const q = (search.value || '').toLowerCase().trim();
//         let shown = 0;
//         cards.forEach(function (card) {
//             const matchCat = activeCat === 'all' || card.dataset.cat === activeCat;
//             const matchName = card.dataset.name.includes(q);
//             const ok = matchCat && matchName;
//             card.style.display = ok ? '' : 'none';
//             if (ok) shown++;
//         });
//         count.textContent = shown;
//     }

//     function sortCards() {
//         const v = sort.value;
//         const sorted = cards.slice();
//         if (v === 'low') sorted.sort((a, b) => a.dataset.price - b.dataset.price);
//         if (v === 'high') sorted.sort((a, b) => b.dataset.price - a.dataset.price);
//         sorted.forEach(function (card) { grid.appendChild(card); });
//     }

//     pills.forEach(function (pill) {
//         pill.addEventListener('click', function () {
//             pills.forEach(function (p) { p.classList.remove('active'); });
//             pill.classList.add('active');
//             activeCat = pill.dataset.cat;
//             applyFilters();
//         });
//     });

//     search.addEventListener('input', applyFilters);
//     sort.addEventListener('change', function () {
//         sortCards();
//         applyFilters();
//     });

//     grid.addEventListener('click', function (e) {
//         if (e.target.classList.contains('add-btn') && badge) {
//             badge.textContent = (parseInt(badge.textContent, 10) || 0) + 1;
//         }
//     });
// })();