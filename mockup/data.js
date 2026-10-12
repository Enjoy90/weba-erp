/*
 * Data demo Weba ERP (diambil dari database weba_erp setelah DemoDataSeeder, 9 Oktober 2026).
 * Dipakai bersama oleh kelima mockup supaya angka di semua desain sama.
 */
(function () {
    const today = '2026-10-09';

    const criteria = [
        { code: 'C1', name: 'Sisa waktu ke deadline', short: 'Deadline', unit: 'hari', type: 'cost', weight: 0.30 },
        { code: 'C2', name: 'Urgensi pelanggan', short: 'Urgensi', unit: 'skala 1-5', type: 'benefit', weight: 0.20 },
        { code: 'C3', name: 'Ketersediaan bahan', short: 'Bahan', unit: '%', type: 'benefit', weight: 0.15 },
        { code: 'C4', name: 'Sisa durasi produksi', short: 'Durasi', unit: 'jam', type: 'cost', weight: 0.15 },
        { code: 'C5', name: 'Progres penyelesaian', short: 'Progres', unit: '%', type: 'benefit', weight: 0.10 },
        { code: 'C6', name: 'Nilai order', short: 'Nilai', unit: 'Rp', type: 'benefit', weight: 0.10 },
    ];

    const stages = [
        { key: 'STC', name: 'Stitching', full: 'Stitching (jahit upper)', hours: 88.4, workOrders: 12 },
        { key: 'STB', name: 'Strobel', full: 'Strobel', hours: 50.2, workOrders: 15 },
        { key: 'LST', name: 'Lasting', full: 'Lasting', hours: 99.5, workOrders: 18 },
        { key: 'INJ', name: 'Injection', full: 'Injection (injeksi sol)', hours: 87.5, workOrders: 20 },
        { key: 'FIN', name: 'Finishing', full: 'Finishing', hours: 113.3, workOrders: 21 },
    ];

    const statuses = [
        { key: 'draft', label: 'Draft', count: 3 },
        { key: 'confirmed', label: 'Dikonfirmasi', count: 11 },
        { key: 'progress', label: 'Dikerjakan', count: 10 },
        { key: 'to_close', label: 'Siap ditutup', count: 2 },
        { key: 'done', label: 'Selesai', count: 4 },
    ];

    /* rank, referensi, artikel, skor, deadline, status, [C1..C6], qty (pasang), mulai, tahap selesai, tahap berjalan */
    const raw = [
        [1, 'WEBA/MO/0001', 'Weba Runner', 0.7932, '2026-10-07', 'progress', [0, 5, 100, 13.7, 63, 68400000], 240, '2026-09-30', 3, true],
        [2, 'WEBA/MO/0007', 'Weba Court', 0.6934, '2026-10-08', 'progress', [0, 3, 100, 12.0, 63, 51450000], 210, '2026-10-01', 3, false],
        [3, 'WEBA/MO/0016', 'Weba Casual Slip-On', 0.6087, '2026-10-06', 'confirmed', [0, 4, 86, 13.2, 0, 17200000], 80, '2026-10-09', 0, false],
        [4, 'WEBA/MO/0011', 'Weba Court', 0.5601, '2026-10-11', 'to_close', [2.3, 3, 100, 0, 100, 34300000], 140, '2026-09-29', 5, false],
        [5, 'WEBA/MO/0012', 'Weba Casual Slip-On', 0.5051, '2026-10-09', 'to_close', [0.3, 2, 100, 0, 100, 21500000], 100, '2026-09-30', 5, false],
        [6, 'WEBA/MO/0003', 'Weba Court', 0.4760, '2026-10-12', 'progress', [3.3, 4, 100, 9.2, 80, 73500000], 300, '2026-10-02', 4, false],
        [7, 'WEBA/MO/0002', 'Weba Trail', 0.4481, '2026-10-10', 'progress', [1.3, 5, 100, 14.0, 41, 48750000], 150, '2026-10-03', 2, true],
        [8, 'WEBA/MO/0009', 'Weba Runner', 0.3968, '2026-10-13', 'progress', [4.3, 5, 100, 7.5, 27, 17100000], 60, '2026-10-07', 1, true],
        [9, 'WEBA/MO/0014', 'Weba Trail', 0.3807, '2026-10-13', 'confirmed', [4.3, 5, 88, 20.8, 0, 42250000], 130, '2026-10-10', 0, false],
        [10, 'WEBA/MO/0006', 'Weba Trail', 0.3713, '2026-10-18', 'progress', [9.3, 4, 100, 10.8, 27, 29250000], 90, '2026-10-06', 1, false],
        [11, 'WEBA/MO/0013', 'Weba Runner', 0.3646, '2026-10-17', 'confirmed', [8.3, 4, 88, 34.2, 0, 62700000], 220, '2026-10-10', 0, false],
        [12, 'WEBA/MO/0022', 'Weba Trail', 0.3463, null, 'confirmed', [null, 3, 88, 38.8, 0, 81250000], 250, '2026-10-14', 0, false],
        [13, 'WEBA/MO/0005', 'Weba Runner', 0.3311, '2026-10-16', 'progress', [7.3, 2, 100, 16.6, 41, 51300000], 180, '2026-10-04', 2, false],
        [14, 'WEBA/MO/0004', 'Weba Casual Slip-On', 0.3274, '2026-10-14', 'progress', [5.3, 3, 100, 14.0, 27, 25800000], 120, '2026-10-05', 1, true],
        [15, 'WEBA/MO/0018', 'Weba Trail', 0.3159, '2026-10-19', 'confirmed', [10.3, 3, 88, 26.8, 0, 55250000], 170, '2026-10-11', 0, false],
        [16, 'WEBA/MO/0010', 'Weba Trail', 0.3111, '2026-10-15', 'progress', [6.3, 3, 100, 18.4, 41, null], 200, '2026-10-03', 2, true],
        [17, 'WEBA/MO/0021', 'Weba Runner', 0.2913, '2026-10-11', 'confirmed', [2.3, 4, 88, 13.2, 0, null], 75, '2026-10-09', 0, false],
        [18, 'WEBA/MO/0015', 'Weba Court', 0.2858, '2026-10-23', 'confirmed', [14.3, 2, 88, 40.2, 0, 63700000], 260, '2026-10-11', 0, false],
        [19, 'WEBA/MO/0019', 'Weba Court', 0.2828, '2026-10-15', 'confirmed', [6.3, 3, 88, 17.8, 0, 26950000], 110, '2026-10-10', 0, false],
        [20, 'WEBA/MO/0017', 'Weba Runner', 0.2713, '2026-10-29', 'confirmed', [20.3, 1, 88, 46.2, 0, 85500000], 300, '2026-10-12', 0, false],
        [21, 'WEBA/MO/0008', 'Weba Casual Slip-On', 0.2702, '2026-10-21', 'progress', [12.3, 2, 100, 25.2, 0, 34400000], 160, '2026-10-07', 0, true],
        [22, 'WEBA/MO/0020', 'Weba Casual Slip-On', 0.2563, '2026-10-27', 'confirmed', [18.3, 2, 86, 29.8, 0, 40850000], 190, '2026-10-13', 0, false],
        [23, 'WEBA/MO/0023', 'Weba Court', 0.1985, '2026-10-18', 'confirmed', [9.3, 1, 88, 16.2, 0, 23275000], 95, '2026-10-11', 0, false],
    ];

    const orders = raw.map(([rank, ref, product, score, deadline, state, values, qty, start, done, running]) => ({
        rank, ref, product, score, deadline, state, values, qty, start, done, running,
    }));

    /* Normalisasi SAW yang sama dengan SawCalculator: nilai kosong = nilai terburuk kolom. */
    criteria.forEach((criterion, j) => {
        const present = orders.map((o) => o.values[j]).filter((v) => v !== null);
        const fallback = criterion.type === 'cost' ? Math.max(...present) : 0;
        const column = orders.map((o) => (o.values[j] === null ? fallback : o.values[j]));
        const max = Math.max(...column);
        const min = Math.min(...column);

        orders.forEach((order, i) => {
            const x = column[i];
            const r = criterion.type === 'benefit' ? (max > 0 ? x / max : 0) : (x === 0 ? 1 : min / x);
            order.normalized = order.normalized || [];
            order.contribution = order.contribution || [];
            order.normalized[j] = r;
            order.contribution[j] = r * criterion.weight;
        });
    });

    const dayMs = 86400000;
    const daysBetween = (a, b) => Math.round((new Date(b) - new Date(a)) / dayMs);

    orders.forEach((order) => {
        order.progress = order.values[4];
        order.material = order.values[2];
        order.daysLeft = order.deadline ? daysBetween(today, order.deadline) : null;
        order.isLate = order.daysLeft !== null && order.daysLeft < 0;
        order.isDueSoon = order.daysLeft !== null && order.daysLeft >= 0 && order.daysLeft <= 3;
        order.stageIndex = Math.min(order.done, stages.length);
    });

    const late = orders.filter((o) => o.isLate).sort((a, b) => a.daysLeft - b.daysLeft);
    const valued = orders.filter((o) => o.values[5] !== null);

    const kpi = {
        active: orders.length,
        total: statuses.reduce((sum, s) => sum + s.count, 0),
        late: late.length,
        dueSoon: orders.filter((o) => o.isDueSoon).length,
        avgProgress: orders.reduce((sum, o) => sum + o.progress, 0) / orders.length,
        activeValue: valued.reduce((sum, o) => sum + o.values[5], 0),
        remainingHours: stages.reduce((sum, s) => sum + s.hours, 0),
        materialReady: orders.filter((o) => o.material >= 100).length,
        pairs: orders.reduce((sum, o) => sum + o.qty, 0),
    };

    const stageQueue = stages.map((stage, index) => ({
        ...stage,
        queued: orders.filter((o) => o.state !== 'to_close' && o.stageIndex === index).length,
        running: orders.filter((o) => o.running && o.stageIndex === index).length,
    }));

    const nf = new Intl.NumberFormat('id-ID');
    const nf1 = new Intl.NumberFormat('id-ID', { minimumFractionDigits: 1, maximumFractionDigits: 1 });
    const df = new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'short' });
    const dfl = new Intl.DateTimeFormat('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });

    const fmt = {
        int: (v) => nf.format(Math.round(v)),
        one: (v) => nf1.format(v),
        pct: (v) => nf1.format(v) + '%',
        score: (v) => v.toFixed(4).replace('.', ','),
        rupiah: (v) => (v === null ? 'belum diisi' : 'Rp ' + nf.format(v)),
        rupiahShort: (v) => {
            if (v === null) {
                return 'belum diisi';
            }
            if (v >= 1e9) {
                return 'Rp ' + nf1.format(v / 1e9) + ' M';
            }
            return 'Rp ' + nf1.format(v / 1e6) + ' jt';
        },
        date: (v) => (v ? df.format(new Date(v + 'T00:00:00')) : 'tanpa deadline'),
        longDate: (v) => dfl.format(new Date(v + 'T00:00:00')),
        daysLeft: (o) => {
            if (o.daysLeft === null) {
                return 'tanpa deadline';
            }
            if (o.daysLeft < 0) {
                return 'terlambat ' + Math.abs(o.daysLeft) + ' hari';
            }
            if (o.daysLeft === 0) {
                return 'jatuh tempo hari ini';
            }
            return o.daysLeft + ' hari lagi';
        },
    };

    const stateLabel = Object.fromEntries(statuses.map((s) => [s.key, s.label]));

    window.WEBA = {
        company: 'PT. Weba International',
        today,
        evaluation: { name: 'Evaluasi data demo', at: '9 Okt 2026, 08.42', orders: orders.length },
        criteria,
        stages: stageQueue,
        statuses,
        orders,
        late,
        kpi,
        fmt,
        stateLabel,
    };
})();
