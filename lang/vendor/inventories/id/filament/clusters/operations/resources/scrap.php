<?php

return [
    'navigation' => [
        'title' => 'Scrap',
        'group' => 'Penyesuaian',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title' => 'Umum',

                'fields' => [
                    'product'              => 'Produk',
                    'package'              => 'Paket',
                    'quantity'             => 'Jumlah',
                    'unit'                 => 'Satuan Ukur',
                    'lot'                  => 'Lot/Seri',
                    'tags'                 => 'Tag',
                    'name'                 => 'Nama',
                    'color'                => 'Warna',
                    'owner'                => 'Pemilik',
                    'source-location'      => 'Lokasi Sumber',
                    'destination-location' => 'Lokasi Scrap',
                    'source-document'      => 'Dokumen Sumber',
                    'company'              => 'Perusahaan',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'date'            => 'Tanggal',
            'reference'       => 'Referensi',
            'product'         => 'Produk',
            'package'         => 'Paket',
            'quantity'        => 'Jumlah',
            'uom'             => 'Satuan Ukur',
            'source-location' => 'Lokasi Sumber',
            'scrap-location'  => 'Lokasi Scrap',
            'unit'            => 'Satuan Ukur',
            'lot'             => 'Lot/Seri',
            'tags'            => 'Tag',
            'state'           => 'Status',
        ],

        'groups' => [
            'product'              => 'Produk',
            'source-location'      => 'Lokasi Sumber',
            'destination-location' => 'Lokasi Scrap',
        ],

        'filters' => [
            'source-location'      => 'Lokasi Sumber',
            'destination-location' => 'Lokasi Scrap',
            'product'              => 'Produk',
            'state'                => 'Status',
            'product-category'     => 'Kategori Produk',
            'uom'                  => 'Satuan Ukur',
            'lot'                  => 'Lot/Seri',
            'package'              => 'Paket',
            'tags'                 => 'Tag',
            'company'              => 'Perusahaan',
            'quantity'             => 'Jumlah',
            'creator'              => 'Pembuat',
            'closed-at'            => 'Ditutup Pada',
            'created-at'           => 'Dibuat Pada',
            'updated-at'           => 'Diperbarui Pada',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Scrap berhasil dihapus',
                        'body'  => 'Scrap telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Scrap tidak dapat dihapus',
                        'body'  => 'Scrap tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Data scrap berhasil dihapus',
                        'body'  => 'Data scrap yang dipilih telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Data scrap tidak dapat dihapus',
                        'body'  => 'Data scrap tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title' => 'Detail Scrap',

                'entries' => [
                    'product'              => 'Produk',
                    'quantity'             => 'Jumlah',
                    'lot'                  => 'Lot',
                    'tags'                 => 'Tag',
                    'package'              => 'Paket',
                    'owner'                => 'Pemilik',
                    'source-location'      => 'Lokasi Sumber',
                    'destination-location' => 'Lokasi Scrap',
                    'source-document'      => 'Dokumen Sumber',
                    'company'              => 'Perusahaan',
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
