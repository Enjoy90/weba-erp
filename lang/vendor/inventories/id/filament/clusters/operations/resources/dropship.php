<?php

return [
    'navigation' => [
        'title' => 'Dropship',
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
                        'title' => 'Dropship berhasil dihapus',
                        'body'  => 'Dropship telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Dropship tidak dapat dihapus',
                        'body'  => 'Dropship tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Data dropship berhasil dihapus',
                        'body'  => 'Data dropship telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Data dropship tidak dapat dihapus',
                        'body'  => 'Data dropship tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],
    ],
];
