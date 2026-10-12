<?php

return [
    'navigation' => [
        'title' => 'Jumlah Stok',
        'group' => 'Penyesuaian',
    ],

    'form' => [
        'fields' => [
            'location'         => 'Lokasi',
            'product'          => 'Produk',
            'package'          => 'Paket',
            'lot'              => 'Lot / Nomor Seri',
            'counted-qty'      => 'Jumlah Terhitung',
            'scheduled-at'     => 'Dijadwalkan Pada',
            'storage-category' => 'Kategori Penyimpanan',
        ],
    ],

    'table' => [
        'columns' => [
            'location'           => 'Lokasi',
            'product'            => 'Produk',
            'product-category'   => 'Kategori Produk',
            'lot'                => 'Lot / Nomor Seri',
            'storage-category'   => 'Kategori Penyimpanan',
            'available-quantity' => 'Jumlah Tersedia',
            'quantity'           => 'Jumlah',
            'package'            => 'Paket',
            'last-counted-at'    => 'Terakhir Dihitung Pada',
            'on-hand'            => 'Jumlah Tersedia',
            'uom'                => 'Satuan',
            'counted'            => 'Jumlah Terhitung',
            'difference'         => 'Selisih',
            'scheduled-at'       => 'Dijadwalkan Pada',
            'user'               => 'Pengguna',
            'company'            => 'Perusahaan',

            'on-hand-before-state-updated' => [
                'notification' => [
                    'title' => 'Jumlah berhasil diperbarui',
                    'body'  => 'Jumlah telah berhasil diperbarui.',
                ],
            ],
        ],

        'groups' => [
            'product'          => 'Produk',
            'product-category' => 'Kategori Produk',
            'location'         => 'Lokasi',
            'storage-category' => 'Kategori Penyimpanan',
            'lot'              => 'Lot / Nomor Seri',
            'company'          => 'Perusahaan',
            'package'          => 'Paket',
        ],

        'filters' => [
            'product'             => 'Produk',
            'uom'                 => 'Satuan Ukur',
            'product-category'    => 'Kategori Produk',
            'location'            => 'Lokasi',
            'storage-category'    => 'Kategori Penyimpanan',
            'lot'                 => 'Lot / Nomor Seri',
            'company'             => 'Perusahaan',
            'package'             => 'Paket',
            'on-hand-quantity'    => 'Jumlah Tersedia',
            'difference-quantity' => 'Jumlah Selisih',
            'incoming-at'         => 'Masuk Pada',
            'scheduled-at'        => 'Dijadwalkan Pada',
            'user'                => 'Pengguna',
            'created-at'          => 'Dibuat Pada',
            'updated-at'          => 'Diperbarui Pada',
            'company'             => 'Perusahaan',
            'creator'             => 'Pembuat',
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
                        'body'  => 'Jumlah untuk konfigurasi ini sudah ada. Perbarui jumlah yang sudah ada.',
                    ],
                ],
            ],
        ],

        'actions' => [
            'apply' => [
                'label' => 'Terapkan',

                'notification' => [
                    'title' => 'Perubahan jumlah berhasil diterapkan',
                    'body'  => 'Perubahan jumlah telah berhasil diterapkan.',
                ],
            ],

            'clear' => [
                'label' => 'Bersihkan',

                'notification' => [
                    'title' => 'Perubahan jumlah berhasil dibersihkan',
                    'body'  => 'Perubahan jumlah telah berhasil dibersihkan.',
                ],
            ],
        ],
    ],
];
