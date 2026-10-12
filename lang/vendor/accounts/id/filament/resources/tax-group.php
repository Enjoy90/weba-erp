<?php

return [
    'form' => [
        'sections' => [
            'fields' => [
                'company'            => 'Perusahaan',
                'country'            => 'Negara',
                'name'               => 'Nama',
                'preceding-subtotal' => 'Subtotal Sebelumnya',
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'company'            => 'Perusahaan',
            'country'            => 'Negara',
            'created-by'         => 'Dibuat oleh',
            'name'               => 'Nama',
            'preceding-subtotal' => 'Subtotal Sebelumnya',
            'created-at'         => 'Dibuat pada',
            'updated-at'         => 'Diperbarui pada',
        ],

        'groups' => [
            'name'       => 'Nama',
            'company'    => 'Perusahaan',
            'country'    => 'Negara',
            'created-by' => 'Dibuat oleh',
            'created-at' => 'Dibuat pada',
            'updated-at' => 'Diperbarui pada',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Grup Pajak berhasil dihapus',
                        'body'  => 'Grup pajak telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Grup Pajak tidak dapat dihapus',
                        'body'  => 'Grup pajak tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Grup Pajak berhasil dihapus',
                        'body'  => 'Grup-grup pajak tersebut telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Grup Pajak tidak dapat dihapus',
                        'body'  => 'Grup-grup pajak tersebut tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'entries' => [
                'company'            => 'Perusahaan',
                'country'            => 'Negara',
                'name'               => 'Nama',
                'preceding-subtotal' => 'Subtotal Sebelumnya',
            ],
        ],
    ],
];
