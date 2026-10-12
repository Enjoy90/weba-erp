<?php

return [
    'form' => [
        'value'                  => 'Nilai',
        'due'                    => 'Jatuh Tempo',
        'delay-due'              => 'Tenggang Jatuh Tempo',
        'delay-type'             => 'Jenis Tenggang',
        'days-on-the-next-month' => 'Tanggal pada bulan berikutnya',
        'days'                   => 'Hari',
        'payment-term'           => 'Termin Pembayaran',
    ],

    'table' => [
        'columns' => [
            'due'          => 'Jatuh Tempo',
            'value'        => 'Nilai',
            'value-amount' => 'Besaran Nilai',
            'after'        => 'Setelah',
            'delay-type'   => 'Jenis Tenggang',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Termin Jatuh Tempo berhasil diperbarui',
                    'body'  => 'Termin jatuh tempo pembayaran telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Termin Jatuh Tempo berhasil dihapus',
                    'body'  => 'Termin jatuh tempo pembayaran telah berhasil dihapus.',
                ],
            ],
        ],

        'header-actions' => [
            'create' => [
                'notification' => [
                    'title' => 'Termin Jatuh Tempo berhasil dibuat',
                    'body'  => 'Termin jatuh tempo pembayaran telah berhasil dibuat.',
                ],
            ],
        ],
    ],
];
