<?php

return [
    'setup' => [
        'title'        => 'Catatan Internal',
        'submit-title' => 'Catat',

        'form' => [
            'fields' => [
                'hide-subject'            => 'Sembunyikan Subjek',
                'add-subject'             => 'Tambahkan Subjek',
                'subject'                 => 'Subjek',
                'write-message-here'      => 'Tulis pesan Anda di sini',
                'attachments-helper-text' => 'Ukuran berkas maksimal: 10MB. Jenis yang diizinkan: Gambar, PDF, Word, Excel, Teks',
            ],
        ],

        'actions' => [
            'notification' => [
                'success' => [
                    'title' => 'Catatan Internal berhasil ditambahkan',
                    'body'  => 'Catatan internal Anda telah berhasil ditambahkan.',
                ],

                'error' => [
                    'title' => 'Gagal menambahkan catatan',
                    'body'  => 'Gagal menambahkan catatan internal Anda',
                ],
            ],
        ],
    ],
];
