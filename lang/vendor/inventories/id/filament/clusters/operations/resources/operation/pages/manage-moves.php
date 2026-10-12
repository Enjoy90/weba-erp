<?php

return [
    'title' => 'Pergerakan Stok',

    'table' => [
        'columns' => [
            'date'                 => 'Tanggal',
            'reference'            => 'Referensi',
            'product'              => 'Produk',
            'package'              => 'Paket',
            'lot'                  => 'Lot / Nomor Seri',
            'source-location'      => 'Lokasi Sumber',
            'destination-location' => 'Lokasi Tujuan',
            'quantity'             => 'Jumlah',
            'unit'                 => 'Satuan',
            'state'                => 'Status',
            'done-by'              => 'Diselesaikan Oleh',
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
