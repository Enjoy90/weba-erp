<?php

return [
    'notification' => [
        'title' => 'Perjanjian pembelian berhasil diperbarui',
        'body'  => 'Perjanjian pembelian telah berhasil diperbarui.',
    ],

    'header-actions' => [
        'confirm' => [
            'label' => 'Konfirmasi',

            'notification' => [
                'unable' => [
                    'title' => 'Perjanjian pembelian tidak dapat dikonfirmasi',
                    'body'  => 'Tambahkan minimal satu baris produk sebelum mengonfirmasi perjanjian pembelian ini.',
                ],
            ],
        ],

        'close' => [
            'label'        => 'Tutup',
            'notification' => [
                'warning' => [
                    'title' => 'Perjanjian pembelian tidak dapat ditutup',
                    'body'  => 'Perjanjian pembelian ini tidak dapat ditutup karena ada RFQ terkait yang belum berstatus Selesai atau Dibatalkan.',
                ],
            ],
        ],

        'cancel' => [
            'label' => 'Batal',
        ],

        'print' => [
            'label' => 'Cetak',
        ],

        'delete' => [
            'notification' => [
                'title' => 'Perjanjian pembelian berhasil dihapus',
                'body'  => 'Perjanjian pembelian telah berhasil dihapus.',
            ],
        ],
    ],
];
