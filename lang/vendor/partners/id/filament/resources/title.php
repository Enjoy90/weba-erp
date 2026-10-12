<?php

return [
    'form' => [
        'name'       => 'Nama',
        'short-name' => 'Nama Singkat',
    ],

    'table' => [
        'columns' => [
            'name'       => 'Nama',
            'short-name' => 'Nama Singkat',
            'created-at' => 'Dibuat Pada',
            'updated-at' => 'Diperbarui Pada',
        ],

        'filters' => [
            'creator' => 'Pembuat',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Gelar berhasil diperbarui',
                    'body'  => 'Gelar telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Gelar berhasil dihapus',
                    'body'  => 'Gelar telah berhasil dihapus.',
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Gelar berhasil dihapus',
                    'body'  => 'Gelar telah berhasil dihapus.',
                ],
            ],
        ],
    ],
];
