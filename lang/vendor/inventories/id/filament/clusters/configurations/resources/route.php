<?php

return [
    'navigation' => [
        'title' => 'Rute',
        'group' => 'Manajemen Gudang',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title'  => 'Umum',

                'fields' => [
                    'route'             => 'Rute',
                    'route-placeholder' => 'mis. Penerimaan Dua Langkah',
                    'company'           => 'Perusahaan',
                ],
            ],

            'applicable-on' => [
                'title'       => 'Berlaku Pada',
                'description' => 'Pilih tempat rute ini dapat diterapkan.',

                'fields' => [
                    'products'                        => 'Produk',
                    'products-hint-tooltip'           => 'Jika dipilih, rute ini dapat dipilih pada produk.',
                    'product-categories'              => 'Kategori Produk',
                    'product-categories-hint-tooltip' => 'Jika dipilih, rute ini dapat dipilih pada kategori produk.',
                    'warehouses'                      => 'Gudang',
                    'warehouses-hint-tooltip'         => 'Jika gudang ditetapkan pada rute ini, rute ini akan dianggap sebagai rute bawaan untuk produk yang bergerak melalui gudang tersebut.',
                    'packaging'                       => 'Kemasan',
                    'packaging-hint-tooltip'          => 'Jika dipilih, rute ini dapat dipilih pada kemasan.',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'route'      => 'Rute',
            'company'    => 'Perusahaan',
            'deleted-at' => 'Dihapus Pada',
            'created-at' => 'Dibuat Pada',
            'updated-at' => 'Diperbarui Pada',
        ],

        'groups' => [
            'created-at' => 'Dibuat Pada',
            'updated-at' => 'Diperbarui Pada',
        ],

        'filters' => [
            'company'  => 'Perusahaan',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Rute berhasil diperbarui',
                    'body'  => 'Rute telah berhasil diperbarui.',
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Rute berhasil dipulihkan',
                    'body'  => 'Rute telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Rute berhasil dihapus',
                    'body'  => 'Rute telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Rute berhasil dihapus permanen',
                        'body'  => 'Rute telah berhasil dihapus permanen.',
                    ],

                    'error' => [
                        'title' => 'Rute tidak dapat dihapus',
                        'body'  => 'Rute tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Data rute berhasil dipulihkan',
                    'body'  => 'Data rute telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Data rute berhasil dihapus',
                    'body'  => 'Data rute telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Data rute berhasil dihapus permanen',
                        'body'  => 'Data rute telah berhasil dihapus permanen.',
                    ],

                    'error' => [
                        'title' => 'Data rute tidak dapat dihapus',
                        'body'  => 'Data rute tidak dapat dihapus karena sedang digunakan.',
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
                    'route'             => 'Rute',
                    'route-placeholder' => 'mis. Penerimaan Dua Langkah',
                    'company'           => 'Perusahaan',
                ],
            ],

            'applicable-on' => [
                'title'       => 'Berlaku Pada',
                'description' => 'Pilih tempat rute ini dapat dipilih.',

                'entries' => [
                    'products'                        => 'Produk',
                    'products-hint-tooltip'           => 'Jika dipilih, rute ini dapat dipilih pada produk.',
                    'product-categories'              => 'Kategori Produk',
                    'product-categories-hint-tooltip' => 'Jika dipilih, rute ini dapat dipilih pada kategori produk.',
                    'warehouses'                      => 'Gudang',
                    'warehouses-hint-tooltip'         => 'Jika gudang ditetapkan pada rute ini, rute ini akan dianggap sebagai rute bawaan untuk produk yang bergerak melalui gudang tersebut.',
                    'packaging'                       => 'Kemasan',
                    'packaging-hint-tooltip'          => 'Jika dipilih, rute ini dapat dipilih pada kemasan.',
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
