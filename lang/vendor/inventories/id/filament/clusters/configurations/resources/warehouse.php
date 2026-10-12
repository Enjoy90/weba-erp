<?php

return [
    'navigation' => [
        'title' => 'Gudang',
        'group' => 'Manajemen Gudang',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title'  => 'Umum',
                'fields' => [
                    'name'                    => 'Nama',
                    'name-placeholder'        => 'mis. Gudang Pusat',
                    'code'                    => 'Nama Singkat',
                    'code-placeholder'        => 'mis. GP',
                    'code-hint-tooltip'       => 'Nama singkat berfungsi sebagai pengenal gudang.',
                    'company'                 => 'Perusahaan',
                    'multi-warehouse-warning' => 'Membuat gudang baru akan otomatis mengaktifkan pengaturan Lokasi Penyimpanan.',
                    'address'                 => 'Alamat',
                ],
            ],

            'settings' => [
                'title'  => 'Pengaturan',

                'fields' => [
                    'shipment-management'              => 'Manajemen Pengiriman',
                    'incoming-shipments'               => 'Pengiriman Masuk',
                    'incoming-shipments-hint-tooltip'  => 'Rute masuk bawaan yang diikuti',
                    'outgoing-shipments'               => 'Pengiriman Keluar',
                    'outgoing-shipments-hint-tooltip'  => 'Rute keluar bawaan yang diikuti',
                    'manufacture'                      => 'Manufaktur',
                    'manufacture-hint-tooltip'         => 'Rute manufaktur bawaan yang diikuti',
                    'resupply-management'              => 'Manajemen Pasokan Ulang',
                    'resupply-management-hint-tooltip' => 'Rute akan dibuat otomatis untuk memasok ulang gudang ini dari gudang yang dipilih.',
                    'resupply-from'                    => 'Pasok Ulang Dari',
                ],
            ],

            'additional' => [
                'title'  => 'Informasi Tambahan',
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'       => 'Nama',
            'code'       => 'Nama Singkat',
            'company'    => 'Perusahaan',
            'address'    => 'Alamat',
            'deleted-at' => 'Dihapus Pada',
            'created-at' => 'Dibuat Pada',
            'updated-at' => 'Diperbarui Pada',
        ],

        'groups' => [
            'address'       => 'Alamat',
            'company'       => 'Perusahaan',
            'created-at'    => 'Dibuat Pada',
            'updated-at'    => 'Diperbarui Pada',
        ],

        'filters' => [
            'company' => 'Perusahaan',
        ],

        'actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Gudang berhasil dipulihkan',
                    'body'  => 'Gudang telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Gudang berhasil dihapus',
                    'body'  => 'Gudang telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Gudang berhasil dihapus permanen',
                        'body'  => 'Gudang telah berhasil dihapus permanen.',
                    ],

                    'error' => [
                        'title' => 'Gudang tidak dapat dihapus',
                        'body'  => 'Gudang tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Data gudang berhasil dipulihkan',
                    'body'  => 'Data gudang telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Data gudang berhasil dihapus',
                    'body'  => 'Data gudang telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Data gudang berhasil dihapus permanen',
                        'body'  => 'Data gudang telah berhasil dihapus permanen.',
                    ],

                    'error' => [
                        'title' => 'Data gudang tidak dapat dihapus',
                        'body'  => 'Data gudang tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title' => 'Informasi Umum',

                'entries' => [
                    'name'    => 'Nama Gudang',
                    'code'    => 'Kode Gudang',
                    'company' => 'Perusahaan',
                    'address' => 'Alamat',
                ],
            ],

            'settings' => [
                'title' => 'Pengaturan',

                'entries' => [
                    'shipment-management' => 'Manajemen Pengiriman',
                    'incoming-shipments'  => 'Pengiriman Masuk',
                    'outgoing-shipments'  => 'Pengiriman Keluar',
                    'resupply-management' => 'Manajemen Pasokan Ulang',
                    'resupply-from'       => 'Pasok Ulang Dari',
                ],
            ],

            'record-information' => [
                'title' => 'Informasi Data',

                'entries' => [
                    'created-by'   => 'Dibuat Oleh',
                    'created-at'   => 'Dibuat Pada',
                    'last-updated' => 'Terakhir Diperbarui',
                ],
            ],
        ],
    ],
];
