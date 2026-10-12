<?php

return [
    'actions' => [
        'excel' => 'Ekspor ke Excel',
        'pdf'   => 'Ekspor ke PDF',
    ],

    'pdf' => [
        'empty'   => 'Tidak ada baris pada laporan ini',
        'printed' => 'Dicetak oleh :user pada :date',
    ],

    'ranking' => [
        'title'    => 'Peringkat prioritas SAW',
        'rank'     => 'Peringkat',
        'order'    => 'Order produksi',
        'product'  => 'Produk',
        'deadline' => 'Tenggat',
        'score'    => 'Skor SAW',
        'weights'  => 'Bobot',
    ],

    'monitoring' => [
        'title'        => 'Monitoring order',
        'order'        => 'Order produksi',
        'product'      => 'Produk',
        'state'        => 'Status',
        'priority'     => 'Prioritas',
        'deadline'     => 'Tenggat',
        'progress'     => 'Progres (%)',
        'material'     => 'Bahan (%)',
        'work-left'    => 'Sisa kerja (jam)',
        'urgency'      => 'Urgensi',
        'order-value'  => 'Nilai order (Rp)',
        'value-source' => 'Nilai dari',
        'customer'     => 'Pelanggan',
        'source'       => [
            'sales_order' => 'Sales order',
            'manual'      => 'Diisi manual',
        ],
    ],

    'daily' => [
        'period' => 'Periode: :from sampai :until',
    ],
];
