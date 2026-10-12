<?php

return [
    'table' => [
        'columns' => [
            'on-hand'    => 'Tersedia',
            'forecasted' => 'Perkiraan',
        ],
    ],

    'navigation' => [
        'title' => 'Produk',
        'group' => 'Inventaris',
    ],

    'form' => [
        'sections' => [
            'inventory' => [
                'title' => 'Inventaris',

                'fieldsets' => [
                    'tracking' => [
                        'title' => 'Pelacakan',

                        'fields' => [
                            'track-inventory'              => 'Lacak Inventaris',
                            'track-inventory-hint-tooltip' => 'Produk yang dapat disimpan adalah produk yang memerlukan pengelolaan inventaris.',
                            'track-by'                     => 'Lacak Berdasarkan',
                            'expiration-date'              => 'Tanggal Kedaluwarsa',
                            'expiration-date-hint-tooltip' => 'Jika dipilih, Anda dapat menentukan tanggal kedaluwarsa untuk produk dan lot/nomor seri terkait.',
                        ],
                    ],

                    'operation' => [
                        'title' => 'Operasi',

                        'fields' => [
                            'routes'              => 'Rute',
                            'routes-hint-tooltip' => 'Berdasarkan modul yang terpasang, pengaturan ini memungkinkan Anda menentukan rute produk, seperti pembelian, produksi, atau pengisian ulang sesuai pesanan.',
                        ],
                    ],

                    'logistics' => [
                        'title' => 'Logistik',

                        'fields' => [
                            'responsible'              => 'Penanggung Jawab',
                            'responsible-hint-tooltip' => 'Waktu tunggu pengiriman (dalam hari) adalah durasi yang dijanjikan antara konfirmasi pesanan penjualan dan pengiriman produk.',
                            'weight'                   => 'Berat',
                            'volume'                   => 'Volume',
                            'sale-delay'               => 'Waktu Tunggu Pelanggan (Hari)',
                            'sale-delay-hint-tooltip'  => 'Waktu tunggu pengiriman (dalam hari) adalah durasi yang dijanjikan antara konfirmasi pesanan penjualan dan pengiriman produk.',
                        ],
                    ],

                    'traceability' => [
                        'title' => 'Ketertelusuran',

                        'fields' => [
                            'expiration-date'               => 'Tanggal Kedaluwarsa (Hari)',
                            'expiration-date-hint-tooltip'  => 'Jika dipilih, Anda dapat mengatur tanggal kedaluwarsa untuk produk dan lot/nomor seri terkait.',
                            'best-before-date'              => 'Tanggal Baik Digunakan Sebelum (Hari)',
                            'best-before-date-hint-tooltip' => 'Jumlah hari sebelum tanggal kedaluwarsa saat kualitas produk mulai menurun, meskipun masih aman digunakan. Dihitung berdasarkan lot/nomor seri.',
                            'removal-date'                  => 'Tanggal Penarikan (Hari)',
                            'removal-date-hint-tooltip'     => 'Jumlah hari sebelum tanggal kedaluwarsa saat produk harus ditarik dari stok. Dihitung berdasarkan lot/nomor seri.',
                            'alert-date'                    => 'Tanggal Peringatan (Hari)',
                            'alert-date-hint-tooltip'       => 'Jumlah hari sebelum tanggal kedaluwarsa saat peringatan harus dipicu untuk lot/nomor seri. Dihitung berdasarkan lot/nomor seri.',
                        ],
                    ],
                ],
            ],

            'additional' => [
                'title' => 'Tambahan',
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'inventory' => [
                'title' => 'Inventaris',

                'entries' => [
                ],

                'fieldsets' => [
                    'tracking' => [
                        'title' => 'Pelacakan',

                        'entries' => [
                            'track-inventory' => 'Lacak Inventaris',
                            'track-by'        => 'Lacak Berdasarkan',
                            'expiration-date' => 'Tanggal Kedaluwarsa',
                        ],
                    ],

                    'operation' => [
                        'title' => 'Operasi',

                        'entries' => [
                            'routes' => 'Rute',
                        ],
                    ],

                    'logistics' => [
                        'title' => 'Logistik',

                        'entries' => [
                            'responsible' => 'Penanggung Jawab',
                            'weight'      => 'Berat',
                            'volume'      => 'Volume',
                            'sale-delay'  => 'Waktu Tunggu Pelanggan (Hari)',
                        ],
                    ],

                    'traceability' => [
                        'title' => 'Ketertelusuran',

                        'entries' => [
                            'expiration-date'  => 'Tanggal Kedaluwarsa (Hari)',
                            'best-before-date' => 'Tanggal Baik Digunakan Sebelum (Hari)',
                            'removal-date'     => 'Tanggal Penarikan (Hari)',
                            'alert-date'       => 'Tanggal Peringatan (Hari)',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
