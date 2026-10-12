<?php

return [
    'navigation' => [
        'title' => 'Transfer Internal',
        'group' => 'Transfer',
    ],

    'global-search' => [
        'origin' => 'Asal',
    ],

    'table' => [
        'actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Transfer Internal berhasil dihapus',
                        'body'  => 'Transfer Internal telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Transfer Internal tidak dapat dihapus',
                        'body'  => 'Transfer Internal tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Data transfer internal berhasil dihapus',
                        'body'  => 'Data transfer internal telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Data transfer internal tidak dapat dihapus',
                        'body'  => 'Data transfer internal tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],
    ],
];
