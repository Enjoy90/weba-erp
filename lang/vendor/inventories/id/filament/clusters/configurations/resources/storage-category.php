<?php

return [
    'navigation' => [
        'title' => 'Kategori Penyimpanan',
        'group' => 'Manajemen Gudang',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title'  => 'Umum',

                'fields' => [
                    'name'               => 'Nama',
                    'allow-new-products' => 'Izinkan Produk Baru',
                    'max-weight'         => 'Berat Maks',
                    'company'            => 'Perusahaan',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'               => 'Nama',
            'allow-new-products' => 'Izinkan Produk Baru',
            'max-weight'         => 'Berat Maks',
            'company'            => 'Perusahaan',
            'deleted-at'         => 'Dihapus Pada',
            'created-at'         => 'Dibuat Pada',
            'updated-at'         => 'Diperbarui Pada',
        ],

        'groups' => [
            'allow-new-products' => 'Izinkan Produk Baru',
            'created-at'         => 'Dibuat Pada',
            'updated-at'         => 'Diperbarui Pada',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Kategori Penyimpanan berhasil dihapus',
                    'body'  => 'Kategori Penyimpanan telah berhasil dihapus.',
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Data kategori penyimpanan berhasil dihapus',
                    'body'  => 'Data kategori penyimpanan telah berhasil dihapus.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title'  => 'Umum',

                'entries' => [
                    'name'               => 'Nama',
                    'allow-new-products' => 'Izinkan Produk Baru',
                    'max-weight'         => 'Berat Maks',
                    'company'            => 'Perusahaan',
                ],
            ],

            'record-information' => [
                'title' => 'Informasi Data',

                'entries' => [
                    'created-by'   => 'Dibuat Oleh',
                    'created-at'   => 'Dibuat Pada',
                    'last-updated' => 'Terakhir Diperbarui',
                ],
            ],
        ],
    ],
];
