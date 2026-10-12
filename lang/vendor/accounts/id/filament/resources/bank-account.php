<?php

return [
    'navigation' => [
        'title' => 'Rekening Bank',
        'group' => 'Bank',
    ],

    'form' => [
        'account-number'     => 'Nomor Rekening',
        'bank'               => [
            'title'    => 'Bank',
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

        'account-holder'     => 'Pemilik Rekening',
    ],

    'table' => [
        'columns' => [
            'account-number' => 'Nomor Rekening',
            'bank'           => 'Bank',
            'account-holder' => 'Pemilik Rekening',
            'send-money'     => 'Dapat Mengirim Uang',
            'created-at'     => 'Dibuat pada',
            'updated-at'     => 'Diperbarui pada',
            'deleted-at'     => 'Dihapus pada',
        ],

        'filters' => [
            'bank'           => 'Bank',
            'account-holder' => 'Pemilik Rekening',
            'creator'        => 'Pembuat',
            'can-send-money' => 'Dapat Mengirim Uang',
        ],

        'groups' => [
            'bank'               => 'Bank',
            'can-send-money'     => 'Dapat Mengirim Uang',
            'created-at'         => 'Dibuat pada',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Rekening bank berhasil diperbarui',
                    'body'  => 'Rekening bank telah berhasil diperbarui.',
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Rekening bank berhasil dipulihkan',
                    'body'  => 'Rekening bank telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Rekening bank berhasil dihapus',
                    'body'  => 'Rekening bank telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Rekening bank berhasil dihapus permanen',
                    'body'  => 'Rekening bank telah berhasil dihapus secara permanen.',
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Rekening bank berhasil dipulihkan',
                    'body'  => 'Rekening bank telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Rekening bank berhasil dihapus',
                    'body'  => 'Rekening bank telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Rekening bank berhasil dihapus permanen',
                    'body'  => 'Rekening bank telah berhasil dihapus secara permanen.',
                ],
            ],
        ],
    ],
];
