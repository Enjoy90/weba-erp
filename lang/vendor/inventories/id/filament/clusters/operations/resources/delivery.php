<?php

return [
    'navigation' => [
        'title' => 'Pengiriman',
        'group' => 'Transfer',
    ],

    'global-search' => [
        'partner' => 'Mitra',
        'origin'  => 'Asal',
    ],

    'table' => [
        'actions' => [
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

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Data pengiriman berhasil dihapus',
                        'body'  => 'Data pengiriman telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Data pengiriman tidak dapat dihapus',
                        'body'  => 'Data pengiriman tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],
    ],
];
