import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('.nav-toggle');
    const nav = document.querySelector('.site-nav');

    if (toggle && nav) {
        toggle.addEventListener('click', () => {
            const terbuka = nav.classList.toggle('open');
            toggle.setAttribute('aria-expanded', String(terbuka));
        });
    }

    document.querySelectorAll('canvas[data-stars]').forEach((stars) => {
        const ctx = stars.getContext('2d');

        const drawStars = () => {
            const rect = stars.getBoundingClientRect();
            const dpr = window.devicePixelRatio || 1;

            stars.width = Math.max(1, Math.floor(rect.width * dpr));
            stars.height = Math.max(1, Math.floor(rect.height * dpr));
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
            ctx.clearRect(0, 0, rect.width, rect.height);

            const jumlah = Math.min(160, Math.floor((rect.width * rect.height) / 1200));
            const langit = parseFloat(stars.dataset.starsSky || '1');

            for (let i = 0; i < jumlah; i++) {
                const x = Math.random() * rect.width;
                const y = Math.random() * rect.height * langit;
                const r = Math.random() * 1.3 + 0.3;
                const a = Math.random() * 0.55 + 0.25;

                if (Math.random() < 0.08) {
                    ctx.strokeStyle = `rgba(255,255,255,${a * 0.5})`;
                    ctx.lineWidth = 0.6;
                    ctx.beginPath();
                    ctx.moveTo(x - r * 3, y);
                    ctx.lineTo(x + r * 3, y);
                    ctx.stroke();
                    ctx.beginPath();
                    ctx.moveTo(x, y - r * 3);
                    ctx.lineTo(x, y + r * 3);
                    ctx.stroke();
                }

                ctx.beginPath();
                ctx.arc(x, y, r, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(255,255,255,${a})`;
                ctx.fill();
            }
        };

        drawStars();

        let raf = null;
        window.addEventListener('resize', () => {
            cancelAnimationFrame(raf);
            raf = requestAnimationFrame(drawStars);
        });
    });
});
