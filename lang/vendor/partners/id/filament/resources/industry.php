<?php

return [
    'navigation' => [
        'title' => 'Industri',
    ],

    'form' => [
        'name'      => 'Nama',
        'full-name' => 'Nama Lengkap',
    ],

    'table' => [
        'columns' => [
            'name'       => 'Nama',
            'full-name'  => 'Nama Lengkap',
            'created-at' => 'Dibuat Pada',
            'updated-at' => 'Diperbarui Pada',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Industri berhasil diperbarui',
                    'body'  => 'Industri telah berhasil diperbarui.',
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Industri berhasil dipulihkan',
                    'body'  => 'Industri telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Industri berhasil dihapus',
                    'body'  => 'Industri telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Industri berhasil dihapus permanen',
                    'body'  => 'Industri telah berhasil dihapus secara permanen.',
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Industri berhasil dipulihkan',
                    'body'  => 'Industri telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Industri berhasil dihapus',
                    'body'  => 'Industri telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Industri berhasil dihapus permanen',
                    'body'  => 'Industri telah berhasil dihapus secara permanen.',
                ],
            ],
        ],
    ],
];
