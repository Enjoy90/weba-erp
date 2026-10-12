<?php

return [
    'global-search' => [
        'vendor'    => 'Pemasok',
        'reference' => 'Referensi',
        'amount'    => 'Nilai',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title' => 'Umum',

                'fields' => [
                    'vendor'                   => 'Pemasok',
                    'vendor-reference'         => 'Referensi Pemasok',
                    'vendor-reference-tooltip' => 'Nomor referensi pesanan penjualan atau penawaran dari pemasok. Dipakai untuk pencocokan saat menerima produk, karena referensi ini biasanya dicantumkan pada surat jalan pemasok.',
                    'agreement'                => 'Perjanjian',
                    'currency'                 => 'Mata Uang',
                    'confirmation-date'        => 'Tanggal Konfirmasi',
                    'order-deadline'           => 'Tenggat Pesanan',
                    'expected-arrival'         => 'Perkiraan Kedatangan',
                    'confirmed-by-vendor'      => 'Dikonfirmasi oleh Pemasok',
                    'deliver-to'               => 'Kirim Ke',
                ],
            ],
        ],

        'tabs' => [
            'products' => [
                'title' => 'Produk',

                'repeater' => [
                    'products' => [
                        'title'            => 'Produk',
                        'add-product-line' => 'Tambah Produk',

                        'fields' => [
                            'product'             => 'Produk',
                            'expected-arrival'    => 'Perkiraan Kedatangan',
                            'quantity'            => 'Jumlah',
                            'received'            => 'Diterima',
                            'billed'              => 'Ditagih',
                            'unit'                => 'Satuan',
                            'packaging-qty'       => 'Jumlah Kemasan',
                            'packaging'           => 'Kemasan',
                            'taxes'               => 'Pajak',
                            'discount-percentage' => 'Diskon (%)',
                            'unit-price'          => 'Harga Satuan',
                            'amount'              => 'Nilai',
                        ],

                        'notifications' => [
                            'quantity-below-received' => [
                                'title' => 'Jumlah Tidak Dapat Dikurangi',
                                'body'  => 'Jumlah tidak dapat dikurangi di bawah jumlah yang sudah diterima (:qty).',
                            ],

                            'blanket-order-qty-limit' => [
                                'title' => 'Jumlah Melebihi Batas Blanket Order',
                                'body'  => 'Jumlah produk (:product_qty) melebihi jumlah yang tersedia (:available_qty) pada blanket order.',
                            ],
                        ],

                        'columns' => [
                            'product'             => 'Produk',
                            'expected-arrival'    => 'Perkiraan Kedatangan',
                            'quantity'            => 'Jumlah',
                            'received'            => 'Diterima',
                            'billed'              => 'Ditagih',
                            'unit'                => 'Satuan',
                            'packaging-qty'       => 'Jumlah Kemasan',
                            'packaging'           => 'Kemasan',
                            'taxes'               => 'Pajak',
                            'discount-percentage' => 'Diskon (%)',
                            'unit-price'          => 'Harga Satuan',
                            'amount'              => 'Nilai',
                        ],

                        'delete-action' => [
                            'error' => [
                                'title' => 'Produk Tidak Dapat Dihapus',
                                'body'  => 'Produk tidak dapat dihapus dari pesanan pembelian yang sudah dikonfirmasi.',
                            ],
                        ],

                        'actions' => [
                            'open-product' => [
                                'tooltip' => 'Buka produk',
                            ],
                        ],
                    ],

                    'section' => [
                        'title' => 'Tambah Bagian',

                        'fields' => [],
                    ],

                    'note' => [
                        'title' => 'Tambah Catatan',

                        'fields' => [],
                    ],
                ],
            ],

            'additional' => [
                'title' => 'Informasi Tambahan',

                'fields' => [
                    'buyer'             => 'Pembeli',
                    'company'           => 'Perusahaan',
                    'source-document'   => 'Dokumen Sumber',
                    'incoterm'          => 'Incoterm',
                    'incoterm-tooltip'  => 'International Commercial Terms (Incoterms) adalah kumpulan istilah perdagangan baku yang dipakai dalam transaksi internasional untuk menetapkan tanggung jawab antara pembeli dan penjual.',
                    'incoterm-location' => 'Lokasi Incoterm',
                    'payment-term'      => 'Termin Pembayaran',
                    'fiscal-position'   => 'Posisi Fiskal',
                ],
            ],

            'terms' => [
                'title' => 'Syarat dan Ketentuan',
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'favorite'         => 'Favorit',
            'priority'         => 'Prioritas',
            'vendor-reference' => 'Referensi Pemasok',
            'reference'        => 'Referensi',
            'vendor'           => 'Pemasok',
            'buyer'            => 'Pembeli',
            'company'          => 'Perusahaan',
            'order-deadline'   => 'Tenggat Pesanan',
            'source-document'  => 'Dokumen Sumber',
            'untaxed-amount'   => 'Nilai Sebelum Pajak',
            'total-amount'     => 'Nilai Total',
            'status'           => 'Status',
            'billing-status'   => 'Status Tagihan',
            'receipt-status'   => 'Status Penerimaan',
            'currency'         => 'Mata Uang',
        ],

        'groups' => [
            'vendor'     => 'Pemasok',
            'buyer'      => 'Pembeli',
            'state'      => 'Status',
            'created-at' => 'Dibuat Pada',
            'updated-at' => 'Diperbarui Pada',
        ],

        'filters' => [
            'status'           => 'Status',
            'vendor-reference' => 'Referensi Pemasok',
            'reference'        => 'Referensi',
            'untaxed-amount'   => 'Nilai Sebelum Pajak',
            'total-amount'     => 'Nilai Total',
            'order-deadline'   => 'Tenggat Pesanan',
            'vendor'           => 'Pemasok',
            'buyer'            => 'Pembeli',
            'company'          => 'Perusahaan',
            'payment-term'     => 'Termin Pembayaran',
            'incoterm'         => 'Incoterm',
            'status'           => 'Status',
            'created-at'       => 'Dibuat Pada',
            'updated-at'       => 'Diperbarui Pada',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Pesanan berhasil dihapus',
                        'body'  => 'Pesanan telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Pesanan tidak dapat dihapus',
                        'body'  => 'Pesanan tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Pesanan berhasil dihapus',
                        'body'  => 'Pesanan telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Pesanan tidak dapat dihapus',
                        'body'  => 'Pesanan tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],
    ],

    'summary' => [
        'tax' => 'Pajak',
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title' => 'Umum',

                'entries' => [
                    'purchase-order'           => 'Pesanan Pembelian',
                    'vendor'                   => 'Pemasok',
                    'vendor-reference'         => 'Referensi Pemasok',
                    'vendor-reference-tooltip' => 'Nomor referensi pesanan penjualan atau penawaran dari pemasok. Dipakai untuk pencocokan saat menerima produk, karena referensi ini biasanya dicantumkan pada surat jalan pemasok.',
                    'agreement'                => 'Perjanjian',
                    'currency'                 => 'Mata Uang',
                    'confirmation-date'        => 'Tanggal Konfirmasi',
                    'order-deadline'           => 'Tenggat Pesanan',
                    'expected-arrival'         => 'Perkiraan Kedatangan',
                    'confirmed-by-vendor'      => 'Dikonfirmasi oleh Pemasok',
                ],
            ],
        ],

        'tabs' => [
            'products' => [
                'title' => 'Produk',

                'repeater' => [
                    'products' => [
                        'title'            => 'Produk',
                        'add-product-line' => 'Tambah Produk',

                        'entries' => [
                            'product'             => 'Produk',
                            'expected-arrival'    => 'Perkiraan Kedatangan',
                            'quantity'            => 'Jumlah',
                            'received'            => 'Diterima',
                            'billed'              => 'Ditagih',
                            'unit'                => 'Satuan',
                            'packaging-qty'       => 'Jumlah Kemasan',
                            'packaging'           => 'Kemasan',
                            'taxes'               => 'Pajak',
                            'discount-percentage' => 'Diskon (%)',
                            'unit-price'          => 'Harga Satuan',
                            'amount'              => 'Nilai',
                        ],
                    ],

                    'section' => [
                        'title' => 'Tambah Bagian',
                    ],

                    'note' => [
                        'title' => 'Tambah Catatan',
                    ],
                ],
            ],

            'additional' => [
                'title' => 'Informasi Tambahan',

                'entries' => [
                    'buyer'             => 'Pembeli',
                    'company'           => 'Perusahaan',
                    'source-document'   => 'Dokumen Sumber',
                    'incoterm'          => 'Incoterm',
                    'incoterm-tooltip'  => 'International Commercial Terms (Incoterms) adalah kumpulan istilah perdagangan baku yang dipakai dalam transaksi internasional untuk menetapkan tanggung jawab antara pembeli dan penjual.',
                    'incoterm-location' => 'Lokasi Incoterm',
                    'payment-term'      => 'Termin Pembayaran',
                    'fiscal-position'   => 'Posisi Fiskal',
                ],
            ],

            'terms' => [
                'title' => 'Syarat dan Ketentuan',
            ],
        ],
    ],
];
