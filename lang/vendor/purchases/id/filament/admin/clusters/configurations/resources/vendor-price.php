<?php

return [
    'navigation' => [
        'title' => 'Daftar Harga Pemasok',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title'  => 'Umum',

                'fields' => [
                    'vendor'                      => 'Pemasok',
                    'vendor-product-name'         => 'Nama Produk Pemasok',
                    'vendor-product-name-tooltip' => 'Nama produk dari pemasok akan tampil pada permintaan penawaran. Kosongkan untuk memakai nama produk internal.',
                    'vendor-product-code'         => 'Kode Produk Pemasok',
                    'vendor-product-code-tooltip' => 'Kode produk dari pemasok akan tampil pada permintaan penawaran. Kosongkan untuk memakai kode internal.',
                    'delay'                       => 'Waktu Tunggu Pengiriman (Hari)',
                    'delay-tooltip'               => 'Waktu tunggu (dalam hari) sejak pesanan pembelian dikonfirmasi hingga produk diterima di gudang. Dipakai oleh penjadwal untuk perencanaan pesanan pembelian otomatis.',
                ],
            ],

            'prices' => [
                'title'  => 'Harga',

                'fields' => [
                    'product'            => 'Produk',
                    'quantity'           => 'Jumlah',
                    'quantity-tooltip'   => 'Jumlah minimum yang harus dibeli dari pemasok ini agar mendapatkan harga yang ditentukan. Dinyatakan dalam satuan produk pemasok atau, jika tidak diatur, satuan bawaan produk.',
                    'unit-price'         => 'Harga Satuan',
                    'unit-price-tooltip' => 'Harga per satuan produk ini dari pemasok, dinyatakan dalam satuan produk pemasok atau, jika tidak diatur, satuan bawaan produk.',
                    'currency'           => 'Mata Uang',
                    'valid-from'         => 'Berlaku Dari',
                    'valid-to'           => 'Berlaku Hingga',
                    'discount'           => 'Diskon (%)',
                    'company'            => 'Perusahaan',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'vendor'              => 'Pemasok',
            'vendor-product-name' => 'Nama Produk Pemasok',
            'vendor-product-code' => 'Kode Produk Pemasok',
            'delay'               => 'Waktu Tunggu Pengiriman (Hari)',
            'product'             => 'Produk',
            'quantity'            => 'Jumlah',
            'unit-price'          => 'Harga Satuan',
            'currency'            => 'Mata Uang',
            'valid-from'          => 'Berlaku Dari',
            'valid-to'            => 'Berlaku Hingga',
            'discount'            => 'Diskon (%)',
            'company'             => 'Perusahaan',
            'created-at'          => 'Dibuat Pada',
            'updated-at'          => 'Diperbarui Pada',
        ],

        'filters' => [
            'vendor'        => 'Filter menurut Pemasok',
            'product'       => 'Filter menurut Produk',
            'currency'      => 'Filter menurut Mata Uang',
            'company'       => 'Filter menurut Perusahaan',
            'price-from'    => 'Harga Minimum',
            'price-to'      => 'Harga Maksimum',
            'min-qty-from'  => 'Jumlah Minimum Dari',
            'min-qty-to'    => 'Jumlah Minimum Hingga',
            'starts-from'   => 'Tanggal Berlaku Dari',
            'ends-before'   => 'Tanggal Berlaku Hingga',
            'created-from'  => 'Dibuat Dari',
            'created-until' => 'Dibuat Hingga',
        ],

        'groups' => [
            'vendor'     => 'Pemasok',
            'product'    => 'Produk',
            'created-at' => 'Dibuat Pada',
            'updated-at' => 'Diperbarui Pada',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Harga pemasok berhasil dihapus',
                        'body'  => 'Harga pemasok telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Harga pemasok tidak dapat dihapus',
                        'body'  => 'Harga pemasok tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Harga pemasok berhasil dihapus',
                        'body'  => 'Harga pemasok telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Harga pemasok tidak dapat dihapus',
                        'body'  => 'Harga pemasok tidak dapat dihapus karena sedang digunakan.',
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
                    'vendor'                      => 'Pemasok',
                    'vendor-product-name'         => 'Nama Produk Pemasok',
                    'vendor-product-name-tooltip' => 'Nama produk dari pemasok akan tampil pada permintaan penawaran. Kosongkan untuk memakai nama produk internal.',
                    'vendor-product-code'         => 'Kode Produk Pemasok',
                    'vendor-product-code-tooltip' => 'Kode produk dari pemasok akan tampil pada permintaan penawaran. Kosongkan untuk memakai kode internal.',
                    'delay'                       => 'Waktu Tunggu Pengiriman (Hari)',
                    'delay-tooltip'               => 'Waktu tunggu (dalam hari) sejak pesanan pembelian dikonfirmasi hingga produk diterima di gudang. Dipakai oleh penjadwal untuk perencanaan pesanan pembelian otomatis.',
                ],
            ],

            'record-information' => [
                'title'  => 'Informasi Data',

                'entries' => [
                    'created-by'   => 'Dibuat Oleh',
                    'created-at'   => 'Dibuat Pada',
                    'last-updated' => 'Terakhir Diperbarui',
                ],
            ],

            'prices' => [
                'title'  => 'Harga',

                'entries' => [
                    'product'            => 'Produk',
                    'quantity'           => 'Jumlah',
                    'quantity-tooltip'   => 'Jumlah minimum yang harus dibeli dari pemasok ini agar mendapatkan harga yang ditentukan. Dinyatakan dalam satuan produk pemasok atau, jika tidak diatur, satuan bawaan produk.',
                    'unit-price'         => 'Harga Satuan',
                    'unit-price-tooltip' => 'Harga per satuan produk ini dari pemasok, dinyatakan dalam satuan produk pemasok atau, jika tidak diatur, satuan bawaan produk.',
                    'currency'           => 'Mata Uang',
                    'valid-from'         => 'Berlaku Dari',
                    'valid-to'           => 'Berlaku Hingga',
                    'discount'           => 'Diskon (%)',
                    'company'            => 'Perusahaan',
                ],
            ],
        ],
    ],
];
