<?php

return [
    'title' => 'Lokasi',

    'table' => [
        'columns' => [
            'product'          => 'Produk',
            'location'         => 'Lokasi',
            'storage-category' => 'Kategori Penyimpanan',
            'quantity'         => 'Jumlah',
            'package'          => 'Paket',
            'on-hand'          => 'Jumlah Tersedia',
            'unit'             => 'Satuan',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Jumlah berhasil dihapus',
                    'body'  => 'Jumlah telah berhasil dihapus.',
                ],
            ],
        ],
    ],
];
