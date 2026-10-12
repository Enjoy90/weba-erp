<?php

return [
    'label' => 'Retur',

    'modal' => [
        'form' => [
            'columns' => [
                'product'                 => 'Produk',
                'quantity'                => 'Jumlah',
                'uom'                     => 'Satuan',
                'excess-quantity-tooltip' => 'Jumlah yang diretur melebihi jumlah yang diproses pada operasi awal.',
            ],
        ],
    ],

    'notification' => [
        'no-products' => [
            'body' => 'Tidak ada produk untuk diretur (hanya baris berstatus Selesai yang belum diretur sepenuhnya yang dapat diretur).',
        ],
        'no-quantities' => [
            'body' => 'Isi minimal satu jumlah yang bukan nol.',
        ],
    ],
];
