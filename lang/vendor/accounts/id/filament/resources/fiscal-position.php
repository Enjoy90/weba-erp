<?php

return [
    'global-search' => [
        'zip-from' => 'Kode Pos Dari',
        'zip-to'   => 'Kode Pos Sampai',
        'name'     => 'Nama',
    ],

    'form' => [
        'fields' => [
            'name'                   => 'Nama',
            'foreign-vat'            => 'PPN Luar Negeri',
            'country'                => 'Negara',
            'country-group'          => 'Grup Negara',
            'zip-from'               => 'Kode Pos Dari',
            'zip-to'                 => 'Kode Pos Sampai',
            'detect-automatically'   => 'Deteksi Otomatis',
            'notes'                  => 'Catatan',
            'company'                => 'Perusahaan',
        ],
        'tabs' => [
            'account-mapping' => [
                'table' => [
                    'columns' => [
                        'source-account'      => 'Akun Asal',
                        'destination-account' => 'Akun Tujuan',
                    ],
                ],

            ],
            'tax-mapping' => [
                'table' => [
                    'columns' => [
                        'tax-source'      => 'Pajak Asal',
                        'tax-destination' => 'Pajak Tujuan',
                    ],
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'                 => 'Nama',
            'company'              => 'Perusahaan',
            'country'              => 'Negara',
            'country-group'        => 'Grup Negara',
            'created-by'           => 'Dibuat oleh',
            'zip-from'             => 'Kode Pos Dari',
            'zip-to'               => 'Kode Pos Sampai',
            'status'               => 'Status',
            'detect-automatically' => 'Deteksi Otomatis',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Posisi Fiskal berhasil dihapus',
                    'body'  => 'Posisi fiskal telah berhasil dihapus.',
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Posisi Fiskal berhasil dihapus',
                    'body'  => 'Posisi fiskal telah berhasil dihapus.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'entries' => [
            'name'                 => 'Nama',
            'foreign-vat'          => 'PPN Luar Negeri',
            'country'              => 'Negara',
            'country-group'        => 'Grup Negara',
            'zip-from'             => 'Kode Pos Dari',
            'zip-to'               => 'Kode Pos Sampai',
            'detect-automatically' => 'Deteksi Otomatis',
            'notes'                => 'Catatan',
        ],
    ],
];
