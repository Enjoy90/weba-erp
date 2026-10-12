<?php

return [
    'label'             => 'Validasi',
    'modal-heading'     => 'Buat Backorder?',
    'modal-description' => 'Buat backorder jika sisa produk akan diproses nanti. Jika tidak, jangan buat backorder.',

    'extra-modal-footer-actions' => [
        'no-backorder' => [
            'label' => 'Tanpa Backorder',
        ],
    ],

    'notification' => [
        'error' => [
            'title' => 'Validasi Gagal',
        ],

        'warning' => [
            'lines-missing' => [
                'title' => 'Tidak ada jumlah yang dicadangkan',
                'body'  => 'Tidak ada jumlah yang dicadangkan untuk transfer ini.',
            ],

            'no-quantities-reserved' => [
                'title' => 'Tidak ada jumlah yang dicadangkan',
                'body'  => 'Tidak ada jumlah yang dicadangkan untuk transfer ini.',
            ],

            'lot-missing' => [
                'title' => 'Isi Lot/Nomor Seri',
                'body'  => 'Anda perlu mengisi Lot/Nomor Seri untuk produk :products.',
            ],

            'serial-qty' => [
                'title' => 'Nomor Seri Sudah Ditetapkan',
                'body'  => 'Nomor seri sudah ditetapkan untuk produk lain.',
            ],

            'partial-package' => [
                'title' => 'Tidak dapat memindahkan isi paket yang sama',
                'body'  => 'Anda tidak dapat memindahkan isi paket yang sama lebih dari sekali dalam satu transfer atau memecah paket ke dua lokasi.',
            ],
        ],
    ],
];
