<?php

return [
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
