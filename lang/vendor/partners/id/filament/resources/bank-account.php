<?php

return [
    'navigation' => [
        'group' => 'Bank',
        'title' => 'Rekening Bank',
    ],

    'form' => [
        'account-number'     => 'Nomor Rekening',
        'bank'               => 'Bank',
        'account-holder'     => 'Pemilik Rekening',
        'can-send-money'     => 'Dapat Mengirim Uang',
    ],

    'table' => [
        'columns' => [
            'account-number' => 'Nomor Rekening',
            'bank'           => 'Bank',
            'account-holder' => 'Pemilik Rekening',
            'send-money'     => 'Dapat Mengirim Uang',
            'created-at'     => 'Dibuat Pada',
            'updated-at'     => 'Diperbarui Pada',
            'deleted-at'     => 'Dihapus Pada',
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
            'created-at'         => 'Dibuat Pada',
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
