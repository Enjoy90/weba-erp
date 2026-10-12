<?php

return [
    'navigation' => [
        'title' => 'Penerimaan',
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
                        'title' => 'Penerimaan berhasil dihapus',
                        'body'  => 'Penerimaan telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Penerimaan tidak dapat dihapus',
                        'body'  => 'Penerimaan tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Data penerimaan berhasil dihapus',
                        'body'  => 'Data penerimaan telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Data penerimaan tidak dapat dihapus',
                        'body'  => 'Data penerimaan tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],
    ],
];
