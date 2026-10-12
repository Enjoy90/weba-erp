<?php

return [
    'title' => 'Perusahaan',

    'navigation' => [
        'title' => 'Perusahaan',
    ],

    'global-search' => [
        'email' => 'Email',
    ],

    'form' => [
        'sections' => [
            'company-information' => [
                'title'  => 'Informasi Perusahaan',
                'fields' => [
                    'name'                  => 'Nama Perusahaan',
                    'registration-number'   => 'Nomor Registrasi',
                    'company-id'            => 'ID Perusahaan',
                    'tax-id'                => 'NPWP',
                    'tax-id-tooltip'        => 'NPWP adalah nomor identitas unik perusahaan Anda untuk keperluan pajak.',
                    'website'               => 'Situs Web',
                ],
            ],

            'address-information' => [
                'title'  => 'Informasi Alamat',

                'fields' => [
                    'street1'        => 'Jalan 1',
                    'street2'        => 'Jalan 2',
                    'city'           => 'Kota',
                    'zipcode'        => 'Kode Pos',
                    'country'        => 'Negara',
                    'currency-name'  => 'Nama Mata Uang',
                    'phone-code'     => 'Kode Telepon',
                    'code'           => 'Kode',
                    'country-name'   => 'Nama Negara',
                    'state-required' => 'Provinsi Wajib Diisi',
                    'zip-required'   => 'Kode Pos Wajib Diisi',
                    'create-country' => 'Buat Negara',
                    'state'          => 'Provinsi',
                    'state-name'     => 'Nama Provinsi',
                    'state-code'     => 'Kode Provinsi',
                    'create-state'   => 'Buat Provinsi',
                ],
            ],

            'additional-information' => [
                'title' => 'Informasi Tambahan',

                'fields' => [
                    'default-currency'        => 'Mata Uang Bawaan',
                    'currency-name'           => 'Nama Mata Uang',
                    'currency-full-name'      => 'Nama Lengkap Mata Uang',
                    'currency-symbol'         => 'Simbol Mata Uang',
                    'currency-iso-numeric'    => 'Kode Numerik ISO Mata Uang',
                    'currency-decimal-places' => 'Jumlah Desimal Mata Uang',
                    'currency-rounding'       => 'Pembulatan Mata Uang',
                    'currency-status'         => 'Status Mata Uang',
                    'company-foundation-date' => 'Tanggal Pendirian Perusahaan',
                    'currency-create'         => 'Buat Mata Uang',
                    'status'                  => 'Status',
                ],
            ],

            'branding' => [
                'title'  => 'Branding',
                'fields' => [
                    'company-logo' => 'Logo Perusahaan',
                    'color'        => 'Warna',
                ],
            ],

            'contact-information' => [
                'title'  => 'Informasi Kontak',
                'fields' => [
                    'email'  => 'Alamat Email',
                    'phone'  => 'Nomor Telepon',
                    'mobile' => 'Nomor Telepon',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'logo'                 => 'Logo',
            'company-name'         => 'Nama Perusahaan',
            'branches'             => 'Cabang',
            'email'                => 'Email',
            'city'                 => 'Kota',
            'country'              => 'Negara',
            'currency'             => 'Mata Uang',
            'status'               => 'Status',
            'created-by'           => 'Dibuat Oleh',
            'created-at'           => 'Dibuat Pada',
            'updated-at'           => 'Diperbarui Pada',
        ],

        'groups' => [
            'company-name' => 'Nama Perusahaan',
            'city'         => 'Kota',
            'country'      => 'Negara',
            'state'        => 'Provinsi',
            'email'        => 'Email',
            'phone'        => 'Telepon',
            'currency'     => 'Mata Uang',
            'created-by'   => 'Dibuat Oleh',
            'created-at'   => 'Dibuat Pada',
            'updated-at'   => 'Diperbarui Pada',
        ],

        'filters' => [
            'status'  => 'Status',
            'country' => 'Negara',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Perusahaan berhasil diperbarui',
                    'body'  => 'Perusahaan telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Perusahaan berhasil dihapus',
                    'body'  => 'Perusahaan telah berhasil dihapus.',

                    'default-company' => [
                        'title' => 'Perusahaan bawaan tidak dapat dihapus',
                        'body'  => 'Anda tidak dapat menghapus perusahaan yang sedang ditetapkan sebagai perusahaan bawaan Anda.',
                    ],
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Perusahaan berhasil dipulihkan',
                    'body'  => 'Perusahaan telah berhasil dipulihkan.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Perusahaan berhasil dihapus permanen',
                        'body'  => 'Perusahaan telah berhasil dihapus permanen.',
                    ],

                    'error' => [
                        'title' => 'Gagal menghapus permanen perusahaan',
                        'body'  => 'Perusahaan tidak dapat dihapus permanen karena terkait dengan data lain.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Perusahaan berhasil dipulihkan',
                    'body'  => 'Perusahaan yang dipilih telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Perusahaan berhasil dihapus',
                    'body'  => 'Perusahaan yang dipilih telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Perusahaan berhasil dihapus permanen',
                    'body'  => 'Perusahaan yang dipilih telah berhasil dihapus permanen.',

                    'error' => [
                        'title' => 'Gagal menghapus permanen perusahaan',
                        'body'  => 'Perusahaan tidak dapat dihapus permanen karena terkait dengan data lain.',
                    ],
                ],
            ],
        ],

        'empty-state-actions' => [
            'create' => [
                'notification' => [
                    'title' => 'Perusahaan berhasil dibuat',
                    'body'  => 'Perusahaan telah berhasil dibuat.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'company-information' => [
                'title'   => 'Informasi Perusahaan',
                'entries' => [
                    'name'                  => 'Nama Perusahaan',
                    'registration-number'   => 'Nomor Registrasi',
                    'company-id'            => 'ID Perusahaan',
                    'tax-id'                => 'NPWP',
                    'tax-id-tooltip'        => 'NPWP adalah nomor identitas unik perusahaan Anda untuk keperluan pajak.',
                    'website'               => 'Situs Web',
                ],
            ],

            'address-information' => [
                'title'  => 'Informasi Alamat',

                'entries' => [
                    'street1'        => 'Jalan 1',
                    'street2'        => 'Jalan 2',
                    'city'           => 'Kota',
                    'zipcode'        => 'Kode Pos',
                    'country'        => 'Negara',
                    'currency-name'  => 'Nama Mata Uang',
                    'phone-code'     => 'Kode Telepon',
                    'code'           => 'Kode',
                    'country-name'   => 'Nama Negara',
                    'state-required' => 'Provinsi Wajib Diisi',
                    'zip-required'   => 'Kode Pos Wajib Diisi',
                    'create-country' => 'Buat Negara',
                    'state'          => 'Provinsi',
                    'state-name'     => 'Nama Provinsi',
                    'state-code'     => 'Kode Provinsi',
                    'create-state'   => 'Buat Provinsi',
                ],
            ],

            'additional-information' => [
                'title' => 'Informasi Tambahan',

                'entries' => [
                    'default-currency'        => 'Mata Uang Bawaan',
                    'currency-name'           => 'Nama Mata Uang',
                    'currency-full-name'      => 'Nama Lengkap Mata Uang',
                    'currency-symbol'         => 'Simbol Mata Uang',
                    'currency-iso-numeric'    => 'Kode Numerik ISO Mata Uang',
                    'currency-decimal-places' => 'Jumlah Desimal Mata Uang',
                    'currency-rounding'       => 'Pembulatan Mata Uang',
                    'currency-status'         => 'Status Mata Uang',
                    'company-foundation-date' => 'Tanggal Pendirian Perusahaan',
                    'currency-create'         => 'Buat Mata Uang',
                    'status'                  => 'Status',
                ],
            ],

            'branding' => [
                'title'   => 'Branding',
                'entries' => [
                    'company-logo' => 'Logo Perusahaan',
                    'color'        => 'Warna',
                ],
            ],

            'contact-information' => [
                'title'   => 'Informasi Kontak',
                'entries' => [
                    'email'  => 'Alamat Email',
                    'phone'  => 'Nomor Telepon',
                    'mobile' => 'Nomor Telepon',
                ],
            ],
        ],
    ],
];
