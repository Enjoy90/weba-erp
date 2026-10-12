<?php

return [
    'assets' => [
        'label'   => 'Aset',
        'options' => [
            'receivable'  => 'Piutang',
            'cash'        => 'Kas dan Bank',
            'current'     => 'Aset Lancar',
            'non-current' => 'Aset Tidak Lancar',
            'prepayments' => 'Biaya Dibayar di Muka',
            'fixed'       => 'Aset Tetap',
        ],
    ],

    'liabilities' => [
        'label'   => 'Liabilitas',
        'options' => [
            'payable'     => 'Utang',
            'credit-card' => 'Kartu Kredit',
            'current'     => 'Liabilitas Jangka Pendek',
            'non-current' => 'Liabilitas Jangka Panjang',
        ],
    ],

    'equity' => [
        'label'   => 'Ekuitas',
        'options' => [
            'equity'     => 'Ekuitas',
            'unaffected' => 'Laba Tahun Berjalan',
        ],
    ],

    'income' => [
        'label'   => 'Pendapatan',
        'options' => [
            'income' => 'Pendapatan',
            'other'  => 'Pendapatan Lain-lain',
        ],
    ],

    'expenses' => [
        'label'   => 'Beban',
        'options' => [
            'expense'      => 'Beban',
            'depreciation' => 'Penyusutan',
            'direct-cost'  => 'Beban Pokok Pendapatan',
        ],
    ],

    'off-balance' => [
        'label'   => 'Di Luar Neraca',
        'options' => [
            'off-balance' => 'Di Luar Neraca',
        ],
    ],
];
