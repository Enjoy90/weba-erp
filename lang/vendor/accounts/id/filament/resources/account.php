<?php

return [
    'global-search' => [
        'code' => 'Kode',
        'type' => 'Jenis',
    ],

    'form' => [
        'sections' => [
            'fields' => [
                'code'                   => 'Kode',
                'account-name'           => 'Nama Akun',
                'accounting'             => 'Akuntansi',
                'account-type'           => 'Jenis Akun',
                'parent-account'         => 'Akun Induk',
                'parent-account-helper'  => 'Pilih akun yang sudah ada untuk menjadikan akun ini sebagai sub-akun.',
                'default-taxes'          => 'Pajak Bawaan',
                'tags'                   => 'Tag',
                'journals'               => 'Jurnal',
                'journals-helper'        => 'Disarankan otomatis berdasarkan Jenis Akun yang dipilih. Anda dapat mengubah pilihan ini.',
                'currency'               => 'Mata Uang',
                'deprecated'             => 'Tidak Berlaku',
                'reconcile'              => 'Izinkan Rekonsiliasi',
                'non-trade'              => 'Non Dagang',
                'companies'              => 'Perusahaan',
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'code'           => 'Kode',
            'account-name'   => 'Nama Akun',
            'account-type'   => 'Akun',
            'parent-account' => 'Akun Induk',
            'currency'       => 'Mata Uang',
            'journals'       => 'Jurnal',
            'reconcile'      => 'Izinkan Rekonsiliasi',
        ],

        'grouping' => [
            'account-type' => 'Jenis Akun',
        ],

        'filters' => [
            'account-type'     => 'Jenis Akun',
            'parent-account'   => 'Akun Induk',
            'allow-reconcile'  => 'Izinkan Rekonsiliasi',
            'currency'         => 'Mata Uang',
            'account-journals' => 'Jurnal',
            'non-trade'        => 'Non Dagang',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Akun berhasil diperbarui',
                    'body'  => 'Akun telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Akun berhasil dihapus',
                        'body'  => 'Akun telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Gagal menghapus akun',
                        'body'  => 'Akun tidak dapat dihapus karena memiliki item jurnal terkait.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Akun berhasil dihapus',
                        'body'  => 'Akun-akun tersebut telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Gagal menghapus akun',
                        'body'  => 'Akun-akun tersebut tidak dapat dihapus karena memiliki item jurnal terkait.',
                    ],
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'entries' => [
                'code'           => 'Kode',
                'account-name'   => 'Nama Akun',
                'accounting'     => 'Akuntansi',
                'account-type'   => 'Jenis Akun',
                'parent-account' => 'Akun Induk',
                'sub-accounts'   => 'Sub-Akun',
                'default-taxes'  => 'Pajak Bawaan',
                'tags'           => 'Tag',
                'journals'       => 'Jurnal',
                'currency'       => 'Mata Uang',
                'deprecated'     => 'Tidak Berlaku',
                'reconcile'      => 'Rekonsiliasi',
                'non-trade'      => 'Non Dagang',
            ],
        ],
    ],
];
