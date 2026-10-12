<?php

return [
    'header-actions' => [
        'print' => [
            'label' => 'Cetak',

            'actions' => [
                'without-content' => [
                    'label' => 'Cetak Barcode',
                ],

                'with-content' => [
                    'label' => 'Cetak Barcode Beserta Isi',
                ],
            ],
        ],

        'delete' => [
            'notification' => [
                'success' => [
                    'title' => 'Paket berhasil dihapus',
                    'body'  => 'Paket telah berhasil dihapus.',
                ],

                'error' => [
                    'title' => 'Paket tidak dapat dihapus',
                    'body'  => 'Paket tidak dapat dihapus karena sedang digunakan.',
                ],
            ],
        ],
    ],
];
