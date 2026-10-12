<?php

return [
    'title' => 'Tagihan',

    'navigation' => [
        'title' => 'Tagihan',
        'group' => 'Faktur',
    ],

    'global-search' => [
        'vendor'   => 'Pemasok',
        'date'     => 'Tanggal',
        'due-date' => 'Tanggal Jatuh Tempo',
    ],

    'form' => [
        'section' => [
            'general' => [
                'title'  => 'Umum',
                'fields' => [
                    'vendor-bill'       => 'Tagihan Pemasok',
                    'vendor'            => 'Pemasok',
                    'bill-date'         => 'Tanggal Tagihan',
                    'bill-reference'    => 'Referensi Tagihan',
                    'accounting-date'   => 'Tanggal Akuntansi',
                    'payment-reference' => 'Referensi Pembayaran',
                    'recipient-bank'    => 'Bank Penerima',
                    'due-date'          => 'Tanggal Jatuh Tempo',
                    'payment-term'      => 'Termin Pembayaran',
                    'journal'           => 'Jurnal',
                    'currency'          => 'Mata Uang',
                ],
            ],
        ],

        'tabs' => [
            'invoice-lines' => [
                'title' => 'Baris Tagihan',

                'repeater' => [
                    'products' => [
                        'title'       => 'Produk',
                        'add-product' => 'Tambah Produk',

                        'columns' => [
                            'product'             => 'Produk',
                            'quantity'            => 'Jumlah',
                            'unit'                => 'Satuan',
                            'taxes'               => 'Pajak',
                            'discount-percentage' => 'Diskon (%)',
                            'unit-price'          => 'Harga Satuan',
                            'sub-total'           => 'Subtotal',
                        ],

                        'fields' => [
                            'product'             => 'Produk',
                            'quantity'            => 'Jumlah',
                            'unit'                => 'Satuan',
                            'taxes'               => 'Pajak',
                            'discount-percentage' => 'Diskon (%)',
                            'unit-price'          => 'Harga Satuan',
                            'sub-total'           => 'Subtotal',
                        ],
                    ],
                ],
            ],

            'other-information' => [
                'title'    => 'Informasi Lainnya',

                'fieldset' => [
                    'accounting' => [
                        'title' => 'Akuntansi',

                        'fields' => [
                            'company'                 => 'Perusahaan',
                            'incoterm'                => 'Incoterm',
                            'incoterm-location'       => 'Lokasi Incoterm',
                            'payment-method'          => 'Metode Pembayaran',
                            'fiscal-position'         => 'Posisi Fiskal',
                            'fiscal-position-tooltip' => 'Posisi fiskal digunakan untuk menyesuaikan pajak dan akun berdasarkan lokasi pelanggan.',
                            'cash-rounding'           => 'Metode Pembulatan Kas',
                            'cash-rounding-tooltip'   => 'Menentukan satuan terkecil mata uang yang dapat dibayar tunai.',
                            'auto-post'               => 'Posting Otomatis',
                            'checked'                 => 'Diperiksa',
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
        'total'   => 'Total',
        'columns' => [
            'number'           => 'Nomor',
            'state'            => 'Status',
            'customer'         => 'Pemasok',
            'bill-date'        => 'Tanggal Tagihan',
            'checked'          => 'Diperiksa',
            'accounting-date'  => 'Akuntansi',
            'due-date'         => 'Tanggal Jatuh Tempo',
            'source-document'  => 'Dokumen Sumber',
            'reference'        => 'Referensi',
            'sales-person'     => 'Tenaga Penjual',
            'tax-excluded'     => 'Tanpa Pajak',
            'tax'              => 'Pajak',
            'total'            => 'Total',
            'amount-due'       => 'Jumlah Terutang',
            'bill-currency'    => 'Mata Uang Tagihan',
        ],

        'summarizers' => [
            'total' => 'Total',
        ],

        'groups' => [
            'name'                         => 'Nama',
            'bill-partner-display-name'    => 'Nama Tampilan Mitra Tagihan',
            'bill-date'                    => 'Tanggal Tagihan',
            'checked'                      => 'Diperiksa',
            'date'                         => 'Tanggal',
            'bill-due-date'                => 'Tanggal Jatuh Tempo Tagihan',
            'bill-origin'                  => 'Asal Tagihan',
            'sales-person'                 => 'Tenaga Penjual',
            'currency'                     => 'Mata Uang',
            'created-at'                   => 'Dibuat pada',
            'updated-at'                   => 'Diperbarui pada',
        ],

        'filters' => [
            'number'                    => 'Nomor',
            'bill-partner-display-name' => 'Nama Tampilan Mitra Tagihan',
            'bill-date'                 => 'Tanggal Tagihan',
            'bill-due-date'             => 'Tanggal Jatuh Tempo Tagihan',
            'bill-origin'               => 'Asal Tagihan',
            'reference'                 => 'Referensi',
            'payment-reference'         => 'Referensi Pembayaran',
            'narration'                 => 'Keterangan',
            'partner'                   => 'Mitra',
            'journal'                   => 'Jurnal',
            'fiscal-position'           => 'Posisi Fiskal',
            'currency'                  => 'Mata Uang',
            'company'                   => 'Perusahaan',
            'date'                      => 'Tanggal Akuntansi',
            'delivery-date'             => 'Tanggal Pengiriman',
            'amount-untaxed'            => 'Nilai Sebelum Pajak',
            'amount-tax'                => 'Nilai Pajak',
            'amount-total'              => 'Nilai Total',
            'amount-residual'           => 'Jumlah Terutang',
            'checked'                   => 'Diperiksa',
            'posted-before'             => 'Pernah Diposting',
            'is-move-sent'              => 'Terkirim',
            'created-at'                => 'Dibuat pada',
            'updated-at'                => 'Diperbarui pada',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Tagihan berhasil dihapus',
                    'body'  => 'Tagihan telah berhasil dihapus.',
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Tagihan berhasil dihapus',
                    'body'  => 'Tagihan-tagihan tersebut telah berhasil dihapus.',
                ],
            ],
        ],

        'toolbar-actions' => [
            'export' => [
                'label' => 'Ekspor',
            ],
        ],
    ],

    'infolist' => [
        'section' => [
            'general' => [
                'title'   => 'Umum',

                'entries' => [
                    'vendor-invoice'    => 'Tagihan Pemasok',
                    'vendor'            => 'Pemasok',
                    'bill-date'         => 'Tanggal Tagihan',
                    'bill-reference'    => 'Referensi Tagihan',
                    'accounting-date'   => 'Tanggal Akuntansi',
                    'payment-reference' => 'Referensi Pembayaran',
                    'recipient-bank'    => 'Bank Penerima',
                    'due-date'          => 'Tanggal Jatuh Tempo',
                    'payment-term'      => 'Termin Pembayaran',
                    'journal'           => 'Jurnal',
                    'currency'          => 'Mata Uang',
                ],
            ],
        ],

        'tabs' => [
            'invoice-lines' => [
                'title' => 'Baris Tagihan',

                'repeater' => [
                    'products' => [
                        'title'       => 'Produk',
                        'add-product' => 'Tambah Produk',

                        'entries' => [
                            'product'             => 'Produk',
                            'quantity'            => 'Jumlah',
                            'unit'                => 'Satuan',
                            'taxes'               => 'Pajak',
                            'discount-percentage' => 'Diskon (%)',
                            'unit-price'          => 'Harga Satuan',
                            'sub-total'           => 'Subtotal',
                        ],
                    ],
                ],
            ],

            'other-information' => [
                'title'    => 'Informasi Lainnya',
                'fieldset' => [
                    'accounting' => [
                        'title' => 'Akuntansi',

                        'entries' => [
                            'company'           => 'Perusahaan',
                            'incoterm'          => 'Incoterm',
                            'incoterm-location' => 'Lokasi Incoterm',
                            'payment-method'    => 'Metode Pembayaran',
                            'checked'           => 'Diperiksa',
                            'fiscal-position'   => 'Posisi Fiskal',
                            'cash-rounding'     => 'Metode Pembulatan Kas',
                            'checked'           => 'Diperiksa',
                        ],
                    ],
                ],
            ],

            'term-and-conditions' => [
                'title' => 'Syarat & Ketentuan',
            ],

            'journal-items' => [
                'title' => 'Item Jurnal',

                'repeater' => [
                    'entries' => [
                        'account'  => 'Akun',
                        'partner'  => 'Mitra',
                        'label'    => 'Label',
                        'due-date' => 'Tanggal Jatuh Tempo',
                        'currency' => 'Mata Uang',
                        'taxes'    => 'Pajak',
                        'debit'    => 'Debit',
                        'credit'   => 'Kredit',
                    ],
                ],
            ],
        ],
    ],
];
