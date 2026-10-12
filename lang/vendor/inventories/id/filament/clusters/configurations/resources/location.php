<?php

return [
    'navigation' => [
        'title' => 'Lokasi',
        'group' => 'Manajemen Gudang',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title'  => 'Umum',

                'fields' => [
                    'location'                     => 'Lokasi',
                    'location-placeholder'         => 'mis. Stok Cadangan',
                    'parent-location'              => 'Lokasi Induk',
                    'parent-location-hint-tooltip' => 'Lokasi utama yang mencakup lokasi ini. Contohnya, \'Zona Pengiriman\' merupakan bagian dari lokasi induk \'Gerbang 1\'.',
                    'external-notes'               => 'Catatan Eksternal',
                ],
            ],

            'settings' => [
                'title'  => 'Pengaturan',

                'fields' => [
                    'location-type'                 => 'Jenis Lokasi',
                    'company'                       => 'Perusahaan',
                    'storage-category'              => 'Kategori Penyimpanan',
                    'is-scrap'                      => 'Lokasi Scrap?',
                    'is-scrap-hint-tooltip'         => 'Centang kotak ini untuk menetapkan lokasi ini sebagai tempat penyimpanan barang scrap atau rusak.',
                    'is-dock'                       => 'Lokasi Dok?',
                    'is-dock-hint-tooltip'          => 'Centang kotak ini untuk menetapkan lokasi ini sebagai tempat penyimpanan barang yang siap dikirim.',
                    'is-replenish'                  => 'Lokasi Pengisian Ulang?',
                    'is-replenish-hint-tooltip'     => 'Aktifkan fungsi ini untuk mengambil semua jumlah yang dibutuhkan untuk pengisian ulang di lokasi ini.',
                    'logistics'                     => 'Logistik',
                    'removal-strategy'              => 'Strategi Pengeluaran',
                    'removal-strategy-hint-tooltip' => 'Menentukan metode bawaan untuk memilih rak, lot, dan lokasi tepat tempat produk diambil. Metode ini dapat diberlakukan pada tingkat kategori produk, dan memakai lokasi induk jika tidak diatur di sini.',
                    'cyclic-counting'               => 'Penghitungan Berkala',
                    'inventory-frequency'           => 'Frekuensi Inventaris',
                    'last-inventory'                => 'Inventaris Terakhir',
                    'last-inventory-hint-tooltip'   => 'Tanggal inventaris terakhir di lokasi ini.',
                    'next-expected'                 => 'Perkiraan berikutnya',
                    'next-expected-hint-tooltip'    => 'Tanggal inventaris terencana berikutnya berdasarkan jadwal berkala.',
                ],
            ],

            'additional' => [
                'title'  => 'Informasi Tambahan',
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'location'         => 'Lokasi',
            'type'             => 'Jenis',
            'storage-category' => 'Kategori Penyimpanan',
            'company'          => 'Perusahaan',
            'deleted-at'       => 'Dihapus Pada',
            'created-at'       => 'Dibuat Pada',
            'updated-at'       => 'Diperbarui Pada',
        ],

        'groups' => [
            'warehouse'       => 'Gudang',
            'type'            => 'Jenis',
            'created-at'      => 'Dibuat Pada',
            'updated-at'      => 'Diperbarui Pada',
        ],

        'filters' => [
            'location' => 'Lokasi',
            'type'     => 'Jenis',
            'company'  => 'Perusahaan',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Lokasi berhasil diperbarui',
                    'body'  => 'Lokasi telah berhasil diperbarui.',
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Lokasi berhasil dipulihkan',
                    'body'  => 'Lokasi telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Lokasi berhasil dihapus',
                    'body'  => 'Lokasi telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Lokasi berhasil dihapus permanen',
                        'body'  => 'Lokasi telah berhasil dihapus permanen.',
                    ],

                    'error' => [
                        'title' => 'Lokasi tidak dapat dihapus',
                        'body'  => 'Lokasi tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'print' => [
                'label' => 'Cetak Barcode',
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Data lokasi berhasil dipulihkan',
                    'body'  => 'Data lokasi telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Data lokasi berhasil dihapus',
                    'body'  => 'Data lokasi telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Data lokasi berhasil dihapus permanen',
                        'body'  => 'Data lokasi telah berhasil dihapus permanen.',
                    ],

                    'error' => [
                        'title' => 'Data lokasi tidak dapat dihapus',
                        'body'  => 'Data lokasi tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title'  => 'Umum',

                'entries' => [
                    'location'                     => 'Lokasi',
                    'location-placeholder'         => 'mis. Stok Cadangan',
                    'parent-location'              => 'Lokasi Induk',
                    'parent-location-hint-tooltip' => 'Lokasi utama yang mencakup lokasi ini. Contohnya, \'Zona Pengiriman\' merupakan bagian dari lokasi induk \'Gerbang 1\'.',
                    'external-notes'               => 'Catatan Eksternal',
                ],
            ],

            'settings' => [
                'title'  => 'Pengaturan',

                'entries' => [
                    'location-type'                 => 'Jenis Lokasi',
                    'company'                       => 'Perusahaan',
                    'storage-category'              => 'Kategori Penyimpanan',
                    'is-scrap'                      => 'Lokasi Scrap?',
                    'is-scrap-hint-tooltip'         => 'Centang kotak ini untuk menetapkan lokasi ini sebagai tempat penyimpanan barang scrap atau rusak.',
                    'is-dock'                       => 'Lokasi Dok?',
                    'is-dock-hint-tooltip'          => 'Centang kotak ini untuk menetapkan lokasi ini sebagai tempat penyimpanan barang yang siap dikirim.',
                    'is-replenish'                  => 'Lokasi Pengisian Ulang?',
                    'is-replenish-hint-tooltip'     => 'Aktifkan fungsi ini untuk mengambil semua jumlah yang dibutuhkan untuk pengisian ulang di lokasi ini.',
                    'logistics'                     => 'Logistik',
                    'removal-strategy'              => 'Strategi Pengeluaran',
                    'removal-strategy-hint-tooltip' => 'Menentukan metode bawaan untuk memilih rak, lot, dan lokasi tepat tempat produk diambil. Metode ini dapat diberlakukan pada tingkat kategori produk, dan memakai lokasi induk jika tidak diatur di sini.',
                    'cyclic-counting'               => 'Penghitungan Berkala',
                    'inventory-frequency'           => 'Frekuensi Inventaris',
                    'last-inventory'                => 'Inventaris Terakhir',
                    'last-inventory-hint-tooltip'   => 'Tanggal inventaris terakhir di lokasi ini.',
                    'next-expected'                 => 'Perkiraan berikutnya',
                    'next-expected-hint-tooltip'    => 'Tanggal inventaris terencana berikutnya berdasarkan jadwal berkala.',
                ],
            ],

            'additional' => [
                'title'  => 'Informasi Tambahan',
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
