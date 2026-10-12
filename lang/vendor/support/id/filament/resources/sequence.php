<?php

return [
    'model-label' => 'Urutan Penomoran',

    'plural-model-label' => 'Urutan Penomoran',

    'navigation' => [
        'title' => 'Urutan Penomoran',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title'       => 'Umum',
                'description' => 'Urutan penomoran untuk jurnal, gudang, dan jenis operasi dibuat otomatis saat data tersebut dibuat, dan dapat diubah di sini. Pembuatan manual hanya diperlukan untuk urutan penomoran khusus berbasis kode.',

                'fields' => [
                    'name'      => 'Nama',
                    'code'      => 'Kode',
                    'code-help' => 'Pengenal teknis yang dipakai oleh dokumen, misalnya sales.order. Urutan penomoran yang dibuat otomatis sudah memiliki kode yang benar.',
                    'company'   => 'Perusahaan',
                ],
            ],

            'format' => [
                'title' => 'Penomoran',

                'fields' => [
                    'prefix'           => 'Prefiks',
                    'prefix-help'      => 'Placeholder: %(year), %(y), %(month), %(day). Contoh: INV/%(year)/',
                    'suffix'           => 'Sufiks',
                    'padding'          => 'Jumlah Digit Nomor',
                    'next-number'      => 'Nomor Berikutnya',
                    'next-number-help' => 'Hanya dapat dinaikkan. Untuk memulai ulang penomoran dengan aman, hapus urutan penomoran ini, lalu sistem akan membuatnya kembali dari nomor dokumen tertinggi yang sudah ada.',
                    'step'             => 'Kenaikan',
                    'reset-frequency'  => 'Atur Ulang Penghitung',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'            => 'Nama',
            'code'            => 'Kode',
            'applies-to'      => 'Berlaku Untuk',
            'company'         => 'Perusahaan',
            'next-preview'    => 'Nomor Dokumen Berikutnya',
            'next-number'     => 'Nomor Berikutnya',
            'reset-frequency' => 'Atur Ulang Penghitung',
        ],

        'variants' => [
            'refund'         => 'Pengembalian Dana',
            'payment'        => 'Pembayaran',
            'refund-payment' => 'Pengembalian Dana + Pembayaran',
        ],

        'filters' => [
            'company' => 'Perusahaan',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Urutan Penomoran berhasil diperbarui',
                    'body'  => 'Urutan penomoran telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Urutan Penomoran berhasil dihapus',
                    'body'  => 'Urutan penomoran telah berhasil dihapus.',
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Urutan Penomoran berhasil dihapus',
                    'body'  => 'Urutan penomoran yang dipilih telah berhasil dihapus.',
                ],
            ],
        ],
    ],
];
