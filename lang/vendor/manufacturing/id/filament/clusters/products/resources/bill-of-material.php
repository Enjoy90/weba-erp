<?php

return [
    'navigation' => [
        'title' => 'Bill of Materials',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title'  => 'Umum',
                'fields' => [
                    'reference'             => 'Referensi',
                    'reference-placeholder' => 'mis. BOM-001',
                    'product'               => 'Produk',
                    'product-variant'       => 'Varian Produk',
                    'quantity'              => 'Jumlah',
                    'uom'                   => 'Satuan',
                    'operation-type'        => 'Jenis Operasi',
                    'company'               => 'Perusahaan',
                    'type'                  => 'Jenis BoM',
                ],
            ],
            'miscellaneous' => [
                'title'  => 'Lain-lain',
                'fields' => [
                    'kit-information'                         => 'Informasi Kit',
                    'kit-information-content'                 => 'BoM kit digunakan untuk mengelompokkan komponen untuk transfer atau penjualan, bukan untuk diproduksi melalui order produksi.',
                    'manufacturing-lead-time'                 => 'Lead Time Manufaktur',
                    'days-to-prepare-manufacturing-order'     => 'Hari untuk Menyiapkan Order Produksi',
                    'days-suffix'                             => 'hari',
                ],
            ],
        ],
        'tabs' => [
            'components' => [
                'title'      => 'Komponen',
                'add-action' => 'Tambah baris',
                'columns'    => [
                    'component'              => 'Komponen',
                    'apply-on-variants'      => 'Terapkan pada Varian',
                    'consumed-in-operation'  => 'Dipakai pada Operasi',
                    'highlight-consumption'  => 'Sorot Pemakaian',
                    'quantity'               => 'Jumlah',
                    'uom'                    => 'Satuan Produk',
                ],
                'validation' => [
                    'component-different-from-product' => 'Komponen harus berbeda dari produk yang sedang diproduksi.',
                ],
                'create-form' => [
                    'fields' => [
                        'name'            => 'Nama',
                        'type'            => 'Jenis',
                        'category'        => 'Kategori',
                        'company'         => 'Perusahaan',
                        'uom'             => 'Satuan',
                        'uom-placeholder' => 'Satuan',
                    ],
                ],
            ],
            'operations' => [
                'title'      => 'Operasi',
                'add-action' => 'Tambah baris',
                'actions'    => [
                    'edit'                 => 'Ubah Operasi',
                    'copy-existing'        => 'Salin Operasi yang Ada',
                    'copy-existing-fields' => [
                        'operation' => 'Operasi',
                    ],
                ],
                'columns'    => [
                    'operation'        => 'Operasi',
                    'work-center'      => 'Work Center',
                    'time-mode'        => 'Perhitungan Durasi',
                    'time-mode-batch'  => 'Dihitung dari terakhir',
                    'company'          => 'Perusahaan',
                    'apply-on-variants'=> 'Terapkan pada Varian',
                    'duration'         => 'Durasi (menit)',
                ],
            ],
            'by-products' => [
                'title'      => 'Produk Sampingan',
                'add-action' => 'Tambah baris',
                'columns'    => [
                    'product'   => 'Produk Sampingan',
                    'quantity'  => 'Jumlah',
                    'uom'       => 'Satuan',
                    'operation' => 'Diproduksi pada Operasi',
                ],
            ],
            'miscellaneous' => [
                'title'  => 'Lain-lain',
                'fields' => [
                    'ready-to-produce'       => 'Kesiapan Produksi',
                    'routing'                => 'Routing',
                    'consumption'            => 'Pemakaian Fleksibel',
                    'operation-dependencies' => 'Ketergantungan Operasi',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'reference'  => 'Referensi',
            'product'    => 'Produk',
            'quantity'   => 'Jumlah',
            'uom'        => 'Satuan',
            'type'       => 'Jenis BoM',
            'company'    => 'Perusahaan',
            'deleted-at' => 'Dihapus Pada',
            'updated-at' => 'Diperbarui Pada',
        ],
        'filters' => [
            'product' => 'Produk',
            'type'    => 'Jenis BoM',
            'company' => 'Perusahaan',
        ],
        'actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Bill of materials berhasil dipulihkan',
                    'body'  => 'Bill of materials telah berhasil dipulihkan.',
                ],
            ],
            'delete' => [
                'notification' => [
                    'title' => 'Bill of materials berhasil diarsipkan',
                    'body'  => 'Bill of materials telah berhasil diarsipkan.',
                ],
            ],
            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Bill of materials berhasil dihapus',
                        'body'  => 'Bill of materials telah dihapus secara permanen.',
                    ],
                    'error' => [
                        'title' => 'Bill of materials tidak dapat dihapus',
                        'body'  => 'Bill of materials tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],
        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Bill of materials berhasil dipulihkan',
                    'body'  => 'Bill of materials yang dipilih telah berhasil dipulihkan.',
                ],
            ],
            'delete' => [
                'notification' => [
                    'title' => 'Bill of materials berhasil diarsipkan',
                    'body'  => 'Bill of materials yang dipilih telah berhasil diarsipkan.',
                ],
            ],
            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Bill of materials berhasil dihapus',
                        'body'  => 'Bill of materials yang dipilih telah dihapus secara permanen.',
                    ],
                    'error' => [
                        'title' => 'Bill of materials tidak dapat dihapus',
                        'body'  => 'Satu atau beberapa bill of materials yang dipilih sedang digunakan.',
                    ],
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title'   => 'Informasi Umum',
                'entries' => [
                    'reference'      => 'Referensi',
                    'product'        => 'Produk',
                    'product-variant'=> 'Varian Produk',
                    'quantity'       => 'Jumlah',
                    'uom'            => 'Satuan',
                    'operation-type' => 'Jenis Operasi',
                    'company'        => 'Perusahaan',
                    'type'           => 'Jenis BoM',
                ],
            ],
            'record-information' => [
                'title'   => 'Informasi Data',
                'entries' => [
                    'created-by'   => 'Dibuat Oleh',
                    'created-at'   => 'Dibuat Pada',
                    'last-updated' => 'Terakhir Diperbarui',
                ],
            ],
        ],
        'tabs' => [
            'components' => [
                'title'   => 'Komponen',
                'entries' => [
                    'component' => 'Komponen',
                    'operation' => 'Operasi',
                    'quantity'  => 'Jumlah',
                    'uom'       => 'Satuan Produk',
                ],
            ],
            'operations' => [
                'title'   => 'Operasi',
                'entries' => [
                    'operation'   => 'Operasi',
                    'work-center' => 'Work Center',
                    'time-mode'   => 'Perhitungan Durasi',
                    'duration'    => 'Durasi (menit)',
                ],
            ],
            'by-products' => [
                'title'   => 'Produk Sampingan',
                'entries' => [
                    'product'   => 'Produk Sampingan',
                    'quantity'  => 'Jumlah',
                    'uom'       => 'Satuan',
                    'operation' => 'Diproduksi pada Operasi',
                ],
            ],
            'miscellaneous' => [
                'title'   => 'Lain-lain',
                'entries' => [
                    'kit-information'                         => 'Informasi Kit',
                    'kit-information-content'                 => 'BoM kit digunakan untuk mengelompokkan komponen untuk transfer atau penjualan, bukan untuk diproduksi melalui order produksi.',
                    'ready-to-produce'                        => 'Kesiapan Produksi',
                    'routing'                                 => 'Routing',
                    'consumption'                             => 'Pemakaian Fleksibel',
                    'operation-dependencies'                  => 'Ketergantungan Operasi',
                    'manufacturing-lead-time'                 => 'Lead Time Manufaktur',
                    'days-to-prepare-manufacturing-order'     => 'Hari untuk Menyiapkan Order Produksi',
                    'days-suffix'                             => 'hari',
                ],
            ],
        ],
    ],
];
