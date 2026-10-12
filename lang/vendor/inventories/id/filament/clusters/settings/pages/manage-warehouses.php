<?php

return [
    'title' => 'Kelola Gudang',

    'form' => [
        'enable-locations'                      => 'Lokasi',
        'enable-locations-helper-text'          => 'Lacak lokasi produk di gudang Anda',
        'configure-locations'                   => 'Konfigurasi Lokasi',
        'enable-multi-steps-routes'             => 'Rute Multi Langkah',
        'enable-multi-steps-routes-helper-text' => 'Gunakan rute Anda sendiri untuk mengelola transfer produk antargudang',
        'configure-routes'                      => 'Konfigurasi Rute Gudang',
    ],

    'before-save' => [
        'notification' => [
            'warning' => [
                'title' => 'Memiliki beberapa gudang',
                'body'  => 'Anda tidak dapat menonaktifkan multi lokasi jika memiliki lebih dari satu gudang.',
            ],
        ],
    ],
];
