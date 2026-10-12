<?php

return [
    'breadcrumb' => 'Kelola Pengguna',
    'title'      => 'Kelola Pengguna',
    'group'      => 'Umum',

    'navigation' => [
        'label' => 'Kelola Pengguna',
    ],

    'form' => [
        'enable-user-invitation' => [
            'label'       => 'Aktifkan Undangan Pengguna',
            'helper-text' => 'Izinkan pengguna mengundang pengguna lain ke aplikasi.',
        ],

        'enable-reset-password' => [
            'label'       => 'Aktifkan Reset Kata Sandi',
            'helper-text' => 'Izinkan pengguna mereset kata sandi mereka.',
        ],

        'default-role' => [
            'label'       => 'Peran Bawaan',
            'helper-text' => 'Peran bawaan yang diberikan kepada pengguna baru.',
        ],

        'default-company' => [
            'label'       => 'Perusahaan Bawaan',
            'helper-text' => 'Perusahaan bawaan yang ditetapkan untuk pengguna baru.',
        ],
    ],
];
