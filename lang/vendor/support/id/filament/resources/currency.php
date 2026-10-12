<?php

return [
    'title' => 'Mata Uang',

    'navigation' => [
        'title' => 'Mata Uang',
    ],

    'form' => [
        'sections' => [
            'currency-details' => [
                'title' => 'Informasi Mata Uang',

                'fields' => [
                    'name'         => 'Nama Mata Uang',
                    'name-tooltip' => 'Masukkan nama resmi mata uang',
                    'symbol'       => 'Simbol Mata Uang',
                    'full-name'    => 'Nama Lengkap',
                    'iso-numeric'  => 'Kode Numerik ISO',
                ],
            ],

            'format-information' => [
                'title' => 'Konfigurasi Format',

                'fields' => [
                    'decimal-places'        => 'Jumlah Desimal',
                    'rounding'              => 'Presisi Pembulatan',
                    'rounding-helper-text'  => 'Atur presisi pembulatan untuk perhitungan mata uang',
                ],
            ],

            'status-and-configuration-information' => [
                'title' => 'Status & Konfigurasi',

                'fields' => [
                    'status' => 'Status',
                ],
            ],

            'rates' => [
                'title'       => 'Kurs Mata Uang',
                'description' => 'Kelola riwayat kurs mata uang ini terhadap mata uang dasar (USD).',

                'fields' => [
                    'name'              => 'Tanggal',
                    'unit-per-currency' => 'Unit per :currency',
                    'currency-per-unit' => ':currency per Unit',
                ],

                'add-rate'   => 'Tambah Kurs',
                'item-label' => 'Kurs',
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'           => 'Nama Mata Uang',
            'symbol'         => 'Simbol',
            'full-name'      => 'Nama Lengkap',
            'iso-numeric'    => 'Kode ISO',
            'decimal-places' => 'Jumlah Desimal',
            'rounding'       => 'Pembulatan',
            'status'         => 'Status',
            'created-at'     => 'Dibuat Pada',
            'updated-at'     => 'Diperbarui Pada',
        ],

        'groups' => [
            'name'           => 'Nama',
            'status'         => 'Status',
            'decimal-places' => 'Jumlah Desimal',
            'creation-date'  => 'Tanggal Dibuat',
            'last-update'    => 'Pembaruan Terakhir',
        ],

        'filters' => [
            'status' => 'Status',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'title'   => 'Mata Uang berhasil dihapus',
                    'body'    => 'Mata uang telah berhasil dihapus.',

                    'success' => [
                        'title' => 'Mata Uang berhasil dihapus',
                        'body'  => 'Mata uang telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Mata Uang tidak dapat dihapus',
                        'body'  => 'Mata uang tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],

            'deactivate' => [
                'notification' => [
                    'title' => 'Mata Uang tidak dapat dinonaktifkan',
                    'body'  => 'Mata uang ini digunakan oleh satu atau beberapa perusahaan sehingga tidak dapat dinonaktifkan.',
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Mata Uang berhasil dihapus',
                    'body'  => 'Mata uang yang dipilih telah berhasil dihapus.',

                    'error' => [
                        'title' => 'Mata Uang tidak dapat dihapus',
                        'body'  => 'Sebagian mata uang yang dipilih sedang digunakan sehingga tidak dapat dihapus.',
                    ],
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'currency-details' => [
                'title' => 'Informasi Mata Uang',

                'entries' => [
                    'name'         => 'Nama Mata Uang',
                    'symbol'       => 'Simbol Mata Uang',
                    'full-name'    => 'Nama Lengkap',
                    'iso-numeric'  => 'Kode Numerik ISO',
                ],
            ],

            'format-information' => [
                'title' => 'Konfigurasi Format',

                'entries' => [
                    'decimal-places' => 'Jumlah Desimal',
                    'rounding'       => 'Presisi Pembulatan',
                ],
            ],

            'status-and-configuration-information' => [
                'title' => 'Status & Konfigurasi',

                'entries' => [
                    'status' => 'Status',
                ],
            ],

            'rates' => [
                'title'       => 'Kurs Mata Uang',

                'entries' => [
                    'name'              => 'Tanggal',
                    'unit-per-currency' => 'Unit per :currency',
                    'currency-per-unit' => ':currency per Unit',
                ],
            ],
        ],
    ],
];
