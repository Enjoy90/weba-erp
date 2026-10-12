<?php

return [
    'navigation' => [
        'title' => 'Jenis Paket',
        'group' => 'Pengiriman',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title'  => 'Umum',

                'fields' => [
                    'name'       => 'Nama',
                    'barcode'    => 'Barcode',
                    'company'    => 'Perusahaan',
                    'weight'     => 'Berat',
                    'max-weight' => 'Berat Maks',

                    'fieldsets' => [
                        'size' => [
                            'title' => 'Ukuran',

                            'fields' => [
                                'length' => 'Panjang',
                                'width'  => 'Lebar',
                                'height' => 'Tinggi',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'       => 'Nama',
            'barcode'    => 'Barcode',
            'weight'     => 'Berat',
            'max-weight' => 'Berat Maks',
            'width'      => 'Lebar',
            'height'     => 'Tinggi',
            'length'     => 'Panjang',
            'created-at' => 'Dibuat Pada',
            'updated-at' => 'Diperbarui Pada',
        ],

        'groups' => [
            'created-at' => 'Dibuat Pada',
            'updated-at' => 'Diperbarui Pada',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Jenis Paket berhasil dihapus',
                    'body'  => 'Jenis Paket telah berhasil dihapus.',
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Jenis Paket berhasil dihapus',
                    'body'  => 'Jenis Paket telah berhasil dihapus.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title'   => 'Informasi Umum',
                'entries' => [
                    'name'      => 'Nama',
                    'fieldsets' => [
                        'size' => [
                            'title'   => 'Dimensi Paket',
                            'entries' => [
                                'length' => 'Panjang',
                                'width'  => 'Lebar',
                                'height' => 'Tinggi',
                            ],
                        ],
                    ],
                    'weight'     => 'Berat Dasar',
                    'max-weight' => 'Berat Maksimum',
                    'barcode'    => 'Barcode',
                    'company'    => 'Perusahaan',
                    'created-at' => 'Dibuat Pada',
                    'updated-at' => 'Terakhir Diperbarui',
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
