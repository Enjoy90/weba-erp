<?php

return [
    'title' => 'Template Penawaran',

    'navigation' => [
        'title'  => 'Template Penawaran',
        'group'  => 'Pesanan Penjualan',
    ],

    'form' => [
        'tabs' => [
            'products' => [
                'title'  => 'Produk',
                'fields' => [
                    'products'     => 'Produk',
                    'name'         => 'Nama',
                    'quantity'     => 'Jumlah',
                ],
            ],

            'terms-and-conditions' => [
                'title'  => 'Syarat & Ketentuan',
                'fields' => [
                    'note-placeholder' => 'Tulis syarat dan ketentuan Anda untuk penawaran.',
                ],
            ],
        ],

        'sections' => [
            'general' => [
                'title' => 'Informasi Umum',

                'fields' => [
                    'name'               => 'Nama',
                    'quotation-validity' => 'Masa Berlaku Penawaran',
                    'sale-journal'       => 'Jurnal Penjualan',
                ],
            ],

            'signature-and-payment' => [
                'title' => 'Tanda Tangan & Pembayaran',

                'fields' => [
                    'online-signature'      => 'Tanda Tangan Online',
                    'online-payment'        => 'Pembayaran Online',
                    'prepayment-percentage' => 'Persentase Pembayaran di Muka',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'created-by'            => 'Dibuat oleh',
            'company'               => 'Perusahaan',
            'name'                  => 'Nama',
            'number-of-days'        => 'Jumlah hari',
            'journal'               => 'Jurnal Penjualan',
            'signature-required'    => 'Wajib Tanda Tangan',
            'payment-required'      => 'Wajib Pembayaran',
            'prepayment-percentage' => 'Persentase Pembayaran di Muka',
        ],
        'groups'  => [
            'company' => 'Perusahaan',
            'name'    => 'Nama',
            'journal' => 'Jurnal',
        ],
        'filters' => [
            'created-by' => 'Dibuat oleh',
            'company'    => 'Perusahaan',
            'name'       => 'Nama',
            'created-at' => 'Dibuat pada',
            'updated-at' => 'Diperbarui pada',
        ],
        'actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Template penawaran berhasil dihapus',
                    'body'  => 'Template penawaran telah berhasil dihapus.',
                ],
            ],

        ],
        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Template penawaran berhasil dihapus',
                    'body'  => 'Template penawaran telah berhasil dihapus.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'tabs' => [
            'products' => [
                'title' => 'Produk',
            ],
            'terms-and-conditions' => [
                'title' => 'Syarat & Ketentuan',
            ],
        ],
        'sections' => [
            'general' => [
                'title' => 'Informasi Umum',
            ],
            'signature_and_payment' => [
                'title' => 'Tanda Tangan & Pembayaran',
            ],
        ],
        'entries' => [
            'product'               => 'Produk',
            'description'           => 'Deskripsi',
            'quantity'              => 'Jumlah',
            'unit-price'            => 'Harga Satuan',
            'section-name'          => 'Nama Bagian',
            'note-title'            => 'Judul Catatan',
            'name'                  => 'Nama Template',
            'quotation-validity'    => 'Masa Berlaku Penawaran',
            'sale-journal'          => 'Jurnal Penjualan',
            'online-signature'      => 'Tanda Tangan Online',
            'online-payment'        => 'Pembayaran Online',
            'prepayment-percentage' => 'Persentase Pembayaran di Muka',
        ],
    ],
];
