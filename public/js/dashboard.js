const sidebar = document.getElementById('sidebar');
document.getElementById('menuBtn').addEventListener('click', () => sidebar.classList.toggle('open'));
document.querySelectorAll('.s-nav a').forEach(a => {
    a.addEventListener('click', () => sidebar.classList.remove('open'));
});

function countUp(el) {
    const end = parseFloat(el.dataset.count);
    const dec = parseInt(el.dataset.dec || '0', 10);
    const dur = 1400;
    const start = performance.now();
    function tick(now) {
        const p = Math.min((now - start) / dur, 1);
        const eased = 1 - Math.pow(1 - p, 3);
        el.textContent = (end * eased).toLocaleString('en-US', {
            minimumFractionDigits: dec,
            maximumFractionDigits: dec
        });
        if (p < 1) requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
}

document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        document.querySelectorAll('.seg').forEach(s => {
            s.style.strokeDasharray = `${s.dataset.len} ${100 - s.dataset.len}`;
        });
        document.querySelectorAll('.fill').forEach(f => {
            f.style.width = f.dataset.w + '%';
        });
        document.querySelectorAll('[data-count]').forEach(countUp);
    }, 300);
});