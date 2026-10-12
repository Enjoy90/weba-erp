<?php

return [
    'navigation' => [
        'title' => 'Kategori Satuan',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title' => 'Umum',

                'fields' => [
                    'name' => 'Nama',
                ],
            ],

            'uoms' => [
                'title' => 'Satuan Ukur',

                'fields' => [
                    'uoms'     => 'Satuan',
                    'type'     => 'Jenis',
                    'name'     => 'Satuan Ukur',
                    'ratio'    => 'Rasio',
                    'rounding' => 'Presisi Pembulatan',
                ],

                'validations' => [
                    'missing-reference'          => 'Kategori ini harus memiliki satuan ukur referensi.',
                    'multiple-references'        => 'Kategori ini hanya boleh memiliki satu satuan ukur referensi.',
                    'ratio-greater-than-zero'    => 'Rasio konversi satuan ukur tidak boleh nol.',
                    'rounding-greater-than-zero' => 'Presisi pembulatan harus lebih besar dari nol.',
                ],

                'actions' => [
                    'add' => 'Tambah Satuan',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'       => 'Nama',
            'uoms'       => 'Satuan',
            'created-at' => 'Dibuat Pada',
            'updated-at' => 'Diperbarui Pada',
        ],

        'groups' => [
            'created-at' => 'Dibuat Pada',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Kategori Satuan berhasil diperbarui',
                    'body'  => 'Kategori satuan telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Kategori Satuan berhasil dihapus',
                    'body'  => 'Kategori satuan telah berhasil dihapus.',
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Kategori Satuan berhasil dihapus',
                    'body'  => 'Kategori satuan yang dipilih telah berhasil dihapus.',
                ],
            ],
        ],
    ],
];
