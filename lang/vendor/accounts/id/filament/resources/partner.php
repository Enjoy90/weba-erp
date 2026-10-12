<?php

return [
    'title' => 'Mitra',

    'navigation' => [
        'title' => 'Mitra',
    ],

    'form' => [
        'tabs' => [
            'sales-purchases' => [
                'fieldsets' => [
                    'sales' => [
                        'title' => 'Penjualan',

                        'fields' => [
                            'sales-person'   => 'Tenaga Penjual',
                            'payment-terms'  => 'Termin Pembayaran',
                            'payment-method' => 'Metode Pembayaran',
                        ],
                    ],

                    'purchase' => [
                        'title' => 'Pembelian',

                        'fields' => [
                            'payment-terms'  => 'Termin Pembayaran',
                            'payment-method' => 'Metode Pembayaran',
                        ],
                    ],

                    'fiscal-information' => [
                        'title' => 'Informasi Fiskal',

                        'fields' => [
                            'fiscal-position'    => 'Posisi Fiskal',
                        ],
                    ],
                ],
            ],

            'invoicing' => [
                'title'  => 'Faktur',

                'fieldsets' => [
                    'customer-invoices' => [
                        'title' => 'Faktur Pelanggan',

                        'fields' => [
                            'invoice-sending-method'   => 'Metode Pengiriman Faktur',
                            'invoice-edi-format-store' => 'Format eFaktur',
                            'peppol-eas'               => 'Alamat Peppol',
                            'endpoint'                 => 'Endpoint',
                        ],
                    ],

                    'accounting-entries' => [
                        'title' => 'Entri Akuntansi',

                        'fields' => [
                            'account-receivable' => 'Akun Piutang',
                            'account-payable'    => 'Akun Utang',
                        ],
                    ],

                    'automation' => [
                        'title' => 'Otomatisasi',

                        'fields' => [
                            'auto-post-bills'                => 'Posting Tagihan Otomatis',
                            'ignore-abnormal-invoice-amount' => 'Abaikan Jumlah Faktur Tidak Wajar',
                            'ignore-abnormal-invoice-date'   => 'Abaikan Tanggal Faktur Tidak Wajar',
                        ],
                    ],
                ],
            ],

            'internal-notes' => [
                'title' => 'Catatan Internal',
            ],
        ],
    ],

    'infolist' => [

        'tabs' => [
            'sales-purchases' => [
                'fieldsets' => [
                    'sales' => [
                        'title' => 'Penjualan',

                        'entries' => [
                            'sales-person'   => 'Tenaga Penjual',
                            'payment-terms'  => 'Termin Pembayaran',
                            'payment-method' => 'Metode Pembayaran',
                        ],
                    ],

                    'purchase' => [
                        'title' => 'Pembelian',

                        'entries' => [
                            'payment-terms'  => 'Termin Pembayaran',
                            'payment-method' => 'Metode Pembayaran',
                        ],
                    ],

                    'fiscal-information' => [
                        'title' => 'Informasi Fiskal',

                        'entries' => [
                            'fiscal-position'    => 'Posisi Fiskal',
                        ],
                    ],
                ],
            ],

            'invoicing' => [
                'title'  => 'Faktur',

                'fieldsets' => [
                    'customer-invoices' => [
                        'title' => 'Faktur Pelanggan',

                        'entries' => [
                            'invoice-sending-method'   => 'Metode Pengiriman Faktur',
                            'invoice-edi-format-store' => 'Format eFaktur',
                            'peppol-eas'               => 'Alamat Peppol',
                            'endpoint'                 => 'Endpoint',
                        ],
                    ],

                    'accounting-entries' => [
                        'title' => 'Entri Akuntansi',

                        'entries' => [
                            'account-receivable' => 'Akun Piutang',
                            'account-payable'    => 'Akun Utang',
                        ],
                    ],

                    'automation' => [
                        'title' => 'Otomatisasi',

                        'entries' => [
                            'auto-post-bills'                => 'Posting Tagihan Otomatis',
                            'ignore-abnormal-invoice-amount' => 'Abaikan Jumlah Faktur Tidak Wajar',
                            'ignore-abnormal-invoice-date'   => 'Abaikan Tanggal Faktur Tidak Wajar',
                        ],
                    ],
                ],
            ],

            'internal-notes' => [
                'title' => 'Catatan Internal',
            ],
        ],
    ],
];
