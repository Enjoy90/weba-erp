<?php

return [
    'label' => 'Kirim PO lewat Email',

    'form' => [
        'fields' => [
            'to'      => 'Kepada',
            'subject' => 'Subjek',
            'message' => 'Pesan',
        ],
    ],

    'action' => [
        'notification' => [
            'success' => [
                'title' => 'Email berhasil dikirim',
                'body'  => 'Email telah berhasil dikirim.',
            ],

            'warning' => [
                'title' => 'Sebagian email tidak terkirim',
                'body'  => 'Sebagian pemasok tidak akan menerima email karena alamat email mereka tidak tersedia.',
            ],

            'danger' => [
                'title' => 'Email tidak terkirim',
                'body'  => 'Tambahkan alamat email pada pemasok yang dipilih, lalu coba lagi.',
            ],
        ],
    ],
];
