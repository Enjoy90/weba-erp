<?php

return [
    'label'         => 'Produksi Semua',
    'partial-label' => 'Produksi',

    'modal' => [
        'consumption-warning' => [
            'heading'     => 'Peringatan Pemakaian',
            'description' => 'Beberapa produk dipakai dengan jumlah yang berbeda dari yang diharapkan. Apakah Anda ingin memvalidasi order produksi dengan jumlah saat ini?',

            'form' => [
                'product'    => 'Produk',
                'to-consume' => 'Akan Dipakai',
                'consumed'   => 'Terpakai',
                'uom'        => 'Satuan',
            ],

            'actions' => [
                'confirm' => [
                    'label' => 'Konfirmasi',
                ],

                'set-quantities' => [
                    'label' => 'Atur Jumlah dan Konfirmasi',
                ],
            ],
        ],

        'produced-warning' => [
            'heading'     => 'Hasil produksi berbeda dari yang diharapkan',
            'description' => 'Jumlah yang diproduksi berbeda dari yang diharapkan. Apakah Anda ingin mengonfirmasi order produksi dengan jumlah saat ini?',
        ],
    ],

    'notification' => [
        'success' => [
            'title' => 'Order produksi berhasil diselesaikan',
            'body'  => 'Order produksi telah berhasil diselesaikan.',
        ],
    ],
];
