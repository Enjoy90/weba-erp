<?php

return [
    'notification' => [
        'title' => 'Kategori berhasil diperbarui',
        'body'  => 'Kategori telah berhasil diperbarui.',
    ],

    'header-actions' => [
        'delete' => [
            'notification' => [
                'success' => [
                    'title' => 'Kategori berhasil dihapus',
                    'body'  => 'Kategori telah berhasil dihapus.',
                ],

                'error' => [
                    'title' => 'Kategori tidak dapat dihapus',
                    'body'  => 'Kategori tidak dapat dihapus karena sedang digunakan.',
                ],
            ],
        ],
    ],

    'save' => [
        'notification' => [
            'error' => [
                'title' => 'Kategori gagal diperbarui',
            ],
        ],
    ],
];
