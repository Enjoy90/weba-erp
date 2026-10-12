<?php

return [
    'title' => 'Kapasitas per Produk',

    'form' => [
        'product' => 'Produk',
        'qty'     => 'Jumlah',
    ],

    'table' => [
        'header-actions' => [
            'create' => [
                'label' => 'Tambah Kapasitas Produk',

                'notification' => [
                    'title' => 'Kapasitas produk berhasil ditambahkan',
                    'body'  => 'Kapasitas produk telah berhasil ditambahkan.',
                ],
            ],
        ],

        'columns' => [
            'product' => 'Produk',
            'qty'     => 'Jumlah',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Kapasitas produk berhasil diperbarui',
                    'body'  => 'Kapasitas produk telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Kapasitas produk berhasil dihapus',
                    'body'  => 'Kapasitas produk telah berhasil dihapus.',
                ],
            ],
        ],
    ],
];
