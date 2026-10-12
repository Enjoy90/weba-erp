<?php

return [
    'title' => 'Penawaran',

    'navigation' => [
        'title' => 'Penawaran',
    ],

    'global-search' => [
        'customer'  => 'Pelanggan',
        'reference' => 'Referensi',
        'amount'    => 'Nilai',
    ],

    'form' => [
        'section' => [
            'general' => [
                'title'  => 'Umum',
                'fields' => [
                    'customer'       => 'Pelanggan',
                    'expiration'     => 'Kedaluwarsa',
                    'quotation-date' => 'Tanggal Penawaran',
                    'order-date'     => 'Tanggal Pesanan',
                    'payment-term'   => 'Termin Pembayaran',
                    'price-list'     => 'Daftar Harga',
                ],
            ],
        ],

        'tabs' => [
            'order-line' => [
                'title' => 'Baris Pesanan',

                'repeater' => [
                    'products' => [
                        'title'       => 'Produk',
                        'add-product' => 'Tambah Produk',

                        'columns'     => [
                            'product'                    => 'Produk',
                            'product-variants'           => 'Varian Produk',
                            'product-simple'             => 'Produk Sederhana',
                            'quantity'                   => 'Jumlah',
                            'insufficient-stock-tooltip' => 'Stok tidak cukup untuk memenuhi permintaan ini.',
                            'uom'                        => 'Satuan',
                            'lead-time'                  => 'Waktu Tunggu',
                            'qty-delivered'              => 'Terkirim',
                            'qty-invoiced'               => 'Difakturkan',
                            'packaging-qty'              => 'Jumlah Kemasan',
                            'packaging'                  => 'Kemasan',
                            'unit-price'                 => 'Harga Satuan',
                            'cost'                       => 'Biaya',
                            'margin'                     => 'Margin',
                            'taxes'                      => 'Pajak',
                            'amount'                     => 'Nilai',
                            'margin-percentage'          => 'Margin (%)',
                            'discount-percentage'        => 'Diskon (%)',
                        ],

                        'fields'      => [
                            'product'             => 'Produk',
                            'product-variants'    => 'Varian Produk',
                            'product-simple'      => 'Produk Sederhana',
                            'quantity'            => 'Jumlah',
                            'uom'                 => 'Satuan Ukur',
                            'lead-time'           => 'Waktu Tunggu',
                            'qty-delivered'       => 'Jumlah Terkirim',
                            'qty-invoiced'        => 'Jumlah Difakturkan',
                            'packaging-qty'       => 'Jumlah Kemasan',
                            'packaging'           => 'Kemasan',
                            'unit-price'          => 'Harga Satuan',
                            'cost'                => 'Biaya',
                            'margin'              => 'Margin',
                            'taxes'               => 'Pajak',
                            'amount'              => 'Nilai',
                            'margin-percentage'   => 'Margin (%)',
                            'discount-percentage' => 'Diskon (%)',
                        ],

                        'notifications' => [
                            'quantity-below-delivered' => [
                                'title' => 'Jumlah Tidak Dapat Dikurangi',
                                'body'  => 'Anda tidak dapat mengurangi jumlah di bawah jumlah yang sudah terkirim (:qty).',
                            ],
                        ],

                        'delete-action' => [
                            'error' => [
                                'title' => 'Produk Tidak Dapat Dihapus',
                                'body'  => 'Produk tidak dapat dihapus dari pesanan penjualan yang sudah dikonfirmasi.',
                            ],
                        ],

                        'actions' => [
                            'open-product' => [
                                'tooltip' => 'Buka produk',
                            ],
                        ],
                    ],

                    'product-optional' => [
                        'title'       => 'Produk Opsional',
                        'add-product' => 'Tambah Produk',

                        'columns' => [
                            'product'             => 'Produk',
                            'description'         => 'Deskripsi',
                            'quantity'            => 'Jumlah',
                            'uom'                 => 'Satuan Ukur',
                            'unit-price'          => 'Harga Satuan',
                            'discount-percentage' => 'Diskon (%)',
                        ],

                        'fields'      => [
                            'product'             => 'Produk',
                            'description'         => 'Deskripsi',
                            'quantity'            => 'Jumlah',
                            'uom'                 => 'Satuan Ukur',
                            'unit-price'          => 'Harga Satuan',
                            'discount-percentage' => 'Diskon (%)',

                            'actions' => [
                                'tooltip' => [
                                    'add-order-line' => 'Tambah Baris Pesanan',
                                    'already-added'  => 'Sudah Ditambahkan ke Pesanan',
                                ],

                                'notifications' => [
                                    'product-added' => [
                                        'title' => 'Produk berhasil ditambahkan',
                                        'body'  => 'Produk telah berhasil ditambahkan.',
                                    ],

                                    'product-not-found' => [
                                        'title' => 'Produk Tidak Ditemukan',
                                    ],

                                    'product-already-exists' => [
                                        'title' => 'Produk Sudah Ada',
                                        'body'  => 'Produk ini sudah ada di baris pesanan. Silakan perbarui baris yang sudah ada.',
                                    ],

                                    'missing-product-data' => [
                                        'title' => 'Data Produk Tidak Lengkap',
                                        'body'  => 'Produk yang dipilih tidak dapat diproses.',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'other-information' => [
                'title' => 'Informasi Lainnya',

                'fieldset' => [
                    'sales' => [
                        'title' => 'Penjualan',

                        'fields' => [
                            'sales-person'       => 'Tenaga Penjual',
                            'customer-reference' => 'Referensi Pelanggan',
                            'tags'               => 'Tag',
                        ],
                    ],

                    'shipping' => [
                        'title'  => 'Pengiriman',
                        'fields' => [
                            'warehouse'       => 'Gudang',
                            'commitment-date' => 'Tanggal Pengiriman',
                        ],
                    ],

                    'tracking' => [
                        'title'  => 'Pelacakan',
                        'fields' => [
                            'source-document' => 'Dokumen Sumber',
                            'medium'          => 'Medium',
                            'source'          => 'Sumber',
                            'campaign'        => 'Kampanye',
                        ],
                    ],

                    'additional-information' => [
                        'title' => 'Informasi Tambahan',

                        'fields' => [
                            'company'    => 'Perusahaan',
                            'currency'   => 'Mata Uang',
                        ],
                    ],
                ],
            ],

            'term-and-conditions' => [
                'title' => 'Syarat & Ketentuan',
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'number'             => 'Nomor',
            'status'             => 'Status',
            'delivery-status'    => 'Status Pengiriman',
            'invoice-status'     => 'Status Faktur',
            'creation-date'      => 'Tanggal Dibuat',
            'commitment-date'    => 'Tanggal Komitmen',
            'expected-date'      => 'Tanggal Perkiraan',
            'customer'           => 'Pelanggan',
            'sales-person'       => 'Tenaga Penjual',
            'sales-team'         => 'Tim Penjualan',
            'untaxed-amount'     => 'Nilai Sebelum Pajak',
            'amount-tax'         => 'Nilai Pajak',
            'amount-total'       => 'Nilai Total',
            'customer-reference' => 'Referensi Pelanggan',
        ],

        'summarizers' => [
            'total'        => 'Total',
            'taxes'        => 'Pajak',
            'total-amount' => 'Nilai Total',
        ],

        'filters' => [
            'sales-person'     => 'Tenaga Penjual',
            'utm-source'       => 'Sumber UTM',
            'company'          => 'Perusahaan',
            'customer'         => 'Pelanggan',
            'journal'          => 'Jurnal',
            'invoice-address'  => 'Alamat Penagihan',
            'shipping-address' => 'Alamat Pengiriman',
            'fiscal-position'  => 'Posisi Fiskal',
            'payment-term'     => 'Termin Pembayaran',
            'currency'         => 'Mata Uang',
            'created-at'       => 'Dibuat pada',
            'updated-at'       => 'Diperbarui pada',
        ],

        'groups' => [
            'medium'          => 'Medium',
            'source'          => 'Sumber',
            'team'            => 'Tim',
            'sales-person'    => 'Tenaga Penjual',
            'currency'        => 'Mata Uang',
            'company'         => 'Perusahaan',
            'customer'        => 'Pelanggan',
            'quotation-date'  => 'Tanggal Penawaran',
            'commitment-date' => 'Tanggal Komitmen',
        ],

        'actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Penawaran berhasil dipulihkan',
                    'body'  => 'Penawaran telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Penawaran berhasil dihapus',
                    'body'  => 'Penawaran telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Penawaran berhasil dihapus permanen',
                    'body'  => 'Penawaran telah berhasil dihapus permanen.',
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Penawaran berhasil dipulihkan',
                    'body'  => 'Penawaran yang dipilih telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Penawaran berhasil dihapus',
                    'body'  => 'Penawaran yang dipilih telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Penawaran berhasil dihapus permanen',
                    'body'  => 'Penawaran yang dipilih telah berhasil dihapus permanen.',
                ],
            ],
        ],

        'empty-state-action' => [
            'create' => [
                'notification' => [
                    'title' => 'Penawaran berhasil dibuat',
                    'body'  => 'Penawaran telah berhasil dibuat.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'section' => [
            'general' => [
                'title'   => 'Umum',
                'entries' => [
                    'sale-order'     => 'Pesanan Penjualan',
                    'customer'       => 'Pelanggan',
                    'expiration'     => 'Kedaluwarsa',
                    'quotation-date' => 'Tanggal Penawaran',
                    'payment-term'   => 'Termin Pembayaran',
                ],
            ],
        ],

        'tabs' => [
            'order-line' => [
                'title' => 'Baris Pesanan',

                'repeater' => [
                    'products' => [
                        'title'       => 'Produk',
                        'add-product' => 'Tambah Produk',
                        'entries'     => [
                            'product'             => 'Produk',
                            'product-variants'    => 'Varian Produk',
                            'product-simple'      => 'Produk Sederhana',
                            'quantity'            => 'Jumlah',
                            'qty-delivered'       => 'Terkirim',
                            'qty-invoiced'        => 'Difakturkan',
                            'uom'                 => 'Satuan',
                            'lead-time'           => 'Waktu Tunggu',
                            'packaging-qty'       => 'Jumlah Kemasan',
                            'packaging'           => 'Kemasan',
                            'unit-price'          => 'Harga Satuan',
                            'cost'                => 'Biaya',
                            'margin'              => 'Margin',
                            'taxes'               => 'Pajak',
                            'amount'              => 'Nilai',
                            'margin-percentage'   => 'Margin (%)',
                            'discount-percentage' => 'Diskon (%)',
                            'sub-total'           => 'Subtotal',
                        ],
                    ],

                    'product-optional' => [
                        'title'       => 'Produk Opsional',
                        'add-product' => 'Tambah Produk',
                        'entries'     => [
                            'product'             => 'Produk',
                            'description'         => 'Deskripsi',
                            'quantity'            => 'Jumlah',
                            'uom'                 => 'Satuan Ukur',
                            'unit-price'          => 'Harga Satuan',
                            'discount-percentage' => 'Diskon (%)',
                            'sub-total'           => 'Subtotal',

                            'actions' => [
                                'tooltip' => [
                                    'add-order-line' => 'Tambah Baris Pesanan',
                                ],

                                'notifications' => [
                                    'product-added' => [
                                        'title' => 'Produk berhasil ditambahkan',
                                        'body'  => 'Produk telah berhasil ditambahkan.',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'other-information' => [
                'title' => 'Informasi Lainnya',

                'fieldset' => [
                    'sales' => [
                        'title' => 'Penjualan',

                        'entries' => [
                            'sales-person'       => 'Tenaga Penjual',
                            'customer-reference' => 'Referensi Pelanggan',
                            'tags'               => 'Tag',
                        ],
                    ],

                    'shipping' => [
                        'title'   => 'Pengiriman',
                        'entries' => [
                            'commitment-date' => 'Tanggal Pengiriman',
                        ],
                    ],

                    'tracking' => [
                        'title'   => 'Pelacakan',
                        'entries' => [
                            'source-document' => 'Dokumen Sumber',
                            'medium'          => 'Medium',
                            'source'          => 'Sumber',
                            'campaign'        => 'Kampanye',
                        ],
                    ],

                    'additional-information' => [
                        'title' => 'Informasi Tambahan',

                        'entries' => [
                            'company'  => 'Perusahaan',
                            'currency' => 'Mata Uang',
                        ],
                    ],
                ],
            ],

            'term-and-conditions' => [
                'title' => 'Syarat & Ketentuan',
            ],
        ],
    ],
];
