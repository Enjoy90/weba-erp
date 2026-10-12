<?php

return [
    'title' => 'Produk Template Pesanan',

    'navigation' => [
        'title' => 'Produk Template Pesanan',
        'group' => 'Pesanan Penjualan',
    ],

    'global-search' => [
        'name'    => 'Nama',
    ],

    'form' => [
        'fields' => [
            'sort'           => 'Urutan',
            'order-template' => 'Template Pesanan',
            'company'        => 'Perusahaan',
            'product'        => 'Produk',
            'product-uom'    => 'Satuan Produk',
            'creator'        => 'Pembuat',
            'display-type'   => 'Jenis Tampilan',
            'name'           => 'Nama',
            'quantity'       => 'Jumlah',
        ],
    ],

    'table' => [
        'columns' => [
            'sort'           => 'Urutan',
            'order-template' => 'Template Pesanan',
            'company'        => 'Perusahaan',
            'product'        => 'Produk',
            'product-uom'    => 'Satuan Produk',
            'created-by'     => 'Dibuat oleh',
            'display-type'   => 'Jenis Tampilan',
            'name'           => 'Nama',
            'quantity'       => 'Jumlah',
            'created-at'     => 'Dibuat pada',
            'updated-at'     => 'Diperbarui pada',

        ],
        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Produk template pesanan berhasil diperbarui',
                    'body'  => 'Produk template pesanan telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Produk template pesanan berhasil dihapus',
                    'body'  => 'Produk template pesanan telah berhasil dihapus.',
                ],
            ],
        ],
        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Produk template pesanan berhasil dihapus',
                    'body'  => 'Produk template pesanan telah berhasil dihapus.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'entries' => [
            'sort'           => 'Urutan',
            'order-template' => 'Template Pesanan',
            'company'        => 'Perusahaan',
            'product'        => 'Produk',
            'product-uom'    => 'Satuan Produk',
            'display-type'   => 'Jenis Tampilan',
            'name'           => 'Nama',
            'quantity'       => 'Jumlah',
        ],
    ],
];
