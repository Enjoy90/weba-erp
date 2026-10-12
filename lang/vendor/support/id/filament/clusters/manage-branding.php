<?php

return [
    'breadcrumb' => 'Branding',
    'title'      => 'Branding',
    'group'      => 'Umum',

    'navigation' => [
        'label' => 'Branding',
    ],

    'form' => [
        'sections' => [
            'logo' => [
                'title'       => 'Logo & Favicon',
                'description' => 'Ganti logo, favicon, dan tinggi logo yang dipakai di panel admin dan panel pelanggan. Kosongkan kolom untuk memakai nilai bawaan.',
            ],
            'colors' => [
                'title'       => 'Warna',
                'description' => 'Ganti warna tema yang dipakai di panel admin dan panel pelanggan. Kosongkan warna untuk memakai nilai bawaan.',
            ],
        ],
        'fields' => [
            'light-logo'         => 'Logo Terang',
            'light-logo-helper'  => 'Ditampilkan pada latar terang. Menggantikan logo bawaan.',
            'dark-logo'          => 'Logo Gelap',
            'dark-logo-helper'   => 'Ditampilkan saat mode gelap aktif.',
            'favicon'            => 'Favicon',
            'favicon-helper'     => 'Ikon pada tab browser.',
            'logo-height'        => 'Tinggi Logo',
            'logo-height-helper' => 'Nilai tinggi CSS, misalnya 2rem atau 40px.',
            'primary-color'      => 'Utama',
            'gray-color'         => 'Abu-abu',
            'danger-color'       => 'Bahaya',
            'info-color'         => 'Info',
            'success-color'      => 'Sukses',
            'warning-color'      => 'Peringatan',
        ],
    ],

    'actions' => [
        'reset' => [
            'label' => 'Kembalikan ke bawaan',
        ],
    ],
];
