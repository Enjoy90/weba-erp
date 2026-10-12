<?php

return [
    'notification' => [
        'title' => 'Pengguna berhasil diperbarui',
        'body'  => 'Pengguna telah berhasil diperbarui.',
    ],

    'header-actions' => [
        'change-password' => [
            'label' => 'Ubah Kata Sandi',

            'notification' => [
                'title' => 'Kata sandi berhasil diubah',
                'body'  => 'Kata sandi telah berhasil diubah.',
            ],

            'form' => [
                'new-password'         => 'Kata Sandi Baru',
                'confirm-new-password' => 'Konfirmasi Kata Sandi Baru',
            ],
        ],

        'delete' => [
            'notification' => [
                'title' => 'Pengguna berhasil dihapus',
                'body'  => 'Pengguna telah berhasil dihapus.',
                'error' => [
                    'title' => 'Pengguna Tidak Dapat Dihapus',
                    'body'  => 'Ini adalah pengguna bawaan, atau Anda tidak dapat menghapus akun Anda sendiri.',
                ],
            ],
        ],
    ],
];
