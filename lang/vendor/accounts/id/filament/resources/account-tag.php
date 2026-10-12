<?php

return [
    'form' => [
        'fields' => [
            'color'         => 'Warna',
            'country'       => 'Negara',
            'applicability' => 'Penerapan',
            'name'          => 'Nama',
            'status'        => 'Status',
            'tax-negate'    => 'Balik Tanda Pajak',
        ],
    ],

    'table' => [
        'columns' => [
            'color'         => 'Warna',
            'country'       => 'Negara',
            'created-by'    => 'Dibuat oleh',
            'applicability' => 'Penerapan',
            'name'          => 'Nama',
            'status'        => 'Status',
            'tax-negate'    => 'Balik Tanda Pajak',
            'created-at'    => 'Dibuat pada',
            'updated-at'    => 'Diperbarui pada',
            'deleted-at'    => 'Dihapus pada',
        ],

        'filters' => [
            'bank'           => 'Bank',
            'account-holder' => 'Pemilik Rekening',
            'creator'        => 'Pembuat',
            'can-send-money' => 'Dapat Mengirim Uang',
        ],

        'groups' => [
            'country'       => 'Negara',
            'created-by'    => 'Dibuat oleh',
            'applicability' => 'Penerapan',
            'name'          => 'Nama',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Tag Akun berhasil diperbarui',
                    'body'  => 'Tag akun telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Tag Akun berhasil dihapus',
                    'body'  => 'Tag akun telah berhasil dihapus.',
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Tag Akun berhasil dihapus',
                    'body'  => 'Tag akun telah berhasil dihapus.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'entries' => [
            'color'         => 'Warna',
            'country'       => 'Negara',
            'applicability' => 'Penerapan',
            'name'          => 'Nama',
            'status'        => 'Status',
            'tax-negate'    => 'Balik Tanda Pajak',
        ],
    ],
];
