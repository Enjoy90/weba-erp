<?php

return [
    'table' => [
        'columns' => [
            'reference'         => 'Referensi',
            'total-amount'      => 'Nilai Total',
            'confirmation-date' => 'Tanggal Konfirmasi',
            'status'            => 'Status',
        ],
    ],

    'products' => [
        'columns' => [
            'product'    => 'Produk',
            'quantity'   => 'Jumlah',
            'unit-price' => 'Harga Satuan',
            'taxes'      => 'Pajak',
            'discount'   => 'Diskon %',
            'amount'     => 'Nilai',
        ],
    ],

    'infolist' => [
        'settings' => [
            'entries' => [
                'buyer' => 'Pembeli',
            ],

            'actions' => [
                'accept' => [
                    'label' => 'Terima',

                    'notification' => [
                        'title' => 'Penawaran Diterima',
                        'body'  => 'RFQ telah berhasil diterima.',
                    ],

                    'message' => [
                        'body' => 'RFQ telah diterima oleh pemasok.',
                    ],
                ],

                'decline' => [
                    'label' => 'Tolak',

                    'notification' => [
                        'title' => 'Penawaran Ditolak',
                        'body'  => 'RFQ telah berhasil ditolak.',
                    ],

                    'message' => [
                        'body' => 'RFQ telah ditolak oleh pemasok.',
                    ],
                ],

                'print' => [
                    'label' => 'Unduh/Cetak',
                ],
            ],
        ],

        'general' => [
            'entries' => [
                'purchase-order'        => 'Pesanan Pembelian #:id',
                'quotation'             => 'Permintaan Penawaran #:id',
                'order-date'            => 'Tanggal Pesanan',
                'from'                  => 'Dari',
                'confirmation-date'     => 'Tanggal Konfirmasi',
                'receipt-date'          => 'Tanggal Penerimaan',
                'products'              => 'Produk',
                'untaxed-amount'        => 'Nilai Sebelum Pajak',
                'tax-amount'            => 'Nilai Pajak',
                'total'                 => 'Total',
                'communication-history' => 'Riwayat Komunikasi',
            ],
        ],
    ],
];
