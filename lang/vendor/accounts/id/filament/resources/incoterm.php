<?php

return [
    'form' => [
        'fields' => [
            'code' => 'Kode',
            'name' => 'Nama',
        ],
    ],

    'table' => [
        'columns' => [
            'code'       => 'Kode',
            'name'       => 'Nama',
            'created-by' => 'Dibuat oleh',
        ],

        'groups' => [
            'code' => 'Kode',
            'name' => 'Nama',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Incoterm berhasil diperbarui',
                    'body'  => 'Incoterm telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Incoterm berhasil dihapus',
                    'body'  => 'Incoterm telah berhasil dihapus.',
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Incoterm berhasil dipulihkan',
                    'body'  => 'Incoterm telah berhasil dipulihkan.',
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Incoterm berhasil dipulihkan',
                    'body'  => 'Incoterm telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Incoterm berhasil dihapus',
                    'body'  => 'Incoterm telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Incoterm berhasil dihapus permanen',
                    'body'  => 'Incoterm telah berhasil dihapus secara permanen.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'entries' => [
            'name' => 'Nama',
            'code' => 'Kode',
        ],
    ],
];
