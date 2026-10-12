<?php

return [
    'title' => 'Pengguna',

    'navigation' => [
        'title' => 'Pengguna',
    ],

    'global-search' => [
        'email' => 'Email',
    ],

    'form' => [
        'validation' => [
            'cannot-remove-last-admin'   => 'Peran admin tidak dapat dicabut dari pengguna admin terakhir.',
            'first-user-must-be-admin'   => 'Pengguna pertama di sistem harus diberi peran admin.',
        ],

        'sections' => [
            'general-information' => [
                'title'  => 'Informasi Umum',
                'fields' => [
                    'name'                  => 'Nama',
                    'email'                 => 'Email',
                    'password'              => 'Kata Sandi',
                    'password-confirmation' => 'Konfirmasi Kata Sandi',
                ],
            ],

            'permissions' => [
                'title'  => 'Izin',
                'fields' => [
                    'roles'                                    => 'Peran',
                    'permissions'                              => 'Izin',
                    'resource-permission'                      => 'Cakupan Akses Data',
                    'resource-permission-self-change-disabled' => 'Anda tidak dapat mengubah cakupan akses data milik Anda sendiri. Minta administrator lain untuk memperbaruinya.',
                    'teams'                                    => 'Tim',
                ],
            ],

            'avatar' => [
                'title' => 'Avatar',
            ],

            'lang-and-status' => [
                'title'  => 'Bahasa & Status',
                'fields' => [
                    'language' => 'Bahasa Pilihan',
                    'status'   => 'Status',
                ],
            ],

            'multi-company' => [
                'title'                       => 'Multi Perusahaan',
                'allowed-companies'           => 'Perusahaan yang Diizinkan',
                'default-company'             => 'Perusahaan Bawaan',
                'default-company-not-allowed' => 'Perusahaan bawaan harus termasuk salah satu perusahaan yang diizinkan.',
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'avatar'              => 'Avatar',
            'name'                => 'Nama',
            'email'               => 'Email',
            'teams'               => 'Tim',
            'role'                => 'Peran',
            'resource-permission' => 'Cakupan Akses Data',
            'default-company'     => 'Perusahaan Bawaan',
            'allowed-company'     => 'Perusahaan yang Diizinkan',
            'created-by'          => 'Dibuat Oleh',
            'created-at'          => 'Dibuat Pada',
            'updated-at'          => 'Diperbarui Pada',
        ],

        'filters' => [
            'resource-permission' => 'Cakupan Akses Data',
            'teams'               => 'Tim',
            'roles'               => 'Peran',
            'default-company'     => 'Perusahaan Bawaan',
            'allowed-companies'   => 'Perusahaan yang Diizinkan',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Pengguna berhasil diperbarui',
                    'body'  => 'Pengguna telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Pengguna berhasil dihapus',
                    'body'  => 'Pengguna telah berhasil dihapus.',
                    'error' => [
                        'title' => 'Pengguna Tidak Dapat Dihapus',
                        'body'  => 'Ini adalah pengguna bawaan, atau Anda tidak dapat menghapus akun Anda sendiri.',
                    ],
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Pengguna berhasil dipulihkan',
                    'body'  => 'Pengguna telah berhasil dipulihkan.',
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Pengguna berhasil dipulihkan',
                    'body'  => 'Pengguna yang dipilih telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Pengguna berhasil dihapus',
                    'body'  => 'Pengguna yang dipilih telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Pengguna berhasil dihapus permanen',
                    'body'  => 'Pengguna yang dipilih telah berhasil dihapus permanen.',
                    'error' => [
                        'title' => 'Pengguna tidak dapat dihapus',
                        'body'  => 'Pengguna tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'empty-state-actions' => [
            'create' => [
                'notification' => [
                    'title' => 'Pengguna berhasil dibuat',
                    'body'  => 'Pengguna telah berhasil dibuat.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'general-information' => [
                'title'   => 'Informasi Umum',
                'entries' => [
                    'name'                  => 'Nama',
                    'email'                 => 'Email',
                    'password'              => 'Kata Sandi',
                    'password-confirmation' => 'Konfirmasi Kata Sandi',
                ],
            ],

            'permissions' => [
                'title'   => 'Izin',
                'entries' => [
                    'roles'               => 'Peran',
                    'permissions'         => 'Izin',
                    'resource-permission' => 'Cakupan Akses Data',
                    'teams'               => 'Tim',
                ],
            ],

            'avatar' => [
                'title' => 'Avatar',
            ],

            'lang-and-status' => [
                'title'   => 'Bahasa & Status',
                'entries' => [
                    'language' => 'Bahasa Pilihan',
                    'status'   => 'Status',
                ],
            ],

            'multi-company' => [
                'title'                       => 'Multi Perusahaan',
                'allowed-companies'           => 'Perusahaan yang Diizinkan',
                'default-company'             => 'Perusahaan Bawaan',
                'default-company-not-allowed' => 'Perusahaan bawaan harus termasuk salah satu perusahaan yang diizinkan.',
            ],
        ],
    ],
];
