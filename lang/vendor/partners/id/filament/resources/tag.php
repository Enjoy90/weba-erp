<?php

return [
    'navigation' => [
        'title' => 'Tag',
    ],

    'form' => [
        'name'  => 'Nama',
        'color' => 'Warna',
    ],

    'table' => [
        'columns' => [
            'name'       => 'Nama',
            'color'      => 'Warna',
            'created-at' => 'Dibuat Pada',
            'updated-at' => 'Diperbarui Pada',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Tag berhasil diperbarui',
                    'body'  => 'Tag telah berhasil diperbarui.',
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Tag berhasil dipulihkan',
                    'body'  => 'Tag telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Tag berhasil dihapus',
                    'body'  => 'Tag telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Tag berhasil dihapus permanen',
                    'body'  => 'Tag telah berhasil dihapus secara permanen.',
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Tag berhasil dipulihkan',
                    'body'  => 'Tag telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Tag berhasil dihapus',
                    'body'  => 'Tag telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Tag berhasil dihapus permanen',
                    'body'  => 'Tag telah berhasil dihapus secara permanen.',
                ],
            ],
        ],
    ],
];
