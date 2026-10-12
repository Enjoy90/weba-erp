<?php

return [
    'navigation' => [
        'title' => 'Laporan produksi harian',
    ],

    'subheading' => 'Work order yang dikerjakan atau selesai pada periode, rencana dibandingkan hasil. Jumlah dan menit adalah total tiap work order sampai saat ini; kolom terakhir hanya menghitung menit yang dicatat di dalam periode.',

    'table' => [
        'order'             => 'Order produksi',
        'product'           => 'Produk',
        'operation'         => 'Operasi',
        'work-center'       => 'Work center',
        'state'             => 'Status',
        'target-quantity'   => 'Jumlah order',
        'produced-quantity' => 'Terproduksi',
        'planned-minutes'   => 'Rencana (menit)',
        'actual-minutes'    => 'Realisasi (menit)',
        'efficiency'        => 'Efisiensi',
        'minutes-in-period' => 'Dikerjakan di periode (menit)',
        'period'            => 'Periode',
        'from'              => 'Dari',
        'until'             => 'Sampai',
        'total'             => 'Total',
        'total-finished'    => 'Total yang selesai',
        'empty'             => 'Tidak ada pekerjaan tercatat pada periode ini',
        'empty-description' => 'Pilih tanggal lain, atau hapus filter periode untuk melihat semua work order.',
    ],

    'indicators' => [
        'from'  => 'Dari :date',
        'until' => 'Sampai :date',
    ],
];
