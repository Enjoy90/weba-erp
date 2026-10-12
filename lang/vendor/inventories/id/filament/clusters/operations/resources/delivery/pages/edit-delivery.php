<?php

return [
    'notification' => [
        'title' => 'Pengiriman berhasil diperbarui',
        'body'  => 'Pengiriman telah berhasil diperbarui.',
    ],

    'header-actions' => [
        'print' => [
            'label' => 'Cetak',
        ],

        'delete' => [
            'notification' => [
                'success' => [
                    'title' => 'Pengiriman berhasil dihapus',
                    'body'  => 'Pengiriman telah berhasil dihapus.',
                ],

                'error' => [
                    'title' => 'Pengiriman tidak dapat dihapus',
                    'body'  => 'Pengiriman tidak dapat dihapus karena sedang digunakan.',
                ],
            ],
        ],
    ],
];
