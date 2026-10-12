<?php

return [
    'global-search' => [
        'reference' => 'Referensi',
        'barcode'   => 'Barcode',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title' => 'Umum',

                'fields' => [
                    'name'             => 'Nama',
                    'name-placeholder' => 'mis. Kaos',
                    'description'      => 'Deskripsi',
                    'tags'             => 'Tag',
                ],
            ],

            'images' => [
                'title' => 'Gambar',
            ],

            'inventory' => [
                'title' => 'Inventaris',

                'fields' => [],

                'fieldsets' => [
                    'logistics' => [
                        'title' => 'Logistik',

                        'fields' => [
                            'weight' => 'Berat',
                            'volume' => 'Volume',
                        ],
                    ],
                ],
            ],

            'settings' => [
                'title' => 'Pengaturan',

                'fields' => [
                    'type'                => 'Jenis',
                    'reference'           => 'Referensi',
                    'barcode'             => 'Barcode',
                    'category'            => 'Kategori',
                    'company'             => 'Perusahaan',
                    'company-placeholder' => 'Semua Perusahaan',
                ],
            ],

            'pricing' => [
                'title' => 'Harga',

                'fields' => [
                    'price'           => 'Harga',
                    'cost'            => 'Biaya',
                    'uom-placeholder' => 'Satuan',
                ],
            ],

            'additional' => [
                'title' => 'Tambahan',
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'favorite'            => 'Favorit',
            'name'                => 'Nama',
            'variants'            => 'Varian',
            'images'              => 'Gambar',
            'type'                => 'Jenis',
            'reference'           => 'Referensi',
            'responsible'         => 'Penanggung Jawab',
            'barcode'             => 'Barcode',
            'category'            => 'Kategori',
            'company'             => 'Perusahaan',
            'company-placeholder' => 'Semua Perusahaan',
            'price'               => 'Harga',
            'cost'                => 'Biaya',
            'on-hand'             => 'Tersedia',
            'tags'                => 'Tag',
            'deleted-at'          => 'Dihapus Pada',
            'created-at'          => 'Dibuat Pada',
            'updated-at'          => 'Diperbarui Pada',
        ],

        'groups' => [
            'type'       => 'Jenis',
            'category'   => 'Kategori',
            'created-at' => 'Dibuat Pada',
        ],

        'filters' => [
            'name'        => 'Nama',
            'type'        => 'Jenis',
            'reference'   => 'Referensi',
            'barcode'     => 'Barcode',
            'category'    => 'Kategori',
            'company'     => 'Perusahaan',
            'price'       => 'Harga',
            'cost'        => 'Biaya',
            'is-favorite' => 'Favorit',
            'weight'      => 'Berat',
            'volume'      => 'Volume',
            'tags'        => 'Tag',
            'responsible' => 'Penanggung Jawab',
            'created-at'  => 'Dibuat Pada',
            'updated-at'  => 'Diperbarui Pada',
            'creator'     => 'Pembuat',
        ],

        'actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Produk berhasil dipulihkan',
                    'body'  => 'Produk telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Produk berhasil dihapus',
                    'body'  => 'Produk telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Produk berhasil dihapus permanen',
                        'body'  => 'Produk telah berhasil dihapus secara permanen.',
                    ],

                    'error' => [
                        'title' => 'Produk tidak dapat dihapus',
                        'body'  => 'Produk tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'print' => [
                'label' => 'Cetak Label',

                'form' => [
                    'fields' => [
                        'quantity' => 'Jumlah Label',
                        'format'   => 'Format',

                        'format-options' => [
                            'dymo'       => 'Dymo',
                            '2x7_price'  => '2x7 dengan harga',
                            '4x7_price'  => '4x7 dengan harga',
                            '4x12'       => '4x12',
                            '4x12_price' => '4x12 dengan harga',
                        ],
                    ],
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Produk berhasil dipulihkan',
                    'body'  => 'Produk telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Produk berhasil dihapus',
                    'body'  => 'Produk telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Produk berhasil dihapus permanen',
                        'body'  => 'Produk telah berhasil dihapus secara permanen.',
                    ],

                    'error' => [
                        'title' => 'Produk tidak dapat dihapus',
                        'body'  => 'Produk tidak dapat dihapus karena sedang digunakan.',
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
                    'name'             => 'Nama',
                    'name-placeholder' => 'mis. Kaos',
                    'description'      => 'Deskripsi',
                    'tags'             => 'Tag',
                ],
            ],

            'images' => [
                'title' => 'Gambar',

                'entries' => [],
            ],

            'settings' => [
                'title' => 'Pengaturan',

                'entries' => [
                    'type'      => 'Jenis',
                    'reference' => 'Referensi',
                    'barcode'   => 'Barcode',
                    'category'  => 'Kategori',
                    'company'   => 'Perusahaan',
                ],
            ],

            'pricing' => [
                'title' => 'Harga',

                'entries' => [
                    'price' => 'Harga',
                    'cost'  => 'Biaya',
                ],
            ],

            'inventory' => [
                'title' => 'Inventaris',

                'fieldsets' => [
                    'logistics' => [
                        'title' => 'Logistik',

                        'entries' => [
                            'weight' => 'Berat',
                            'volume' => 'Volume',
                        ],
                    ],
                ],
            ],

            'record-information' => [
                'title' => 'Informasi Data',

                'entries' => [
                    'created-at' => 'Dibuat Pada',
                    'created-by' => 'Dibuat Oleh',
                    'updated-at' => 'Diperbarui Pada',
                ],
            ],
        ],
    ],
];
