<?php

return [
    'navigation' => [
        'title' => 'Rencana Aktivitas',
        'group' => 'Aktivitas',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title'  => 'Informasi Umum',
                'fields' => [
                    'name'       => 'Nama',
                    'status'     => 'Status',
                    'department' => 'Departemen',
                    'company'    => 'Perusahaan',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'       => 'Nama',
            'status'     => 'Status',
            'department' => 'Departemen',
            'company'    => 'Perusahaan',
            'manager'    => 'Manajer',
            'created-by' => 'Dibuat oleh',
            'created-at' => 'Dibuat pada',
            'updated-at' => 'Diperbarui pada',
        ],

        'filters' => [
            'name'           => 'Nama',
            'plugin'         => 'Plugin',
            'activity-types' => 'Jenis Aktivitas',
            'company'        => 'Perusahaan',
            'department'     => 'Departemen',
            'is-active'      => 'Status',
            'updated-at'     => 'Diperbarui pada',
            'created-at'     => 'Dibuat pada',
        ],

        'groups' => [
            'status'     => 'Status',
            'name'       => 'Nama',
            'created-by' => 'Dibuat oleh',
            'created-at' => 'Dibuat pada',
            'updated-at' => 'Diperbarui pada',
        ],

        'actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Rencana aktivitas berhasil dipulihkan',
                    'body'  => 'Rencana aktivitas telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Rencana aktivitas berhasil dihapus',
                    'body'  => 'Rencana aktivitas telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Rencana aktivitas berhasil dihapus permanen',
                    'body'  => 'Rencana aktivitas telah berhasil dihapus permanen.',
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Rencana aktivitas berhasil dipulihkan',
                    'body'  => 'Rencana aktivitas yang dipilih telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Rencana aktivitas berhasil dihapus',
                    'body'  => 'Rencana aktivitas yang dipilih telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Rencana aktivitas berhasil dihapus permanen',
                    'body'  => 'Rencana aktivitas yang dipilih telah berhasil dihapus permanen.',
                ],
            ],
        ],

        'empty-state' => [
            'create' => [
                'notification' => [
                    'title' => 'Rencana aktivitas berhasil dibuat',
                    'body'  => 'Rencana aktivitas telah berhasil dibuat.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title'   => 'Informasi Umum',
                'entries' => [
                    'name'       => 'Nama',
                    'status'     => 'Status',
                    'department' => 'Departemen',
                    'manager'    => 'Manajer',
                    'company'    => 'Perusahaan',
                ],
            ],
        ],
    ],
];
