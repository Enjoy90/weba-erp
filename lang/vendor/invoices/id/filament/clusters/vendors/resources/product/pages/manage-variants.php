<?php

return [
    'title' => 'Varian',

    'form' => [
        'date'                   => 'Tanggal',
        'employee'               => 'Karyawan',
        'description'            => 'Deskripsi',
        'time-spent'             => 'Waktu Terpakai',
        'time-spent-helper-text' => 'Waktu terpakai dalam jam (mis. 1,5 jam berarti 1 jam 30 menit)',
    ],

    'table' => [
        'columns' => [
            'date'                   => 'Tanggal',
            'employee'               => 'Karyawan',
            'description'            => 'Deskripsi',
            'time-spent'             => 'Waktu Terpakai',
            'time-spent-on-subtasks' => 'Waktu Terpakai pada Subtugas',
            'total-time-spent'       => 'Total Waktu Terpakai',
            'remaining-time'         => 'Sisa Waktu',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Varian berhasil dihapus',
                    'body'  => 'Varian telah berhasil dihapus.',
                ],
            ],
        ],
    ],
];
