<?php

return [
    'form' => [
        'sections' => [
            'fields' => [
                'payment-term'         => 'Termin Pembayaran',
                'company'              => 'Perusahaan',
                'company-placeholder'  => 'Semua Perusahaan',
                'early-discount'       => 'Diskon Pembayaran Awal',
                'discount-days-prefix' => 'jika dibayar dalam',
                'discount-days-suffix' => 'hari',
                'reduced-tax'          => 'Pajak dikurangi',
                'note'                 => 'Catatan',
                'status'               => 'Status',
            ],
        ],

        'tabs' => [
            'due-terms' => [
                'title' => 'Termin Jatuh Tempo',

                'repeater' => [
                    'due-terms' => [
                        'fields' => [
                            'value'                  => 'Nilai',
                            'due'                    => 'Jatuh Tempo',
                            'delay-type'             => 'Jenis Tenggang',
                            'days-on-the-next-month' => 'Tanggal pada bulan berikutnya',
                            'days'                   => 'Hari',
                        ],
                    ],
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'payment-term' => 'Termin Pembayaran',
            'company'      => 'Perusahaan',
            'created-at'   => 'Dibuat pada',
            'updated-at'   => 'Diperbarui pada',
        ],

        'groups' => [
            'company-name'        => 'Nama Perusahaan',
            'discount-days'       => 'Hari Diskon',
            'early-pay-discount'  => 'Diskon Pembayaran Awal',
            'payment-term'        => 'Termin Pembayaran',
            'display-on-invoice'  => 'Tampilkan di Faktur',
            'early-discount'      => 'Diskon Awal',
            'discount-percentage' => 'Persentase Diskon',
        ],

        'actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Termin Pembayaran berhasil dipulihkan',
                    'body'  => 'Termin pembayaran telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Termin Pembayaran berhasil dihapus',
                    'body'  => 'Termin pembayaran telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Termin Pembayaran berhasil dihapus permanen',
                        'body'  => 'Termin pembayaran telah berhasil dihapus secara permanen.',
                    ],

                    'error' => [
                        'title' => 'Gagal menghapus permanen Termin Pembayaran',
                        'body'  => 'Termin pembayaran tidak dapat dihapus permanen karena terkait dengan entri jurnal.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Termin Pembayaran berhasil dipulihkan',
                    'body'  => 'Termin-termin pembayaran tersebut telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Termin Pembayaran berhasil dihapus',
                    'body'  => 'Termin-termin pembayaran tersebut telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Termin Pembayaran berhasil dihapus permanen',
                        'body'  => 'Termin-termin pembayaran tersebut telah berhasil dihapus secara permanen.',
                    ],

                    'error' => [
                        'title' => 'Gagal menghapus permanen Termin Pembayaran',
                        'body'  => 'Termin-termin pembayaran tersebut tidak dapat dihapus permanen karena terkait dengan entri jurnal.',
                    ],
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'entries' => [
                'payment-term'         => 'Termin Pembayaran',
                'early-discount'       => 'Diskon Pembayaran Awal',
                'discount-percentage'  => 'Persentase Diskon',
                'discount-days-prefix' => 'jika dibayar dalam',
                'discount-days-suffix' => 'hari',
                'reduced-tax'          => 'Pajak dikurangi',
                'note'                 => 'Catatan',
                'status'               => 'Status',
            ],
        ],

        'tabs' => [
            'due-terms' => [
                'title' => 'Termin Jatuh Tempo',

                'repeater' => [
                    'due-terms' => [
                        'entries' => [
                            'value'                  => 'Nilai',
                            'due'                    => 'Jatuh Tempo',
                            'delay-type'             => 'Jenis Tenggang',
                            'days-on-the-next-month' => 'Tanggal pada bulan berikutnya',
                            'days'                   => 'Hari',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
