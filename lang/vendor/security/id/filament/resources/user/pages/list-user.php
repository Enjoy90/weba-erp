<?php

return [
    'tabs' => [
        'all'      => 'Semua Pengguna',
        'archived' => 'Pengguna Diarsipkan',
    ],

    'header-actions' => [
        'invite' => [
            'title' => 'Undang Pengguna',
            'modal' => [
                'submit-action-label' => 'Undang Pengguna',
            ],
            'form' => [
                'email' => 'Email',
            ],
            'notification' => [
                'success' => [
                    'title' => 'Pengguna berhasil diundang',
                    'body'  => 'Pengguna telah berhasil diundang',
                ],
                'error' => [
                    'title' => 'Gagal Mengundang Pengguna',
                    'body'  => 'Sistem mengalami kesalahan tak terduga saat mengirim undangan pengguna.',
                ],

                'default-company-error' => [
                    'title' => 'Perusahaan Bawaan Belum Diatur',
                    'body'  => 'Atur perusahaan bawaan di pengaturan sebelum mengundang pengguna.',
                ],
            ],
        ],

        'create' => [
            'label' => 'Pengguna Baru',
        ],
    ],
];
