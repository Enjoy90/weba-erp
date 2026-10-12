<?php

return [
    'notification' => [
        'title' => 'Transfer Internal berhasil diperbarui',
        'body'  => 'Transfer Internal telah berhasil diperbarui.',
    ],

    'header-actions' => [
        'print' => [
            'label' => 'Cetak',
        ],

        'delete' => [
            'notification' => [
                'success' => [
                    'title' => 'Transfer Internal berhasil dihapus',
                    'body'  => 'Transfer Internal telah berhasil dihapus.',
                ],

                'error' => [
                    'title' => 'Transfer Internal tidak dapat dihapus',
                    'body'  => 'Transfer Internal tidak dapat dihapus karena sedang digunakan.',
                ],
            ],
        ],
    ],
];
