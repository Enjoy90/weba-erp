<?php

return [
    'notification' => [
        'title' => 'Scrap berhasil diperbarui',
        'body'  => 'Scrap telah berhasil diperbarui.',
    ],

    'header-actions' => [
        'validate' => [
            'label' => 'Validasi',

            'notification' => [
                'warning' => [
                    'title' => 'Stok tidak mencukupi',
                    'body'  => 'Stok untuk scrap ini tidak mencukupi untuk divalidasi.',
                ],

                'success' => [
                    'title' => 'Scrap ditandai selesai',
                    'body'  => 'Scrap telah berhasil ditandai selesai.',
                ],
            ],
        ],

        'delete' => [
            'notification' => [
                'success' => [
                    'title' => 'Scrap berhasil dihapus',
                    'body'  => 'Scrap telah berhasil dihapus.',
                ],

                'error' => [
                    'title' => 'Scrap tidak dapat dihapus',
                    'body'  => 'Scrap tidak dapat dihapus karena sedang digunakan.',
                ],
            ],
        ],
    ],
];
