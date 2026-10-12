<?php

return [
    'setup' => [
        'title'   => 'Lampiran',
        'tooltip' => 'Unggah Lampiran',

        'modal-submit-action-label' => 'Unggah',

        'form' => [
            'fields' => [
                'files'                  => 'Berkas',
                'attachment-helper-text' => 'Ukuran berkas maksimal: 10MB. Jenis yang diizinkan: Gambar, PDF, Word, Excel, Teks',

                'actions' => [
                    'delete' => [
                        'title' => 'Berkas berhasil dihapus',
                        'body'  => 'Berkas telah berhasil dihapus.',
                    ],
                ],
            ],
        ],

        'actions' => [
            'notification' => [
                'success' => [
                    'title' => 'Lampiran berhasil diunggah',
                    'body'  => 'Lampiran telah berhasil diunggah.',
                ],

                'warning'  => [
                    'title' => 'Tidak ada berkas baru',
                    'body'  => 'Semua berkas sudah diunggah.',
                ],

                'error' => [
                    'title' => 'Gagal mengunggah lampiran',
                    'body'  => 'Gagal mengunggah lampiran ',
                ],
            ],
        ],
    ],
];
