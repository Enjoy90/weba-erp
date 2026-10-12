<?php

return [
    'navigation' => [
        'title' => 'Lihat Daftar Harga Pemasok',
    ],

    'header-actions' => [
        'delete' => [
            'notification' => [
                'success' => [
                    'title' => 'Harga pemasok berhasil dihapus',
                    'body'  => 'Harga pemasok telah berhasil dihapus.',
                ],

                'error' => [
                    'title' => 'Harga pemasok tidak dapat dihapus',
                    'body'  => 'Harga pemasok tidak dapat dihapus karena sedang digunakan.',
                ],
            ],
        ],
    ],
];
