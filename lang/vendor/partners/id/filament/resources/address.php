<?php

return [
    'form' => [
        'partner' => 'Mitra',
        'name'    => 'Nama',
        'email'   => 'Email',
        'phone'   => 'Telepon',
        'mobile'  => 'Ponsel',
        'type'    => 'Jenis',
        'address' => 'Alamat',
        'city'    => 'Kota',
        'street1' => 'Jalan 1',
        'street2' => 'Jalan 2',
        'state'   => 'Provinsi',
        'zip'     => 'Kode Pos',
        'code'    => 'Kode',
        'country' => 'Negara',
    ],

    'table' => [
        'header-actions' => [
            'create' => [
                'label' => 'Tambah Alamat',

                'notification' => [
                    'title' => 'Alamat berhasil dibuat',
                    'body'  => 'Alamat telah berhasil dibuat.',
                ],
            ],
        ],

        'columns' => [
            'type'    => 'Jenis',
            'name'    => 'Nama Kontak',
            'address' => 'Alamat',
            'city'    => 'Kota',
            'street1' => 'Jalan 1',
            'street2' => 'Jalan 2',
            'state'   => 'Provinsi',
            'zip'     => 'Kode Pos',
            'country' => 'Negara',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Alamat berhasil diperbarui',
                    'body'  => 'Alamat telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Alamat berhasil dihapus',
                    'body'  => 'Alamat telah berhasil dihapus.',
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Alamat berhasil dihapus',
                    'body'  => 'Alamat telah berhasil dihapus.',
                ],
            ],
        ],
    ],
];
