<?php

return [
    'notification' => [
        'title' => 'Pajak berhasil diperbarui',
        'body'  => 'Pajak telah berhasil diperbarui.',
    ],

    'header-actions' => [
        'delete' => [
            'notification' => [
                'success' => [
                    'title' => 'Pajak berhasil dihapus',
                    'body'  => 'Pajak telah berhasil dihapus.',
                ],

                'error' => [
                    'title' => 'Pajak tidak dapat dihapus',
                    'body'  => 'Pajak tidak dapat dihapus karena sedang digunakan.',
                ],

                'invalid-repartition-lines' => [
                    'title' => 'Baris Distribusi Tidak Valid',
                ],
            ],
        ],
    ],
];
