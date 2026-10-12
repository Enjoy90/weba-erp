<?php

return [
    'title' => 'Kapasitas per Paket',

    'form' => [
        'package-type' => 'Jenis Paket',
        'qty'          => 'Jumlah',
    ],

    'table' => [
        'header-actions' => [
            'create' => [
                'label' => 'Tambah Kapasitas Jenis Paket',

                'notification' => [
                    'title' => 'Kapasitas jenis paket berhasil ditambahkan',
                    'body'  => 'Kapasitas jenis paket telah berhasil ditambahkan.',
                ],
            ],
        ],

        'columns' => [
            'package-type' => 'Jenis Paket',
            'qty'          => 'Jumlah',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Kapasitas jenis paket berhasil diperbarui',
                    'body'  => 'Kapasitas jenis paket telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Kapasitas jenis paket berhasil dihapus',
                    'body'  => 'Kapasitas jenis paket telah berhasil dihapus.',
                ],
            ],
        ],
    ],
];
