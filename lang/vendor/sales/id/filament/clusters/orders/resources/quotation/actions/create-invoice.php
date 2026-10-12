<?php

return [
    'title' => 'Buat Faktur',

    'modal' => [
        'heading' => 'Buat Faktur',
    ],

    'notification' => [
        'invoice-created' => [
            'title' => 'Faktur berhasil dibuat',
            'body'  => 'Faktur telah berhasil dibuat.',
        ],

        'no-invoiceable-lines' => [
            'title' => 'Tidak ada baris yang dapat difakturkan',
            'body'  => 'Tidak ada baris yang dapat difakturkan. Pastikan sudah ada jumlah yang diterima.',
        ],
    ],

    'form' => [
        'fields' => [
            'create-invoice' => 'Buat Faktur',
        ],
    ],
];
