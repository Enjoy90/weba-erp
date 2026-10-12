<?php

return [
    'title' => 'Jumlah Stok',

    'tabs' => [
        'internal-locations' => 'Lokasi Internal',
        'transit-locations'  => 'Lokasi Transit',
        'on-hand'            => 'Tersedia',
        'to-count'           => 'Akan Dihitung',
        'to-apply'           => 'Akan Diterapkan',
    ],

    'form' => [
        'fields' => [
            'product'          => 'Produk',
            'location'         => 'Lokasi',
            'package'          => 'Paket',
            'lot'              => 'Lot / Nomor Seri',
            'on-hand-qty'      => 'Jumlah Tersedia',
            'storage-category' => 'Kategori Penyimpanan',
        ],
    ],

    'table' => [
        'columns' => [
            'product'           => 'Produk',
            'location'          => 'Lokasi',
            'lot'               => 'Lot / Nomor Seri',
            'storage-category'  => 'Kategori Penyimpanan',
            'quantity'          => 'Jumlah',
            'package'           => 'Paket',
            'on-hand'           => 'Jumlah Tersedia',
            'unit'              => 'Satuan',
            'reserved-quantity' => 'Jumlah Dipesan',

            'on-hand-before-state-updated' => [
                'notification' => [
                    'title' => 'Jumlah berhasil diperbarui',
                    'body'  => 'Jumlah telah berhasil diperbarui.',
                ],
            ],
        ],

        'header-actions' => [
            'create' => [
                'label' => 'Tambah Jumlah',

                'notification' => [
                    'title' => 'Jumlah berhasil ditambahkan',
                    'body'  => 'Jumlah telah berhasil ditambahkan.',
                ],

                'before' => [
                    'notification' => [
                        'title' => 'Jumlah sudah ada',
                        'body'  => 'Jumlah untuk konfigurasi yang sama sudah ada. Perbarui jumlah tersebut.',
                    ],
                ],
            ],
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
