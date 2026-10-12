<?php

return [
    'setup' => [
        'title'        => 'Kirim Pesan',
        'submit-title' => 'Kirim',

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
                    'title' => 'Pesan berhasil dikirim',
                    'body'  => 'Pesan Anda telah berhasil dikirim.',
                ],

                'error' => [
                    'title' => 'Gagal mengirim pesan',
                    'body'  => 'Pesan Anda gagal dikirim',
                ],
            ],

            'mail' => [
                'subject' => ':record_name',
            ],
        ],
    ],
];
