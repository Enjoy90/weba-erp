<?php

return [
    'navigation' => [
        'title' => 'Bank',
        'group' => 'Rekening Bank',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title' => 'Umum',

                'fields' => [
                    'name'  => 'Nama',
                    'code'  => 'Kode Identifikasi Bank',
                    'email' => 'Email',
                    'phone' => 'Telepon',
                ],
            ],

            'address' => [
                'title' => 'Alamat',

                'fields' => [
                    'address' => 'Alamat',
                    'city'    => 'Kota',
                    'street1' => 'Jalan 1',
                    'street2' => 'Jalan 2',
                    'state'   => 'Provinsi',
                    'zip'     => 'Kode Pos',
                    'country' => 'Negara',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'           => 'Nama',
            'code'           => 'Kode Identifikasi Bank',
            'country'        => 'Negara',
            'created-at'     => 'Dibuat Pada',
            'updated-at'     => 'Diperbarui Pada',
            'deleted-at'     => 'Dihapus Pada',
        ],

        'groups' => [
            'country'               => 'Negara',
            'created-at'            => 'Dibuat Pada',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Bank berhasil diperbarui',
                    'body'  => 'Bank telah berhasil diperbarui.',
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Bank berhasil dipulihkan',
                    'body'  => 'Bank telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Bank berhasil dihapus',
                    'body'  => 'Bank telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Bank berhasil dihapus permanen',
                    'body'  => 'Bank telah berhasil dihapus permanen.',
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Bank berhasil dipulihkan',
                    'body'  => 'Bank yang dipilih telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Bank berhasil dihapus',
                    'body'  => 'Bank yang dipilih telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Bank berhasil dihapus permanen',
                    'body'  => 'Bank yang dipilih telah berhasil dihapus permanen.',
                ],
            ],
        ],
    ],
];
