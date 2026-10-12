<?php

return [
    'label' => 'Batal',

    'action' => [
        'notification' => [
            'warning' => [
                'receipts' => [
                    'title' => 'Pesanan tidak dapat dibatalkan',
                    'body'  => 'Pesanan tidak dapat dibatalkan karena memiliki penerimaan yang sudah selesai.',
                ],

                'bills' => [
                    'title' => 'Pesanan tidak dapat dibatalkan',
                    'body'  => 'Pesanan tidak dapat dibatalkan. Batalkan terlebih dahulu tagihan pemasok yang terkait.',
                ],
            ],

            'success' => [
                'title' => 'Pesanan berhasil dibatalkan',
                'body'  => 'Pesanan telah berhasil dibatalkan.',
            ],
        ],
    ],
];
