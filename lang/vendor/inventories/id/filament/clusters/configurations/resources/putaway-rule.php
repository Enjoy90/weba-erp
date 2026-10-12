<?php

return [
    'navigation' => [
        'title' => 'Aturan Penempatan',
        'group' => 'Manajemen Gudang',
    ],

    'form' => [
        'fields' => [
            'in-location'          => 'Saat Produk Tiba Di',
            'product'              => 'Produk',
            'product-placeholder'  => 'Semua Produk',
            'category'             => 'Kategori Produk',
            'category-placeholder' => 'Semua Kategori',
            'storage-category'     => 'Kategori Penyimpanan',
            'out-location'         => 'Simpan Ke',
            'sub-location'         => 'Sub Lokasi',
            'company'              => 'Perusahaan',
        ],
    ],

    'table' => [
        'columns' => [
            'in-location'      => 'Saat Produk Tiba Di',
            'product'          => 'Produk',
            'category'         => 'Kategori Produk',
            'storage-category' => 'Kategori Penyimpanan',
            'out-location'     => 'Simpan Ke',
            'sub-location'     => 'Sub Lokasi',
            'company'          => 'Perusahaan',
            'deleted-at'       => 'Dihapus Pada',
            'created-at'       => 'Dibuat Pada',
            'updated-at'       => 'Diperbarui Pada',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Aturan penempatan berhasil diperbarui',
                    'body'  => 'Aturan penempatan telah berhasil diperbarui.',
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Aturan penempatan berhasil dipulihkan',
                    'body'  => 'Aturan penempatan telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Aturan penempatan berhasil dihapus',
                    'body'  => 'Aturan penempatan telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'error' => [
                        'title' => 'Aturan penempatan tidak dapat dihapus',
                        'body'  => 'Aturan penempatan tidak dapat dihapus permanen karena dirujuk oleh data lain.',
                    ],

                    'success' => [
                        'title' => 'Aturan penempatan berhasil dihapus permanen',
                        'body'  => 'Aturan penempatan telah berhasil dihapus permanen.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Aturan penempatan berhasil dipulihkan',
                    'body'  => 'Aturan penempatan yang dipilih telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Aturan penempatan berhasil dihapus',
                    'body'  => 'Aturan penempatan yang dipilih telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'error' => [
                        'title' => 'Aturan penempatan tidak dapat dihapus',
                        'body'  => 'Beberapa aturan penempatan tidak dapat dihapus permanen karena dirujuk oleh data lain.',
                    ],

                    'success' => [
                        'title' => 'Aturan penempatan berhasil dihapus permanen',
                        'body'  => 'Aturan penempatan yang dipilih telah berhasil dihapus permanen.',
                    ],
                ],
            ],
        ],
    ],
];
