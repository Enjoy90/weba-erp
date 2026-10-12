<?php

return [
    'form' => [
        'tabs' => [
            'general-information' => [
                'title' => 'Informasi Umum',

                'sections' => [
                    'branch-information' => [
                        'title' => 'Informasi Cabang',

                        'fields' => [
                            'company-name'                => 'Nama Perusahaan',
                            'registration-number'         => 'Nomor Registrasi',
                            'tax-id'                      => 'NPWP',
                            'tax-id-tooltip'              => 'NPWP adalah nomor identitas unik perusahaan Anda untuk keperluan pajak.',
                            'color'                       => 'Warna',
                            'company-id'                  => 'ID Perusahaan',
                            'company-id-tooltip'          => 'ID Perusahaan adalah pengenal unik untuk perusahaan Anda.',
                        ],
                    ],

                    'branding' => [
                        'title'  => 'Branding',
                        'fields' => [
                            'branch-logo' => 'Logo Cabang',
                        ],
                    ],
                ],
            ],

            'address-information' => [
                'title' => 'Informasi Alamat',

                'sections' => [
                    'address-information' => [
                        'title' => 'Informasi Alamat',

                        'fields' => [
                            'street1'                => 'Jalan 1',
                            'street2'                => 'Jalan 2',
                            'city'                   => 'Kota',
                            'zip'                    => 'Kode Pos',
                            'country'                => 'Negara',
                            'country-currency-name'  => 'Nama Mata Uang',
                            'country-phone-code'     => 'Kode Telepon',
                            'country-code'           => 'Kode',
                            'country-name'           => 'Nama Negara',
                            'country-state-required' => 'Provinsi Wajib Diisi',
                            'country-zip-required'   => 'Kode Pos Wajib Diisi',
                            'country-create'         => 'Buat Negara',
                            'state'                  => 'Provinsi',
                            'state-name'             => 'Nama Provinsi',
                            'state-code'             => 'Kode Provinsi',
                            'zip-code'               => 'Kode Pos',
                            'state-create'           => 'Buat Provinsi',
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
                            'currency-create'         => 'Buat Mata Uang',
                            'company-foundation-date' => 'Tanggal Pendirian Perusahaan',
                            'status'                  => 'Status',
                        ],
                    ],
                ],
            ],

            'contact-information' => [
                'title' => 'Informasi Kontak',

                'sections' => [
                    'contact-information' => [
                        'title' => 'Informasi Kontak',

                        'fields' => [
                            'email-address' => 'Alamat Email',
                            'phone-number'  => 'Nomor Telepon',
                            'mobile-number' => 'Nomor Telepon',
                        ],
                    ],
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'logo'                 => 'Logo',
            'company-name'         => 'Nama Cabang',
            'branches'             => 'Cabang',
            'email'                => 'Email',
            'city'                 => 'Kota',
            'country'              => 'Negara',
            'currency'             => 'Mata Uang',
            'status'               => 'Status',
            'created-at'           => 'Dibuat Pada',
            'updated-at'           => 'Diperbarui Pada',
        ],

        'groups' => [
            'company-name' => 'Nama Cabang',
            'city'         => 'Kota',
            'country'      => 'Negara',
            'state'        => 'Provinsi',
            'email'        => 'Email',
            'phone'        => 'Telepon',
            'currency'     => 'Mata Uang',
            'created-at'   => 'Dibuat Pada',
            'updated-at'   => 'Diperbarui Pada',
        ],

        'filters' => [
            'trashed' => 'Terhapus',
            'status'  => 'Status',
            'country' => 'Negara',
        ],

        'header-actions' => [
            'create' => [
                'notification' => [
                    'title' => 'Cabang berhasil dibuat',
                    'body'  => 'Cabang telah berhasil dibuat.',
                ],
            ],
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Cabang berhasil diperbarui',
                    'body'  => 'Cabang telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Cabang berhasil dihapus',
                    'body'  => 'Cabang telah berhasil dihapus.',
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Cabang berhasil dipulihkan',
                    'body'  => 'Cabang telah berhasil dipulihkan.',
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Cabang berhasil dipulihkan',
                    'body'  => 'Cabang yang dipilih telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Cabang berhasil dihapus',
                    'body'  => 'Cabang yang dipilih telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Cabang berhasil dihapus permanen',
                    'body'  => 'Cabang yang dipilih telah berhasil dihapus permanen.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'tabs' => [
            'general-information' => [
                'title' => 'Informasi Umum',

                'sections' => [
                    'branch-information' => [
                        'title' => 'Informasi Cabang',

                        'entries' => [
                            'company-name'                => 'Nama Perusahaan',
                            'registration-number'         => 'Nomor Registrasi',
                            'tax-id'                      => 'NPWP',
                            'registration-number-tooltip' => 'NPWP adalah nomor identitas unik perusahaan Anda untuk keperluan pajak.',
                            'color'                       => 'Warna',
                        ],
                    ],

                    'branding' => [
                        'title'   => 'Branding',
                        'entries' => [
                            'branch-logo' => 'Logo Cabang',
                        ],
                    ],
                ],
            ],

            'address-information' => [
                'title' => 'Informasi Alamat',

                'sections' => [
                    'address-information' => [
                        'title' => 'Informasi Alamat',

                        'entries' => [
                            'street1'                => 'Jalan 1',
                            'street2'                => 'Jalan 2',
                            'city'                   => 'Kota',
                            'zip'                    => 'Kode Pos',
                            'country'                => 'Negara',
                            'country-currency-name'  => 'Nama Mata Uang',
                            'country-phone-code'     => 'Kode Telepon',
                            'country-code'           => 'Kode',
                            'country-name'           => 'Nama Negara',
                            'country-state-required' => 'Provinsi Wajib Diisi',
                            'country-zip-required'   => 'Kode Pos Wajib Diisi',
                            'country-create'         => 'Buat Negara',
                            'state'                  => 'Provinsi',
                            'state-name'             => 'Nama Provinsi',
                            'state-code'             => 'Kode Provinsi',
                            'zip-code'               => 'Kode Pos',
                            'state-create'           => 'Buat Provinsi',
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
                            'currency-create'         => 'Buat Mata Uang',
                            'company-foundation-date' => 'Tanggal Pendirian Perusahaan',
                            'status'                  => 'Status',
                        ],
                    ],
                ],
            ],

            'contact-information' => [
                'title' => 'Informasi Kontak',

                'sections' => [
                    'contact-information' => [
                        'title' => 'Informasi Kontak',

                        'entries' => [
                            'email-address' => 'Alamat Email',
                            'phone-number'  => 'Nomor Telepon',
                            'mobile-number' => 'Nomor Telepon',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
