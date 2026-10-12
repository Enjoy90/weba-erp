<?php

return [
    'label' => 'Buat Tagihan',

    'action' => [
        'notification' => [
            'warning' => [
                'title' => 'Tidak ada baris yang dapat ditagih',
                'body'  => 'Tidak ada baris yang dapat ditagih. Pastikan sudah ada jumlah yang diterima.',
            ],

            'missing-journal' => [
                'title' => 'Akuntansi belum diatur',
            ],

            'success' => [
                'title' => 'Tagihan berhasil dibuat',
                'body'  => 'Tagihan telah berhasil dibuat.',
            ],
        ],
    ],
];
