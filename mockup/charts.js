/*
 * Grafik SVG kecil untuk mockup dashboard Weba ERP.
 * Warna dikirim sebagai nilai CSS (misalnya 'var(--bar)') supaya tiap desain memakai tokennya sendiri.
 */
(function () {
    const NS = 'http://www.w3.org/2000/svg';

    function el(name, attrs = {}, parent = null) {
        const node = document.createElementNS(NS, name);
        Object.entries(attrs).forEach(([k, v]) => node.setAttribute(k, v));
        if (parent) {
            parent.appendChild(node);
        }
        return node;
    }

    /* ---------- tooltip ---------- */
    let tip = null;

    function ensureTip() {
        if (tip) {
            return tip;
        }
        const style = document.createElement('style');
        style.textContent = `
            .wc-tip { position: fixed; z-index: 1000; pointer-events: none; max-width: 280px;
                padding: 8px 10px; border-radius: 8px; font: 500 12.5px/1.45 var(--font-body, system-ui, sans-serif);
                background: var(--tip-bg, #0b1a33); color: var(--tip-fg, #f3f7ff);
                box-shadow: 0 8px 24px rgba(5, 20, 50, .28); opacity: 0; transform: translateY(4px);
                transition: opacity .12s, transform .12s; }
            .wc-tip.on { opacity: 1; transform: none; }
            .wc-tip b { font-weight: 650; }
            .wc-tip .k { opacity: .72; }
            .wc-hit { cursor: default; }
            .wc-hit:focus { outline: none; }
            .wc-hit:focus-visible { outline: 2px solid var(--focus, #2a78d6); outline-offset: 2px; }
        `;
        document.head.appendChild(style);
        tip = document.createElement('div');
        tip.className = 'wc-tip';
        tip.setAttribute('role', 'tooltip');
        document.body.appendChild(tip);
        return tip;
    }

    function place(x, y) {
        const t = ensureTip();
        const pad = 14;
        const w = t.offsetWidth;
        const h = t.offsetHeight;
        let left = x + pad;
        let top = y + pad;
        if (left + w > window.innerWidth - 8) {
            left = x - w - pad;
        }
        if (top + h > window.innerHeight - 8) {
            top = y - h - pad;
        }
        t.style.left = left + 'px';
        t.style.top = top + 'px';
    }

    function bindTip(node, html) {
        node.classList.add('wc-hit');
        node.setAttribute('tabindex', '0');
        const show = (x, y) => {
            const t = ensureTip();
            t.innerHTML = html;
            t.classList.add('on');
            place(x, y);
        };
        const hide = () => ensureTip().classList.remove('on');
        node.addEventListener('mouseenter', (e) => show(e.clientX, e.clientY));
        node.addEventListener('mousemove', (e) => place(e.clientX, e.clientY));
        node.addEventListener('mouseleave', hide);
        node.addEventListener('focus', () => {
            const r = node.getBoundingClientRect();
            show(r.right, r.top);
        });
        node.addEventListener('blur', hide);
    }

    /* Batang dengan ujung data membulat 4px dan pangkal persegi. */
    function barPath(x, y, w, h, r = 4) {
        if (w <= 0) {
            return '';
        }
        const rr = Math.min(r, w, h / 2);
        return `M${x},${y} h${w - rr} a${rr},${rr} 0 0 1 ${rr},${rr} v${h - 2 * rr} a${rr},${rr} 0 0 1 ${-rr},${rr} h${-(w - rr)} z`;
    }

    function width(container) {
        return Math.max(container.clientWidth, 120);
    }

    function onResize(container, draw) {
        draw();
        let raf = null;
        new ResizeObserver(() => {
            cancelAnimationFrame(raf);
            raf = requestAnimationFrame(draw);
        }).observe(container);
    }

    /* ---------- batang horizontal (satu seri) ---------- */
    function hbar(container, items, opts = {}) {
        const o = {
            row: 34, thickness: 14, labelWidth: 120, valueWidth: 64,
            color: 'var(--bar, #2a78d6)', track: 'var(--track, transparent)',
            ink: 'var(--ink-2, #4a5873)', strong: 'var(--ink-1, #0b1a33)', font: 12.5, ...opts,
        };
        const max = o.max || Math.max(...items.map((i) => i.value)) || 1;

        onResize(container, () => {
            container.innerHTML = '';
            const W = width(container);
            const H = items.length * o.row;
            const svg = el('svg', { width: W, height: H, viewBox: `0 0 ${W} ${H}`, role: 'img', 'aria-label': o.title || 'grafik batang' }, container);
            const x0 = o.labelWidth;
            const span = W - x0 - o.valueWidth;

            items.forEach((item, i) => {
                const y = i * o.row + (o.row - o.thickness) / 2;
                const w = Math.max((item.value / max) * span, 2);
                if (o.track !== 'transparent') {
                    el('rect', { x: x0, y, width: span, height: o.thickness, rx: 4, fill: o.track }, svg);
                }
                el('text', { x: 0, y: y + o.thickness / 2 + 4.5, fill: o.ink, 'font-size': o.font }, svg).textContent = item.label;
                const bar = el('path', { d: barPath(x0, y, w, o.thickness), fill: item.color || o.color }, svg);
                el('text', { x: x0 + w + 8, y: y + o.thickness / 2 + 4.5, fill: o.strong, 'font-size': o.font, 'font-weight': 600, class: 'tnum' }, svg).textContent = item.valueLabel ?? item.value;
                const hit = el('rect', { x: 0, y: i * o.row, width: W, height: o.row, fill: 'transparent' }, svg);
                bindTip(hit, item.tip || `<b>${item.label}</b><br>${item.valueLabel ?? item.value}`);
                hit.addEventListener('mouseenter', () => bar.setAttribute('opacity', '.82'));
                hit.addEventListener('mouseleave', () => bar.setAttribute('opacity', '1'));
            });
        });
    }

    /* ---------- satu batang bertumpuk 100% dengan celah 2px ---------- */
    function stack(container, items, opts = {}) {
        const o = { height: 18, gap: 2, ...opts };
        const total = items.reduce((s, i) => s + i.value, 0) || 1;

        onResize(container, () => {
            container.innerHTML = '';
            const W = width(container);
            const svg = el('svg', { width: W, height: o.height, viewBox: `0 0 ${W} ${o.height}`, role: 'img', 'aria-label': o.title || 'proporsi' }, container);
            const clipId = 'clip' + Math.random().toString(36).slice(2, 8);
            const clip = el('clipPath', { id: clipId }, el('defs', {}, svg));
            el('rect', { x: 0, y: 0, width: W, height: o.height, rx: 4 }, clip);
            const g = el('g', { 'clip-path': `url(#${clipId})` }, svg);
            const usable = W - o.gap * (items.filter((i) => i.value > 0).length - 1);
            let x = 0;
            items.forEach((item) => {
                if (item.value <= 0) {
                    return;
                }
                const w = (item.value / total) * usable;
                const seg = el('rect', { x, y: 0, width: w, height: o.height, fill: item.color }, g);
                bindTip(seg, item.tip || `<b>${item.label}</b><br>${item.value}`);
                x += w + o.gap;
            });
        });
    }

    /* ---------- kontribusi kriteria per order (batang bertumpuk kecil) ---------- */
    function contrib(container, parts, colors, opts = {}) {
        const o = { height: 10, gap: 2, max: 1, ...opts };
        onResize(container, () => {
            container.innerHTML = '';
            const W = width(container);
            const svg = el('svg', { width: W, height: o.height, viewBox: `0 0 ${W} ${o.height}`, role: 'img', 'aria-label': 'kontribusi kriteria' }, container);
            const total = parts.reduce((s, p) => s + p.value, 0);
            const full = (total / o.max) * W;
            const clipId = 'cc' + Math.random().toString(36).slice(2, 8);
            const clip = el('clipPath', { id: clipId }, el('defs', {}, svg));
            el('rect', { x: 0, y: 0, width: Math.max(full, 2), height: o.height, rx: 3 }, clip);
            const g = el('g', { 'clip-path': `url(#${clipId})` }, svg);
            const visible = parts.filter((p) => p.value > 0.0005);
            const usable = full - o.gap * (visible.length - 1);
            let x = 0;
            parts.forEach((p, i) => {
                if (p.value <= 0.0005) {
                    return;
                }
                const w = (p.value / total) * usable;
                const seg = el('rect', { x, y: 0, width: w, height: o.height, fill: colors[i] }, g);
                bindTip(seg, p.tip);
                x += w + o.gap;
            });
        });
    }

    /* ---------- timeline mulai sampai deadline ---------- */
    function gantt(container, orders, opts = {}) {
        const o = {
            row: 30, thickness: 12, labelWidth: 150, today: '2026-10-09',
            track: 'var(--g-track, #cde2fb)', fill: 'var(--g-fill, #2a78d6)', late: 'var(--critical, #d03b3b)',
            grid: 'var(--grid, #e3e9f3)', ink: 'var(--ink-2, #4a5873)', strong: 'var(--ink-1, #0b1a33)',
            todayColor: 'var(--today, #0b1a33)', fmt: (d) => d, ...opts,
        };
        const day = 86400000;
        const t = (d) => new Date(d + 'T00:00:00').getTime();
        const starts = orders.map((x) => t(x.start));
        const ends = orders.map((x) => t(x.deadline || x.start));
        const from = Math.min(...starts, t(o.today)) - day;
        const to = Math.max(...ends, t(o.today)) + day * 2;

        onResize(container, () => {
            container.innerHTML = '';
            const W = width(container);
            const top = 42;
            const H = top + orders.length * o.row + 6;
            const svg = el('svg', { width: W, height: H, viewBox: `0 0 ${W} ${H}`, role: 'img', 'aria-label': 'timeline order' }, container);
            const x0 = o.labelWidth;
            const span = W - x0 - 12;
            const X = (ms) => x0 + ((ms - from) / (to - from)) * span;

            for (let d = from + day; d < to; d += day * 3) {
                const x = X(d);
                el('line', { x1: x, x2: x, y1: top - 4, y2: H - 4, stroke: o.grid, 'stroke-width': 1 }, svg);
                el('text', { x, y: 12, fill: o.ink, 'font-size': 11, 'text-anchor': 'middle', class: 'tnum' }, svg).textContent = o.fmt(new Date(d).toISOString().slice(0, 10));
            }

            orders.forEach((order, i) => {
                const y = top + i * o.row + (o.row - o.thickness) / 2;
                const hasDeadline = Boolean(order.deadline);
                const xStart = X(t(order.start));
                const xDeadline = hasDeadline ? X(t(order.deadline) + day * 0.6) : W - 12;
                const xs = Math.min(xStart, xDeadline);
                const w = Math.max(Math.abs(xDeadline - xStart), 4);
                el('text', { x: 0, y: y + o.thickness / 2 + 4, fill: o.strong, 'font-size': 12, 'font-weight': 600, class: 'tnum' }, svg).textContent = order.ref.replace('WEBA/MO/', 'MO ');
                el('text', { x: 52, y: y + o.thickness / 2 + 4, fill: o.ink, 'font-size': 12 }, svg).textContent = order.product.replace('Weba ', '') + (hasDeadline ? '' : ', tanpa deadline');
                el('rect', hasDeadline
                    ? { x: xs, y, width: w, height: o.thickness, rx: 4, fill: o.track }
                    : { x: xs + 0.5, y: y + 0.5, width: w - 1, height: o.thickness - 1, rx: 4, fill: 'transparent', stroke: o.fill, 'stroke-width': 1, 'stroke-dasharray': '4 3' }, svg);
                const pw = w * (order.progress / 100);
                if (pw > 0) {
                    el('path', { d: barPath(xs, y, pw, o.thickness), fill: o.fill }, svg);
                }
                if (order.isLate) {
                    el('rect', { x: xDeadline - 2, y: y - 3, width: 3, height: o.thickness + 6, rx: 1.5, fill: o.late }, svg);
                }
                const hit = el('rect', { x: 0, y: top + i * o.row, width: W, height: o.row, fill: 'transparent' }, svg);
                const status = order.isLate ? '<b style="color:#ff9a9a">Terlambat</b>' : (order.isDueSoon ? 'Jatuh tempo dalam 3 hari' : 'Sesuai jadwal');
                bindTip(hit, `<b>${order.ref}</b> ${order.product}<br><span class="k">Mulai</span> ${o.fmt(order.start)} <span class="k">Deadline</span> ${order.deadline ? o.fmt(order.deadline) : 'belum ada'}<br><span class="k">Progres</span> ${order.progress}% <span class="k">Status</span> ${status}`);
            });

            const xt = X(t(o.today) + day * 0.5);
            el('line', { x1: xt, x2: xt, y1: top - 8, y2: H - 2, stroke: o.todayColor, 'stroke-width': 1.5 }, svg);
            el('rect', { x: xt - 26, y: top - 22, width: 52, height: 16, rx: 8, fill: o.todayColor }, svg);
            el('text', { x: xt, y: top - 10.5, fill: 'var(--today-ink, #fff)', 'font-size': 10.5, 'font-weight': 650, 'text-anchor': 'middle' }, svg).textContent = 'Hari ini';
        });
    }

    /* ---------- grafik sebar dengan empat kuadran ---------- */
    function scatter(container, points, opts = {}) {
        const o = {
            height: 420, xMin: -4, xMax: 22, yMin: 0.15, yMax: 0.85, xSplit: 3, ySplit: 0.4,
            xLabel: '', yLabel: '', quadrants: [], highlight: 'var(--quad, #e8f1fc)',
            grid: 'var(--grid, #e6ecf4)', axis: 'var(--axis, #c6d2e3)', ink: 'var(--ink-2, #4a5873)', muted: 'var(--muted, #7a879e)',
            surface: 'var(--card, #ffffff)', xTicks: [], yTicks: [], labelTop: 0, ...opts,
        };

        onResize(container, () => {
            container.innerHTML = '';
            const W = width(container);
            const H = o.height;
            const m = { l: 56, r: 18, t: 18, b: 46 };
            const svg = el('svg', { width: W, height: H, viewBox: `0 0 ${W} ${H}`, role: 'img', 'aria-label': o.title || 'grafik sebar' }, container);
            const X = (v) => m.l + ((v - o.xMin) / (o.xMax - o.xMin)) * (W - m.l - m.r);
            const Y = (v) => H - m.b - ((v - o.yMin) / (o.yMax - o.yMin)) * (H - m.t - m.b);

            el('rect', { x: X(o.xMin), y: Y(o.yMax), width: X(o.xSplit) - X(o.xMin), height: Y(o.ySplit) - Y(o.yMax), fill: o.highlight }, svg);
            o.yTicks.forEach((v) => {
                el('line', { x1: m.l, x2: W - m.r, y1: Y(v), y2: Y(v), stroke: o.grid, 'stroke-width': 1 }, svg);
                el('text', { x: m.l - 8, y: Y(v) + 4, fill: o.muted, 'font-size': 11.5, 'text-anchor': 'end', class: 'tnum' }, svg).textContent = String(v).replace('.', ',');
            });
            o.xTicks.forEach((v) => {
                el('line', { x1: X(v), x2: X(v), y1: m.t, y2: H - m.b, stroke: o.grid, 'stroke-width': 1 }, svg);
                el('text', { x: X(v), y: H - m.b + 18, fill: o.muted, 'font-size': 11.5, 'text-anchor': 'middle', class: 'tnum' }, svg).textContent = v;
            });
            el('line', { x1: X(0), x2: X(0), y1: m.t, y2: H - m.b, stroke: o.axis, 'stroke-width': 1 }, svg);
            el('line', { x1: X(o.xSplit), x2: X(o.xSplit), y1: m.t, y2: H - m.b, stroke: o.ink, 'stroke-width': 1, 'stroke-dasharray': '4 4' }, svg);
            el('line', { x1: m.l, x2: W - m.r, y1: Y(o.ySplit), y2: Y(o.ySplit), stroke: o.ink, 'stroke-width': 1, 'stroke-dasharray': '4 4' }, svg);
            el('line', { x1: m.l, x2: W - m.r, y1: H - m.b, y2: H - m.b, stroke: o.axis, 'stroke-width': 1 }, svg);

            o.quadrants.forEach((q) => {
                const x = q.pos.includes('l') ? X(o.xMin) + 10 : W - m.r - 10;
                const y = q.pos.includes('t') ? Y(o.yMax) + 18 : H - m.b - 10;
                el('text', { x, y, fill: q.strong ? 'var(--ink-1, #0b1a33)' : o.muted, 'font-size': 12.5, 'font-weight': q.strong ? 700 : 600, 'text-anchor': q.pos.includes('l') ? 'start' : 'end' }, svg).textContent = q.text;
            });

            el('text', { x: (m.l + W - m.r) / 2, y: H - 8, fill: o.ink, 'font-size': 12, 'text-anchor': 'middle' }, svg).textContent = o.xLabel;
            const yl = el('text', { x: 14, y: (m.t + H - m.b) / 2, fill: o.ink, 'font-size': 12, 'text-anchor': 'middle', transform: `rotate(-90 14 ${(m.t + H - m.b) / 2})` }, svg);
            yl.textContent = o.yLabel;

            [...points].sort((a, b) => a.y - b.y).forEach((p) => {
                const cx = X(Math.max(o.xMin, Math.min(o.xMax, p.x)));
                const cy = Y(p.y);
                const g = el('g', {}, svg);
                el('circle', { cx, cy, r: 7, fill: p.hollow ? o.surface : p.color, stroke: p.hollow ? p.color : o.surface, 'stroke-width': p.hollow ? 2 : 2 }, g);
                if (p.label) {
                    el('text', { x: cx + 10, y: cy + 4, fill: 'var(--ink-1, #0b1a33)', 'font-size': 11.5, 'font-weight': 600, class: 'tnum' }, svg).textContent = p.label;
                }
                const hit = el('circle', { cx, cy, r: 13, fill: 'transparent' }, g);
                bindTip(hit, p.tip);
                hit.addEventListener('mouseenter', () => g.firstChild.setAttribute('r', '9'));
                hit.addEventListener('mouseleave', () => g.firstChild.setAttribute('r', '7'));
            });
        });
    }

    window.WebaCharts = { hbar, stack, contrib, gantt, scatter, bindTip };
})();
