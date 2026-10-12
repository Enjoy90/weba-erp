<?php

return [
    'notification' => [
        'title' => 'Penerimaan berhasil diperbarui',
        'body'  => 'Penerimaan telah berhasil diperbarui.',
    ],

    'header-actions' => [
        'print' => [
            'label' => 'Cetak',
        ],

        'delete' => [
            'notification' => [
                'success' => [
                    'title' => 'Penerimaan berhasil dihapus',
                    'body'  => 'Penerimaan telah berhasil dihapus.',
                ],

                'error' => [
                    'title' => 'Penerimaan tidak dapat dihapus',
                    'body'  => 'Penerimaan tidak dapat dihapus karena sedang digunakan.',
                ],
            ],
        ],
    ],
];
