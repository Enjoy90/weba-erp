<?php

return [
    'form' => [
        'tabs' => [
            'journal-entries' => [
                'title' => 'Entri Jurnal',

                'field-set' => [
                    'accounting-information' => [
                        'title'  => 'Informasi Akuntansi',
                        'fields' => [
                            'dedicated-credit-note-sequence' => 'Urutan Khusus Nota Kredit',
                            'dedicated-payment-sequence'     => 'Urutan Khusus Pembayaran',
                            'sort-code-placeholder'          => 'Masukkan kode jurnal',
                            'sort-code'                      => 'Kode Singkat',
                            'currency'                       => 'Mata Uang',
                            'color'                          => 'Warna',
                            'default-account'                => 'Akun Bawaan',
                            'profit-account'                 => 'Akun Laba',
                            'loss-account'                   => 'Akun Rugi',
                            'suspense-account'               => 'Akun Penampung',
                            'bank-account'                   => 'Rekening Bank',
                        ],
                    ],

                    'bank-account-number' => [
                        'title' => 'Nomor Rekening Bank',
                    ],
                ],
            ],

            'incoming-payments' => [
                'title'            => 'Pembayaran Masuk',
                'add-action-label' => 'Tambah Baris',

                'fields' => [
                    'payment-method'             => 'Metode Pembayaran',
                    'display-name'               => 'Nama Tampilan',
                    'account-number'             => 'Akun Penerimaan Belum Selesai',
                    'relation-notes'             => 'Catatan Relasi',
                    'relation-notes-placeholder' => 'Masukkan detail relasi',
                ],
            ],

            'outgoing-payments' => [
                'title'            => 'Pembayaran Keluar',
                'add-action-label' => 'Tambah Baris',

                'fields' => [
                    'payment-method'             => 'Metode Pembayaran',
                    'display-name'               => 'Nama Tampilan',
                    'account-number'             => 'Akun Pembayaran Belum Selesai',
                    'relation-notes'             => 'Catatan Relasi',
                    'relation-notes-placeholder' => 'Masukkan detail relasi',
                ],
            ],

            'advanced-settings' => [
                'title'  => 'Pengaturan Lanjutan',

                'fields' => [
                    'allowed-accounts'       => 'Akun yang Diizinkan',
                    'control-access'         => 'Kontrol Akses',
                    'payment-communication'  => 'Keterangan Pembayaran',
                    'auto-check-on-post'     => 'Periksa Otomatis saat Posting',
                    'communication-type'     => 'Jenis Keterangan',
                    'communication-standard' => 'Standar Keterangan',
                ],
            ],
        ],

        'general' => [
            'title' => 'Informasi Umum',

            'fields' => [
                'name'    => 'Nama',
                'type'    => 'Jenis',
                'company' => 'Perusahaan',
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'       => 'Nama',
            'type'       => 'Jenis',
            'code'       => 'Kode',
            'currency'   => 'Mata Uang',
            'created-by' => 'Dibuat oleh',
            'status'     => 'Status',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Jurnal berhasil dihapus',
                        'body'  => 'Jurnal telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Gagal menghapus jurnal',
                        'body'  => 'Jurnal tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Jurnal berhasil dihapus',
                        'body'  => 'Jurnal telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Gagal menghapus jurnal',
                        'body'  => 'Jurnal-jurnal tersebut tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],
    ],

    'infolist' => [
        'tabs' => [
            'journal-entries' => [
                'title' => 'Entri Jurnal',

                'field-set' => [
                    'accounting-information' => [
                        'title'   => 'Informasi Akuntansi',

                        'entries' => [
                            'dedicated-credit-note-sequence' => 'Urutan Khusus Nota Kredit',
                            'dedicated-payment-sequence'     => 'Urutan Khusus Pembayaran',
                            'sort-code-placeholder'          => 'Masukkan kode jurnal',
                            'sort-code'                      => 'Kode Singkat',
                            'currency'                       => 'Mata Uang',
                            'color'                          => 'Warna',
                            'default-account'                => 'Akun Bawaan',
                            'profit-account'                 => 'Akun Laba',
                            'loss-account'                   => 'Akun Rugi',
                            'suspense-account'               => 'Akun Penampung',
                        ],
                    ],

                    'bank-account-number' => [
                        'title' => 'Nomor Rekening Bank',

                        'entries' => [
                            'account-number' => 'Nomor Rekening',
                        ],
                    ],
                ],
            ],

            'incoming-payments' => [
                'title' => 'Pembayaran Masuk',

                'entries' => [
                    'payment-method'             => 'Metode Pembayaran',
                    'display-name'               => 'Nama Tampilan',
                    'account-number'             => 'Akun Penerimaan Belum Selesai',
                    'relation-notes'             => 'Catatan Relasi',
                    'relation-notes-placeholder' => 'Masukkan detail relasi',
                ],
            ],

            'outgoing-payments' => [
                'title' => 'Pembayaran Keluar',

                'entries' => [
                    'payment-method'             => 'Metode Pembayaran',
                    'display-name'               => 'Nama Tampilan',
                    'account-number'             => 'Akun Pembayaran Belum Selesai',
                    'relation-notes'             => 'Catatan Relasi',
                    'relation-notes-placeholder' => 'Masukkan detail relasi',
                ],
            ],

            'advanced-settings' => [
                'title'   => 'Pengaturan Lanjutan',

                'allowed-accounts' => [
                    'title' => 'Akun yang Diizinkan',

                    'entries' => [
                        'allowed-accounts'       => 'Akun yang Diizinkan',
                        'control-access'         => 'Kontrol Akses',
                        'auto-check-on-post'     => 'Periksa Otomatis saat Posting',
                    ],
                ],

                'payment-communication'  => [
                    'title' => 'Keterangan Pembayaran',

                    'entries' => [
                        'communication-type'     => 'Jenis Keterangan',
                        'communication-standard' => 'Standar Keterangan',
                    ],
                ],
            ],
        ],

        'general' => [
            'title' => 'Informasi Umum',

            'entries' => [
                'name'    => 'Nama',
                'type'    => 'Jenis',
                'company' => 'Perusahaan',
            ],
        ],
    ],

];
