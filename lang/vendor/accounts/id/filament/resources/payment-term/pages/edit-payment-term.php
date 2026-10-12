<?php

return [
    'notification' => [
        'success' => [
            'title' => 'Termin pembayaran berhasil diperbarui',
            'body'  => 'Termin pembayaran telah berhasil diperbarui.',
        ],

        'validation-error' => [
            'title' => 'Kesalahan Validasi',
            'body'  => 'Termin Jatuh Tempo harus memiliki minimal satu baris persentase dan total persentasenya harus 100%.',
        ],
    ],

    'header-actions' => [
        'delete' => [
            'notification' => [
                'title' => 'Termin pembayaran berhasil dihapus',
                'body'  => 'Termin pembayaran telah berhasil dihapus.',
            ],
        ],
    ],
];
