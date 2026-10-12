<?php

return [
    'notification' => [
        'title' => 'Produk berhasil diperbarui',
        'body'  => 'Produk telah berhasil diperbarui.',
    ],

    'header-actions' => [
        'update-quantity' => [
            'label'                     => 'Perbarui Jumlah',
            'modal-heading'             => 'Perbarui Jumlah Produk',
            'modal-submit-action-label' => 'Perbarui',

            'form' => [
                'fields' => [
                    'on-hand-qty' => 'Jumlah Tersedia',
                ],
            ],
        ],

        'delete' => [
            'notification' => [
                'title' => 'Produk berhasil dihapus',
                'body'  => 'Produk telah berhasil dihapus.',
            ],
        ],
    ],
];
