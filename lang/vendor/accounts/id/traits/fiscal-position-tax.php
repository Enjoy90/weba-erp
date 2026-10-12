<?php

return [
    'form' => [
        'fields' => [
            'tax-source'      => 'Pajak Asal',
            'tax-destination' => 'Pajak Tujuan',
        ],
    ],

    'table' => [
        'columns' => [
            'tax-source'      => 'Pajak Asal',
            'tax-destination' => 'Pajak Tujuan',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Pemetaan Pajak berhasil diperbarui',
                    'body'  => 'Pemetaan pajak telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Pemetaan Pajak berhasil dihapus',
                    'body'  => 'Pemetaan pajak telah berhasil dihapus.',
                ],
            ],
        ],

        'header-actions' => [
            'create' => [
                'notification' => [
                    'title' => 'Pemetaan Pajak berhasil dibuat',
                    'body'  => 'Pemetaan pajak telah berhasil dibuat.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'entries' => [
            'tax-source'      => 'Pajak Asal',
            'tax-destination' => 'Pajak Tujuan',
        ],
    ],
];
