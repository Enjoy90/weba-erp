<?php

return [
    'title' => 'Kembalikan ke Draf',

    'validation' => [
        'notification' => [
            'error' => [
                'invalid-state' => [
                    'title' => 'Status Entri Jurnal Tidak Valid',
                    'body'  => 'Hanya entri jurnal yang sudah diposting atau dibatalkan yang dapat dikembalikan ke draf.',
                ],
            ],
        ],
    ],
];
