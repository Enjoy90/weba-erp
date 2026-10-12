<?php

return [
    'notification' => [
        'title' => 'Dropship berhasil diperbarui',
        'body'  => 'Dropship telah berhasil diperbarui.',
    ],

    'header-actions' => [
        'print' => [
            'label' => 'Cetak',
        ],

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
];
