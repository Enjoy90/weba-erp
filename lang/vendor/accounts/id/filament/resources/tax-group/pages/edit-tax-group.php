<?php

return [
    'notification' => [
        'title' => 'Grup pajak berhasil diperbarui',
        'body'  => 'Grup pajak telah berhasil diperbarui.',
    ],

    'header-actions' => [
        'delete' => [
            'notification' => [
                'success' => [
                    'title' => 'Grup pajak berhasil dihapus',
                    'body'  => 'Grup pajak telah berhasil dihapus.',
                ],

                'error' => [
                    'title' => 'Grup Pajak tidak dapat dihapus',
                    'body'  => 'Grup pajak tidak dapat dihapus karena sedang digunakan.',
                ],
            ],
        ],
    ],
];
