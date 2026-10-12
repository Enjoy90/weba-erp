<?php

return [
    'navigation' => [
        'title' => 'Jenis Operasi',
        'group' => 'Manajemen Gudang',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'fields' => [
                    'operator-type'             => 'Jenis Operasi',
                    'operator-type-placeholder' => 'mis. Penerimaan',
                ],
            ],

            'applicable-on' => [
                'title'       => 'Berlaku Pada',
                'description' => 'Pilih tempat rute ini dapat dipilih.',

                'fields' => [
                ],
            ],
        ],

        'tabs' => [
            'general' => [
                'title'  => 'Umum',

                'fields' => [
                    'operator-type'                      => 'Jenis Operasi',
                    'sequence-prefix'                    => 'Prefiks Urutan',
                    'generate-shipping-labels'           => 'Buat Label Pengiriman',
                    'warehouse'                          => 'Gudang',
                    'show-reception-report'              => 'Tampilkan Laporan Penerimaan saat Validasi',
                    'show-reception-report-hint-tooltip' => 'Jika dipilih, sistem akan otomatis menampilkan laporan penerimaan saat validasi, selama ada pergerakan yang perlu dialokasikan.',
                    'company'                            => 'Perusahaan',
                    'return-type'                        => 'Jenis Retur',
                    'create-backorder'                   => 'Buat Backorder',
                    'move-type'                          => 'Jenis Pergerakan',
                    'move-type-hint-tooltip'             => 'Kecuali ditentukan oleh dokumen sumber, ini akan menjadi kebijakan pengambilan bawaan untuk jenis operasi ini.',
                ],

                'fieldsets' => [
                    'lots' => [
                        'title'  => 'Lot/Nomor Seri',

                        'fields' => [
                            'create-new'                => 'Buat Baru',
                            'create-new-hint-tooltip'   => 'Jika dipilih, sistem menganggap Anda ingin membuat Lot/Nomor Seri baru, sehingga Anda dapat mengisinya di kolom teks.',
                            'use-existing'              => 'Gunakan yang Ada',
                            'use-existing-hint-tooltip' => 'Jika dipilih, Anda dapat memilih Lot/Nomor Seri atau tidak menetapkan sama sekali. Dengan begitu stok dapat dibuat tanpa lot atau tanpa batasan lot yang digunakan.',
                        ],
                    ],

                    'locations' => [
                        'title'  => 'Lokasi',

                        'fields' => [
                            'source-location'                   => 'Lokasi Sumber',
                            'source-location-hint-tooltip'      => 'Ini menjadi lokasi sumber bawaan saat operasi ini dibuat secara manual. Namun, lokasi dapat diubah nanti, dan rute dapat menetapkan lokasi bawaan yang berbeda.',
                            'destination-location'              => 'Lokasi Tujuan',
                            'destination-location-hint-tooltip' => 'Ini adalah lokasi tujuan bawaan untuk operasi yang dibuat secara manual. Namun, lokasi dapat diubah nanti, dan rute dapat menetapkan lokasi bawaan yang berbeda.',
                        ],
                    ],

                    'packages' => [
                        'title'  => 'Paket',

                        'fields' => [
                            'show-entire-package'              => 'Pindahkan Seluruh Paket',
                            'show-entire-package-hint-tooltip' => 'Jika dipilih, Anda dapat memindahkan paket secara utuh.',
                        ],
                    ],
                ],
            ],

            'hardware' => [
                'title'  => 'Perangkat Keras',

                'fieldsets' => [
                    'print-on-validation' => [
                        'title'  => 'Cetak saat Validasi',

                        'fields' => [
                            'delivery-slip'              => 'Surat Jalan',
                            'delivery-slip-hint-tooltip' => 'Jika dipilih, sistem akan otomatis mencetak surat jalan saat pengambilan divalidasi.',

                            'return-slip'              => 'Slip Retur',
                            'return-slip-hint-tooltip' => 'Jika dipilih, sistem akan otomatis mencetak slip retur saat pengambilan divalidasi.',

                            'product-labels'              => 'Label Produk',
                            'product-labels-hint-tooltip' => 'Jika dipilih, sistem akan otomatis mencetak label produk saat pengambilan divalidasi.',

                            'lots-labels'              => 'Label Lot/NS',
                            'lots-labels-hint-tooltip' => 'Jika dipilih, sistem akan otomatis mencetak label lot/nomor seri saat pengambilan divalidasi.',

                            'reception-report'              => 'Laporan Penerimaan',
                            'reception-report-hint-tooltip' => 'Jika dipilih, sistem akan otomatis mencetak laporan penerimaan saat pengambilan divalidasi dan memiliki pergerakan yang telah ditetapkan.',

                            'reception-report-labels'              => 'Label Laporan Penerimaan',
                            'reception-report-labels-hint-tooltip' => 'Jika dipilih, sistem akan otomatis mencetak label laporan penerimaan saat pengambilan divalidasi.',

                            'package-content'              => 'Isi Paket',
                            'package-content-hint-tooltip' => 'Jika dipilih, sistem akan otomatis mencetak detail paket beserta isinya saat pengambilan divalidasi.',
                        ],
                    ],

                    'print-on-pack' => [
                        'title'  => 'Cetak saat "Masukkan ke Paket"',

                        'fields' => [
                            'package-label'              => 'Label Paket',
                            'package-label-hint-tooltip' => 'Jika dipilih, sistem akan otomatis mencetak label paket saat tombol "Masukkan ke Paket" digunakan.',
                        ],
                    ],
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'       => 'Nama',
            'warehouse'  => 'Gudang',
            'company'    => 'Perusahaan',
            'deleted-at' => 'Dihapus Pada',
            'created-at' => 'Dibuat Pada',
            'updated-at' => 'Diperbarui Pada',
        ],

        'groups' => [
            'type'       => 'Jenis',
            'warehouse'  => 'Gudang',
            'created-at' => 'Dibuat Pada',
            'updated-at' => 'Diperbarui Pada',
        ],

        'filters' => [
            'type'      => 'Jenis',
            'warehouse' => 'Gudang',
            'company'   => 'Perusahaan',
        ],

        'actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Jenis Operasi berhasil dipulihkan',
                    'body'  => 'Jenis operasi telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Jenis Operasi berhasil dihapus',
                    'body'  => 'Jenis operasi telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Jenis Operasi berhasil dihapus permanen',
                        'body'  => 'Jenis operasi telah berhasil dihapus permanen.',
                    ],

                    'error' => [
                        'title' => 'Jenis Operasi tidak dapat dihapus',
                        'body'  => 'Jenis operasi tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Data jenis operasi berhasil dipulihkan',
                    'body'  => 'Data jenis operasi telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Data jenis operasi berhasil dihapus',
                    'body'  => 'Data jenis operasi telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Data jenis operasi berhasil dihapus permanen',
                        'body'  => 'Data jenis operasi telah berhasil dihapus permanen.',
                    ],

                    'error' => [
                        'title' => 'Data jenis operasi tidak dapat dihapus',
                        'body'  => 'Data jenis operasi tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'empty-actions' => [
            'create' => [
                'label' => 'Buat Jenis Operasi',
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title' => 'Informasi Umum',

                'entries' => [
                    'name' => 'Nama',
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

        'tabs' => [
            'general' => [
                'title' => 'Umum',

                'entries' => [
                    'type'                       => 'Jenis Operasi',
                    'sequence_code'              => 'Kode Urutan',
                    'print_label'                => 'Cetak Label',
                    'warehouse'                  => 'Gudang',
                    'reservation_method'         => 'Metode Pencadangan',
                    'auto_show_reception_report' => 'Tampilkan Laporan Penerimaan Otomatis',
                    'company'                    => 'Perusahaan',
                    'return_operation_type'      => 'Jenis Operasi Retur',
                    'create_backorder'           => 'Buat Backorder',
                    'move_type'                  => 'Jenis Pergerakan',
                ],

                'fieldsets' => [
                    'lots' => [
                        'title' => 'Lot',

                        'entries' => [
                            'use_create_lots'   => 'Buat Lot Baru',
                            'use_existing_lots' => 'Gunakan Lot yang Ada',
                        ],
                    ],

                    'locations' => [
                        'title' => 'Lokasi',

                        'entries' => [
                            'source_location'      => 'Lokasi Sumber',
                            'destination_location' => 'Lokasi Tujuan',
                        ],
                    ],
                ],
            ],
            'hardware' => [
                'title' => 'Perangkat Keras',

                'fieldsets' => [
                    'print_on_validation' => [
                        'title' => 'Cetak saat Validasi',

                        'entries' => [
                            'auto_print_delivery_slip'           => 'Cetak Otomatis Surat Jalan',
                            'auto_print_return_slip'             => 'Cetak Otomatis Slip Retur',
                            'auto_print_product_labels'          => 'Cetak Otomatis Label Produk',
                            'auto_print_lot_labels'              => 'Cetak Otomatis Label Lot',
                            'auto_print_reception_report'        => 'Cetak Otomatis Laporan Penerimaan',
                            'auto_print_reception_report_labels' => 'Cetak Otomatis Label Laporan Penerimaan',
                            'auto_print_packages'                => 'Cetak Otomatis Paket',
                        ],
                    ],

                    'print_on_pack' => [
                        'title' => 'Cetak saat Pengemasan',

                        'entries' => [
                            'auto_print_package_label' => 'Cetak Otomatis Label Paket',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
