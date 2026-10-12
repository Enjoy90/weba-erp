<?php

return [
    'notification' => [
        'title' => 'Pesanan berhasil diperbarui',
        'body'  => 'Pesanan telah berhasil diperbarui.',
    ],

    'header-actions' => [
        'confirm' => [
            'label' => 'Konfirmasi',
        ],

        'close' => [
            'label' => 'Tutup',
        ],

        'cancel' => [
            'label' => 'Batal',
        ],

        'print' => [
            'label' => 'Cetak',
        ],

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
];
