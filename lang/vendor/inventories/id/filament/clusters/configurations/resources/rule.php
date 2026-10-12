<?php

return [
    'navigation' => [
        'title' => 'Aturan',
        'group' => 'Manajemen Gudang',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title'  => 'Umum',

                'fields' => [
                    'name'                        => 'Nama',
                    'action'                      => 'Tindakan',
                    'operation-type'              => 'Jenis Operasi',
                    'source-location'             => 'Lokasi Sumber',
                    'destination-location'        => 'Lokasi Tujuan',
                    'supply-method'               => 'Metode Pasokan',
                    'supply-method-hint-tooltip'  => 'Ambil dari Stok: Produk diambil langsung dari stok yang tersedia di lokasi sumber.<br/>Picu Aturan Lain: Sistem mengabaikan stok yang tersedia dan mencari aturan stok untuk mengisi ulang lokasi sumber.<br/>Ambil dari Stok, jika Tidak Tersedia, Picu Aturan Lain: Produk diambil terlebih dahulu dari stok yang tersedia. Jika tidak ada, sistem menerapkan aturan stok untuk membawa produk ke lokasi sumber.',
                    'automatic-move'              => 'Pergerakan Otomatis',
                    'automatic-move-hint-tooltip' => 'Operasi Manual: Membuat pergerakan stok terpisah setelah pergerakan saat ini.<br/>Otomatis Tanpa Langkah Tambahan: Langsung mengganti lokasi pada pergerakan awal tanpa menambah langkah.',

                    'action-information' => [
                        'pull'        => 'Saat produk dibutuhkan di <b>:sourceLocation</b>, :operation dibuat dari <b>:destinationLocation</b> untuk memenuhi permintaan.',
                        'push'        => 'Saat produk tiba di <b>:sourceLocation</b>,</br><b>:operation</b> dibuat untuk memindahkannya ke <b>:destinationLocation</b>.',
                        'buy'         => 'Saat produk dibutuhkan di <b>:destinationLocation</b>, permintaan penawaran dibuat untuk memenuhi kebutuhan tersebut.',
                        'manufacture' => 'Saat produk dibutuhkan di <b>:destinationLocation</b>, order produksi dibuat untuk memenuhi kebutuhan tersebut.',
                    ],
                ],
            ],

            'settings' => [
                'title'  => 'Pengaturan',

                'fields' => [
                    'partner-address'              => 'Alamat Mitra',
                    'partner-address-hint-tooltip' => 'Alamat tujuan pengiriman barang. Opsional.',
                    'lead-time'                    => 'Waktu Tunggu (Hari)',
                    'lead-time-hint-tooltip'       => 'Tanggal transfer yang diharapkan dihitung berdasarkan waktu tunggu ini.',
                ],

                'fieldsets' => [
                    'applicability' => [
                        'title'  => 'Keberlakuan',

                        'fields' => [
                            'route'   => 'Rute',
                            'company' => 'Perusahaan',
                        ],
                    ],

                    'propagation' => [
                        'title'  => 'Penerusan',

                        'fields' => [
                            'propagation-procurement-group'              => 'Penerusan Grup Pengadaan',
                            'propagation-procurement-group-hint-tooltip' => 'Jika dipilih, membatalkan pergerakan yang dibuat oleh aturan ini juga akan membatalkan pergerakan berikutnya.',
                            'cancel-next-move'                           => 'Batalkan Pergerakan Berikutnya',
                            'warehouse-to-propagate'                     => 'Gudang yang Diteruskan',
                            'warehouse-to-propagate-hint-tooltip'        => 'Gudang yang ditetapkan pada pergerakan atau pengadaan yang dibuat, yang dapat berbeda dari gudang tempat aturan ini berlaku (mis. untuk aturan pasokan ulang dari gudang lain).',
                        ],
                    ],
                ],

            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'                 => 'Nama',
            'action'               => 'Tindakan',
            'source-location'      => 'Lokasi Sumber',
            'destination-location' => 'Lokasi Tujuan',
            'route'                => 'Rute',
            'deleted-at'           => 'Dihapus Pada',
            'created-at'           => 'Dibuat Pada',
            'updated-at'           => 'Diperbarui Pada',
        ],

        'groups' => [
            'action'               => 'Tindakan',
            'source-location'      => 'Lokasi Sumber',
            'destination-location' => 'Lokasi Tujuan',
            'route'                => 'Rute',
            'created-at'           => 'Dibuat Pada',
            'updated-at'           => 'Diperbarui Pada',
        ],

        'filters' => [
            'action'               => 'Tindakan',
            'source-location'      => 'Lokasi Sumber',
            'destination-location' => 'Lokasi Tujuan',
            'route'                => 'Rute',
            'company'              => 'Perusahaan',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Aturan berhasil diperbarui',
                    'body'  => 'Aturan telah berhasil diperbarui.',
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Aturan berhasil dipulihkan',
                    'body'  => 'Aturan telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Aturan berhasil dihapus',
                    'body'  => 'Aturan telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Aturan berhasil dihapus permanen',
                        'body'  => 'Aturan telah berhasil dihapus permanen.',
                    ],

                    'error' => [
                        'title' => 'Aturan tidak dapat dihapus',
                        'body'  => 'Aturan tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Data aturan berhasil dipulihkan',
                    'body'  => 'Data aturan telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Data aturan berhasil dihapus',
                    'body'  => 'Data aturan telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Data aturan berhasil dihapus permanen',
                        'body'  => 'Data aturan telah berhasil dihapus permanen.',
                    ],

                    'error' => [
                        'title' => 'Data aturan tidak dapat dihapus',
                        'body'  => 'Data aturan tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title' => 'Detail Aturan',

                'description' => [
                    'pull' => 'Saat produk dibutuhkan di <b>:sourceLocation</b>, <b>:operation</b> dibuat dari <b>:destinationLocation</b> untuk memenuhi permintaan.',
                    'push' => 'Saat produk tiba di <b>:sourceLocation</b>, <b>:operation</b> dibuat untuk memindahkannya ke <b>:destinationLocation</b>.',
                ],

                'entries' => [
                    'name'                 => 'Nama Aturan',
                    'action'               => 'Tindakan',
                    'operation-type'       => 'Jenis Operasi',
                    'source-location'      => 'Lokasi Sumber',
                    'destination-location' => 'Lokasi Tujuan',
                    'route'                => 'Rute',
                    'company'              => 'Perusahaan',
                    'partner-address'      => 'Alamat Mitra',
                    'lead-time'            => 'Waktu Tunggu',
                    'action-information'   => 'Informasi Tindakan',
                ],
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
