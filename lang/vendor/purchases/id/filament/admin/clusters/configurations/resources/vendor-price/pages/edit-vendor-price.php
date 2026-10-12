<?php

return [
    'navigation' => [
        'title' => 'Ubah Daftar Harga Pemasok',
    ],

    'notification' => [
        'title' => 'Harga pemasok berhasil diperbarui',
        'body'  => 'Harga pemasok telah berhasil diperbarui.',
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
