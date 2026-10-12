<?php

return [
    'form' => [
        'fields' => [
            'name'               => 'Nama',
            'rounding-precision' => 'Presisi Pembulatan',
            'rounding-strategy'  => 'Strategi Pembulatan',
            'profit-account'     => 'Akun Laba',
            'loss-account'       => 'Akun Rugi',
            'rounding-method'    => 'Metode Pembulatan',
        ],
    ],

    'table' => [
        'columns' => [
            'name'                 => 'Nama',
            'rounding-strategy'    => 'Strategi Pembulatan',
            'rounding-method'      => 'Metode Pembulatan',
            'created-by'           => 'Dibuat oleh',
            'profit-account'       => 'Akun Laba',
            'loss-account'         => 'Akun Rugi',
        ],

        'groups' => [
            'name'              => 'Nama',
            'rounding-strategy' => 'Strategi Pembulatan',
            'rounding-method'   => 'Metode Pembulatan',
            'created-by'        => 'Dibuat oleh',
            'profit-account'    => 'Akun Laba',
            'loss-account'      => 'Akun Rugi',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Pembulatan Kas berhasil dihapus',
                    'body'  => 'Pembulatan kas telah berhasil dihapus.',
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Pembulatan Kas berhasil dihapus',
                    'body'  => 'Pembulatan kas telah berhasil dihapus.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'entries' => [
            'name'               => 'Nama',
            'rounding-precision' => 'Presisi Pembulatan',
            'rounding-strategy'  => 'Strategi Pembulatan',
            'profit-account'     => 'Akun Laba',
            'loss-account'       => 'Akun Rugi',
            'rounding-method'    => 'Metode Pembulatan',
        ],
    ],
];
