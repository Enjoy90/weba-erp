<?php

return [
    'navigation' => [
        'title' => 'Paket',
        'group' => 'Inventaris',
    ],

    'global-search' => [
        'name'         => 'Nama',
        'package-type' => 'Jenis Paket',
        'location'     => 'Lokasi',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title' => 'Umum',

                'fields' => [
                    'name'             => 'Nama',
                    'name-placeholder' => 'mis. PACK007',
                    'package-type'     => 'Jenis Paket',
                    'pack-date'        => 'Tanggal Kemas',
                    'location'         => 'Lokasi',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'         => 'Nama',
            'package-type' => 'Jenis Paket',
            'location'     => 'Lokasi',
            'company'      => 'Perusahaan',
            'created-at'   => 'Dibuat Pada',
            'updated-at'   => 'Diperbarui Pada',
        ],

        'groups' => [
            'package-type'   => 'Jenis Paket',
            'location'       => 'Lokasi',
            'created-at'     => 'Dibuat Pada',
        ],

        'filters' => [
            'package-type' => 'Jenis Paket',
            'location'     => 'Lokasi',
            'creator'      => 'Pembuat',
            'company'      => 'Perusahaan',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Paket berhasil dihapus',
                        'body'  => 'Paket telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Paket tidak dapat dihapus',
                        'body'  => 'Paket tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'print-without-content' => [
                'label' => 'Cetak Barcode',
            ],

            'print-with-content' => [
                'label' => 'Cetak Barcode Beserta Isi',
            ],

            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Data paket berhasil dihapus',
                        'body'  => 'Data paket telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Data paket tidak dapat dihapus',
                        'body'  => 'Data paket tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title' => 'Detail Paket',

                'entries' => [
                    'name'         => 'Nama Paket',
                    'package-type' => 'Jenis Paket',
                    'pack-date'    => 'Tanggal Kemas',
                    'location'     => 'Lokasi',
                    'company'      => 'Perusahaan',
                    'created-at'   => 'Dibuat Pada',
                    'updated-at'   => 'Terakhir Diperbarui',
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
