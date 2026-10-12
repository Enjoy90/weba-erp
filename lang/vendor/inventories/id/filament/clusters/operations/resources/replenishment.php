<?php

return [
    'navigation' => [
        'title' => 'Pengisian Ulang',
        'group' => 'Pengadaan',
    ],

    'form' => [
        'fields' => [
        ],
    ],

    'table' => [
        'columns' => [
            'product'           => 'Produk',
            'location'          => 'Lokasi',
            'route'             => 'Rute',
            'vendor'            => 'Pemasok',
            'trigger'           => 'Pemicu',
            'on-hand'           => 'Tersedia',
            'min'               => 'Min',
            'max'               => 'Maks',
            'multiple-quantity' => 'Kelipatan Jumlah',
            'to-order'          => 'Akan Dipesan',
            'uom'               => 'Satuan',
            'company'           => 'Perusahaan',
        ],

        'groups' => [
            'location' => 'Lokasi',
            'product'  => 'Produk',
            'category' => 'Kategori',
        ],

        'filters' => [
        ],

        'header-actions' => [
            'create' => [
                'label' => 'Tambah Pengisian Ulang',

                'notification' => [
                    'title' => 'Pengisian ulang berhasil ditambahkan',
                    'body'  => 'Pengisian ulang telah berhasil ditambahkan.',
                ],

                'before' => [
                    'notification' => [
                        'title' => 'Pengisian ulang sudah ada',
                        'body'  => 'Pengisian ulang untuk konfigurasi ini sudah ada. Perbarui pengisian ulang yang sudah ada.',
                    ],
                ],
            ],
        ],

        'actions' => [
        ],
    ],
];
