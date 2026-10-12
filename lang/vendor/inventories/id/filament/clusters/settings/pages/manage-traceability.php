<?php

return [
    'title' => 'Kelola Ketertelusuran',

    'form' => [
        'enable-lots-serial-numbers'                             => 'Lot & Nomor Seri',
        'enable-lots-serial-numbers-helper-text'                 => 'Dapatkan ketertelusuran penuh dari pemasok hingga pelanggan',
        'configure-lots'                                         => 'Konfigurasi Lot',
        'enable-expiration-dates'                                => 'Tanggal Kedaluwarsa',
        'enable-expiration-dates-helper-text'                    => 'Atur tanggal kedaluwarsa pada lot & nomor seri',
        'display-on-delivery-slips'                              => 'Tampilkan di Surat Jalan',
        'display-on-delivery-slips-helper-text'                  => 'Lot & nomor seri akan muncul di surat jalan',
        'display-expiration-dates-on-delivery-slips'             => 'Tampilkan Tanggal Kedaluwarsa di Surat Jalan',
        'display-expiration-dates-on-delivery-slips-helper-text' => 'Tanggal kedaluwarsa akan muncul di surat jalan',
        'enable-consignments'                                    => 'Konsinyasi',
        'enable-consignments-helper-text'                        => 'Tetapkan pemilik pada produk yang disimpan',
    ],

    'before-save' => [
        'notification' => [
            'warning' => [
                'title' => 'Anda memiliki produk dalam stok yang pelacakan lot/nomor serinya aktif. ',
                'body'  => 'Nonaktifkan dulu pelacakan pada semua produk sebelum menonaktifkan pengaturan ini.',
            ],
        ],
    ],
];
