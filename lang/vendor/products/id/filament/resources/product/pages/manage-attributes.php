<?php

return [
    'title' => 'Atribut',

    'form' => [
        'attribute' => 'Atribut',
        'values'    => 'Nilai',
    ],

    'table' => [
        'description' => 'Peringatan: menambah atau menghapus atribut akan menghapus dan membuat ulang varian yang ada sehingga kustomisasi pada varian tersebut dapat hilang.',

        'header-actions' => [
            'create' => [
                'label' => 'Tambah Atribut',

                'notification' => [
                    'title' => 'Atribut berhasil dibuat',
                    'body'  => 'Atribut telah berhasil dibuat.',
                ],
            ],
        ],

        'columns' => [
            'attribute' => 'Atribut',
            'values'    => 'Nilai',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Atribut berhasil diperbarui',
                    'body'  => 'Atribut telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Atribut berhasil dihapus',
                    'body'  => 'Atribut telah berhasil dihapus.',
                ],
            ],
        ],
    ],
];
