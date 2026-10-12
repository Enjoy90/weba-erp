<?php

return [
    'navigation' => [
        'title' => 'Perjanjian Pembelian',
        'group' => 'Pembelian',
    ],

    'global-search' => [
        'vendor' => 'Pemasok',
        'type'   => 'Jenis',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title' => 'Umum',

                'fields' => [
                    'vendor'                => 'Pemasok',
                    'valid-from'            => 'Berlaku Dari',
                    'valid-to'              => 'Berlaku Hingga',
                    'buyer'                 => 'Pembeli',
                    'reference'             => 'Referensi',
                    'reference-placeholder' => 'mis. PO/123',
                    'agreement-type'        => 'Jenis Perjanjian',
                    'company'               => 'Perusahaan',
                    'currency'              => 'Mata Uang',
                ],
            ],
        ],

        'tabs' => [
            'products' => [
                'title' => 'Produk',

                'columns' => [
                    'product'    => 'Produk',
                    'quantity'   => 'Jumlah',
                    'ordered'    => 'Dipesan',
                    'uom'        => 'Satuan Ukur',
                    'unit-price' => 'Harga Satuan',
                ],

                'fields' => [
                    'product'    => 'Produk',
                    'quantity'   => 'Jumlah',
                    'ordered'    => 'Dipesan',
                    'uom'        => 'Satuan Ukur',
                    'unit-price' => 'Harga Satuan',
                ],
            ],

            'additional' => [
                'title' => 'Informasi Tambahan',
            ],

            'terms' => [
                'title' => 'Syarat dan Ketentuan',
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'agreement'      => 'Perjanjian',
            'vendor'         => 'Pemasok',
            'agreement-type' => 'Jenis Perjanjian',
            'buyer'          => 'Pembeli',
            'company'        => 'Perusahaan',
            'valid-from'     => 'Berlaku Dari',
            'valid-to'       => 'Berlaku Hingga',
            'reference'      => 'Referensi',
            'status'         => 'Status',
        ],

        'groups' => [
            'agreement-type' => 'Jenis Perjanjian',
            'vendor'         => 'Pemasok',
            'state'          => 'Status',
            'created-at'     => 'Dibuat Pada',
            'updated-at'     => 'Diperbarui Pada',
        ],

        'filters' => [
            'agreement'      => 'Perjanjian',
            'vendor'         => 'Pemasok',
            'agreement-type' => 'Jenis Perjanjian',
            'buyer'          => 'Pembeli',
            'company'        => 'Perusahaan',
            'valid-from'     => 'Berlaku Dari',
            'valid-to'       => 'Berlaku Hingga',
            'reference'      => 'Referensi',
            'status'         => 'Status',
            'created-at'     => 'Dibuat Pada',
            'updated-at'     => 'Diperbarui Pada',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Perjanjian pembelian berhasil dihapus',
                    'body'  => 'Perjanjian pembelian telah berhasil dihapus.',
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Perjanjian pembelian berhasil dipulihkan',
                    'body'  => 'Perjanjian pembelian telah berhasil dipulihkan.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Perjanjian pembelian berhasil dihapus permanen',
                        'body'  => 'Perjanjian pembelian telah berhasil dihapus secara permanen.',
                    ],

                    'error' => [
                        'title' => 'Perjanjian pembelian tidak dapat dihapus',
                        'body'  => 'Perjanjian pembelian tidak dapat dihapus karena sedang digunakan.',
                    ],

                    'warning' => [
                        'title' => 'Perjanjian pembelian tidak dapat dihapus',
                        'body'  => 'Hanya perjanjian pembelian berstatus Draf atau Dibatalkan yang dapat dihapus.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Perjanjian pembelian berhasil dihapus',
                    'body'  => 'Perjanjian pembelian telah berhasil dihapus.',
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Perjanjian pembelian berhasil dipulihkan',
                    'body'  => 'Perjanjian pembelian telah berhasil dipulihkan.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Perjanjian pembelian berhasil dihapus permanen',
                        'body'  => 'Perjanjian pembelian telah berhasil dihapus secara permanen.',
                    ],

                    'error' => [
                        'title' => 'Perjanjian pembelian tidak dapat dihapus',
                        'body'  => 'Perjanjian pembelian tidak dapat dihapus karena sedang digunakan.',
                    ],

                    'warning' => [
                        'title' => 'Perjanjian pembelian tidak dapat dihapus',
                        'body'  => 'Hanya perjanjian pembelian berstatus Draf atau Dibatalkan yang dapat dihapus.',
                    ],
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title' => 'Umum',

                'entries' => [
                    'vendor'                => 'Pemasok',
                    'valid-from'            => 'Berlaku Dari',
                    'valid-to'              => 'Berlaku Hingga',
                    'buyer'                 => 'Pembeli',
                    'reference'             => 'Referensi',
                    'reference-placeholder' => 'mis. PO/123',
                    'agreement-type'        => 'Jenis Perjanjian',
                    'company'               => 'Perusahaan',
                    'currency'              => 'Mata Uang',
                ],
            ],

            'metadata' => [
                'title' => 'Metadata',

                'entries' => [
                    'created-at' => 'Dibuat Pada',
                    'created-by' => 'Dibuat Oleh',
                    'updated-at' => 'Diperbarui Pada',
                ],
            ],
        ],

        'tabs' => [
            'products' => [
                'title' => 'Produk',

                'entries' => [
                    'product'    => 'Produk',
                    'quantity'   => 'Jumlah',
                    'ordered'    => 'Dipesan',
                    'uom'        => 'Satuan Ukur',
                    'unit-price' => 'Harga Satuan',
                ],
            ],

            'additional' => [
                'title' => 'Informasi Tambahan',
            ],

            'terms' => [
                'title' => 'Syarat dan Ketentuan',
            ],
        ],
    ],
];
