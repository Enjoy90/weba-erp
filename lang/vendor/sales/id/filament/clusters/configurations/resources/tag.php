<?php

return [
    'title' => 'Tag',

    'navigation' => [
        'title' => 'Tag',
        'group' => 'Pesanan Penjualan',
    ],

    'form' => [
        'fields' => [
            'name'  => 'Nama',
            'color' => 'Warna',
        ],
    ],

    'table' => [
        'columns' => [
            'created-by' => 'Dibuat oleh',
            'name'       => 'Nama',
            'color'      => 'Warna',
        ],
        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Tag produk berhasil diperbarui',
                    'body'  => 'Tag produk telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Tag produk berhasil dihapus',
                    'body'  => 'Tag produk telah berhasil dihapus.',
                ],
            ],
        ],
        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Tag produk berhasil dihapus',
                    'body'  => 'Tag produk telah berhasil dihapus.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'entries' => [
            'name'  => 'Nama',
            'color' => 'Warna',
        ],
    ],
];
