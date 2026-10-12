<?php

return [
    'title' => 'Varian',

    'form' => [
        'date'                   => 'Tanggal',
        'employee'               => 'Karyawan',
        'description'            => 'Deskripsi',
        'time-spent'             => 'Waktu yang Digunakan',
        'time-spent-helper-text' => 'Waktu yang digunakan dalam jam (mis. 1.5 jam berarti 1 jam 30 menit)',
    ],

    'table' => [
        'columns' => [
            'date'                   => 'Tanggal',
            'employee'               => 'Karyawan',
            'description'            => 'Deskripsi',
            'time-spent'             => 'Waktu yang Digunakan',
            'time-spent-on-subtasks' => 'Waktu pada Subtugas',
            'total-time-spent'       => 'Total Waktu yang Digunakan',
            'remaining-time'         => 'Sisa Waktu',
            'variant-values'         => 'Nilai Varian',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Varian berhasil dihapus',
                    'body'  => 'Varian telah berhasil dihapus.',
                ],
            ],

            'view' => [
                'extra-footer-actions' => [
                    'print' => [
                        'label' => 'Cetak Label',

                        'form' => [
                            'fields' => [
                                'quantity' => 'Jumlah Label',
                                'format'   => 'Format',

                                'format-options' => [
                                    'dymo'       => 'Dymo',
                                    '2x7_price'  => '2x7 dengan harga',
                                    '4x7_price'  => '4x7 dengan harga',
                                    '4x12'       => '4x12',
                                    '4x12_price' => '4x12 dengan harga',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
