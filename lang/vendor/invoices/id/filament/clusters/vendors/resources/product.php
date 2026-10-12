<?php

return [
    'navigation' => [
        'title' => 'Produk',
        'group' => 'Inventaris',
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
                    'sales'            => 'Penjualan',
                    'purchase'         => 'Pembelian',
                ],
            ],

            'invoice-policy' => [
                'title'            => 'Kebijakan Faktur',
                'ordered-policy'   => 'Anda dapat membuat faktur untuk barang sebelum barang dikirim.',
                'delivered-policy' => 'Buat faktur setelah pengiriman, berdasarkan jumlah yang dikirim, bukan yang dipesan.',
            ],

            'images' => [
                'title' => 'Gambar',
            ],

            'settings' => [
                'title' => 'Pengaturan',

                'fields' => [
                    'type'      => 'Jenis',
                    'reference' => 'Referensi',
                    'barcode'   => 'Barcode',
                    'category'  => 'Kategori',
                    'company'   => 'Perusahaan',
                ],
            ],

            'category-and-tags' => [
                'title' => 'Kategori & Tag',

                'fields' => [
                    'category' => 'Kategori',
                    'tags'     => 'Tag',
                ],
            ],

            'pricing' => [
                'title' => 'Harga',

                'fields' => [
                    'price' => 'Harga',
                    'cost'  => 'Biaya',
                ],
            ],

            'additional' => [
                'title' => 'Tambahan',
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'        => 'Nama',
            'images'      => 'Gambar',
            'type'        => 'Jenis',
            'reference'   => 'Referensi',
            'responsible' => 'Penanggung Jawab',
            'barcode'     => 'Barcode',
            'category'    => 'Kategori',
            'company'     => 'Perusahaan',
            'price'       => 'Harga',
            'cost'        => 'Biaya',
            'tags'        => 'Tag',
            'deleted-at'  => 'Dihapus pada',
            'created-at'  => 'Dibuat pada',
            'updated-at'  => 'Diperbarui pada',
        ],

        'groups' => [
            'type'       => 'Jenis',
            'category'   => 'Kategori',
            'created-at' => 'Dibuat pada',
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
            'created-at'  => 'Dibuat pada',
            'updated-at'  => 'Diperbarui pada',
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
                    'title' => 'Produk berhasil dihapus permanen',
                    'body'  => 'Produk telah berhasil dihapus permanen.',
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Produk berhasil dipulihkan',
                    'body'  => 'Produk yang dipilih telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Produk berhasil dihapus',
                    'body'  => 'Produk yang dipilih telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Produk berhasil dihapus permanen',
                    'body'  => 'Produk yang dipilih telah berhasil dihapus permanen.',
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

                'entries' => [],

                'fieldsets' => [
                    'tracking' => [
                        'title' => 'Pelacakan',

                        'entries' => [
                            'track-inventory' => 'Lacak Inventaris',
                            'track-by'        => 'Lacak Berdasarkan',
                            'expiration-date' => 'Tanggal Kedaluwarsa',
                        ],
                    ],

                    'operation' => [
                        'title' => 'Operasi',

                        'entries' => [
                            'routes' => 'Rute',
                        ],
                    ],

                    'logistics' => [
                        'title' => 'Logistik',

                        'entries' => [
                            'responsible' => 'Penanggung Jawab',
                            'weight'      => 'Berat',
                            'volume'      => 'Volume',
                            'sale-delay'  => 'Waktu Tunggu Pelanggan (Hari)',
                        ],
                    ],

                    'traceability' => [
                        'title' => 'Ketertelusuran',

                        'entries' => [
                            'expiration-date'  => 'Tanggal Kedaluwarsa (Hari)',
                            'best-before-date' => 'Tanggal Baik Digunakan Sebelum (Hari)',
                            'removal-date'     => 'Tanggal Penarikan (Hari)',
                            'alert-date'       => 'Tanggal Peringatan (Hari)',
                        ],
                    ],
                ],
            ],

            'record-information' => [
                'title' => 'Informasi Data',

                'entries' => [
                    'created-at' => 'Dibuat pada',
                    'created-by' => 'Dibuat oleh',
                    'updated-at' => 'Diperbarui pada',
                ],
            ],
        ],
    ],
];
