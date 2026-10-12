<?php

return [
    'title' => 'MASUK/KELUAR',

    'table' => [
        'columns' => [
            'date'                 => 'Tanggal',
            'reference'            => 'Referensi',
            'product'              => 'Produk',
            'package'              => 'Paket',
            'lot'                  => 'Lot / Nomor Seri',
            'source-location'      => 'Lokasi Asal',
            'destination-location' => 'Lokasi Tujuan',
            'quantity'             => 'Jumlah',
            'state'                => 'Status',
            'done-by'              => 'Dikerjakan oleh',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Pergerakan stok berhasil dihapus',
                    'body'  => 'Pergerakan stok telah berhasil dihapus.',
                ],
            ],
        ],
    ],
];
