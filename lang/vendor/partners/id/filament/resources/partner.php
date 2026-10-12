<?php

return [
    'global-search' => [
        'email' => 'Email',
        'phone' => 'Telepon',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title' => 'Umum',

                'fields' => [
                    'company'    => 'Perusahaan',
                    'avatar'     => 'Avatar',
                    'tax-id'     => 'NPWP',
                    'job-title'  => 'Jabatan',
                    'phone'      => 'Telepon',
                    'mobile'     => 'Ponsel',
                    'email'      => 'Email',
                    'website'    => 'Situs Web',
                    'title'      => 'Gelar',
                    'name'       => 'Nama',
                    'short-name' => 'Nama Singkat',
                    'tags'       => 'Tag',
                    'color'      => 'Warna',
                ],

                'address' => [
                    'title' => 'Alamat',

                    'fields' => [
                        'street1'  => 'Jalan 1',
                        'street2'  => 'Jalan 2',
                        'city'     => 'Kota',
                        'zip'      => 'Kode Pos',
                        'state'    => 'Provinsi',
                        'country'  => 'Negara',
                        'name'     => 'Nama',
                        'code'     => 'Kode',
                    ],
                ],
            ],
        ],

        'tabs' => [
            'sales-purchase' => [
                'title' => 'Penjualan dan Pembelian',

                'fields' => [
                    'responsible'           => 'Penanggung Jawab',
                    'responsible-hint-text' => 'Tenaga penjual internal yang bertanggung jawab atas pelanggan ini',
                    'company-id'            => 'ID Perusahaan',
                    'company-id-hint-text'  => 'Nomor registrasi perusahaan, dipakai jika berbeda dari NPWP. Nomor ini harus unik di antara semua mitra dalam negara yang sama.',
                    'reference'             => 'Referensi',
                    'industry'              => 'Industri',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'parent'     => 'Induk',
            'work-email' => 'Email Kantor',
            'work-phone' => 'Telepon Kantor',
        ],

        'groups' => [
            'account-type' => 'Jenis Akun',
            'parent'       => 'Induk',
            'title'        => 'Gelar',
            'job-title'    => 'Jabatan',
            'industry'     => 'Industri',
        ],

        'filters' => [
            'account-type'     => 'Jenis Akun',
            'name'             => 'Nama',
            'email'            => 'Email',
            'parent'           => 'Induk',
            'title'            => 'Gelar',
            'tax-id'           => 'NPWP',
            'phone'            => 'Telepon',
            'mobile'           => 'Ponsel',
            'job-title'        => 'Jabatan',
            'website'          => 'Situs Web',
            'company-registry' => 'Nomor Registrasi Perusahaan',
            'responsible'      => 'Penanggung Jawab',
            'reference'        => 'Referensi',
            'parent'           => 'Induk',
            'creator'          => 'Pembuat',
            'company'          => 'Perusahaan',
            'industry'         => 'Industri',
            'industry'         => 'Industri',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Kontak berhasil diperbarui',
                    'body'  => 'Kontak telah berhasil diperbarui.',
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Kontak berhasil dipulihkan',
                    'body'  => 'Kontak telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Kontak berhasil dihapus',
                    'body'  => 'Kontak telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Kontak berhasil dihapus permanen',
                        'body'  => 'Kontak telah berhasil dihapus secara permanen.',
                    ],

                    'error' => [
                        'title' => 'Kontak tidak dapat dihapus',
                        'body'  => 'Kontak tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Kontak berhasil dipulihkan',
                    'body'  => 'Kontak telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Kontak berhasil dihapus',
                    'body'  => 'Kontak telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Kontak berhasil dihapus permanen',
                        'body'  => 'Kontak telah berhasil dihapus secara permanen.',
                    ],

                    'error' => [
                        'title' => 'Kontak tidak dapat dihapus',
                        'body'  => 'Kontak tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title' => 'Umum',

                'fields' => [
                    'company'    => 'Perusahaan',
                    'avatar'     => 'Avatar',
                    'tax-id'     => 'NPWP',
                    'job-title'  => 'Jabatan',
                    'phone'      => 'Telepon',
                    'mobile'     => 'Ponsel',
                    'email'      => 'Email',
                    'website'    => 'Situs Web',
                    'title'      => 'Gelar',
                    'name'       => 'Nama',
                    'short-name' => 'Nama Singkat',
                    'tags'       => 'Tag',
                ],

                'address' => [
                    'title' => 'Alamat',

                    'fields' => [
                        'street1'  => 'Jalan 1',
                        'street2'  => 'Jalan 2',
                        'city'     => 'Kota',
                        'zip'      => 'Kode Pos',
                        'state'    => 'Provinsi',
                        'country'  => 'Negara',
                        'name'     => 'Nama',
                        'code'     => 'Kode',
                    ],
                ],
            ],
        ],

        'tabs' => [
            'sales-purchase' => [
                'title' => 'Penjualan dan Pembelian',

                'fields' => [
                    'responsible'           => 'Penanggung Jawab',
                    'responsible-hint-text' => 'Tenaga penjual internal yang bertanggung jawab atas pelanggan ini',
                    'company-id'            => 'ID Perusahaan',
                    'company-id-hint-text'  => 'Nomor registrasi perusahaan. Gunakan jika berbeda dari NPWP. Nomor ini harus unik di antara semua mitra dalam negara yang sama',
                    'reference'             => 'Referensi',
                    'industry'              => 'Industri',
                ],
            ],
        ],
    ],
];
