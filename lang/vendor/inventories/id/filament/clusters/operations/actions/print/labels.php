<?php

return [
    'label' => 'Label',

    'form' => [
        'fields' => [
            'type'          => 'Jenis Label',
            'quantity'      => 'Jumlah',
            'format'        => 'Format',
            'layout'        => 'Tata Letak Label',
            'quantity-type' => 'Jumlah yang Dicetak',
            'quantity'      => 'Jumlah',

            'quantity-type-options' => [
                'operation' => 'Jumlah Operasi',
                'custom'    => 'Jumlah Kustom',
                'per-slot'  => 'Satu per lot/NS',
                'per-unit'  => 'Satu per unit',
            ],

            'type-options' => [
                'product' => 'Label Produk',
                'lot'     => 'Label Lot/NS',
            ],

            'format-options' => [
                'dymo'       => 'Dymo',
                '2x7_price'  => '2x7 dengan harga',
                '4x7_price'  => '4x7 dengan harga',
                '4x12'       => '4x12',
                '4x12_price' => '4x12 dengan harga',
            ],
        ],
    ],
];
