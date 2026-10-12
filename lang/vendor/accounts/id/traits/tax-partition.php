<?php

return [
    'form' => [
        'factor-percent'    => 'Persentase Faktor',
        'factor-ratio'      => 'Rasio Faktor',
        'repartition-type'  => 'Jenis Distribusi',
        'document-type'     => 'Jenis Dokumen',
        'account'           => 'Akun',
        'tax'               => 'Pajak',
        'tax-closing-entry' => 'Entri Penutupan Pajak',
    ],

    'table' => [
        'columns' => [
            'factor-percent'    => 'Persentase Faktor (%)',
            'account'           => 'Akun',
            'tax'               => 'Pajak',
            'company'           => 'Perusahaan',
            'repartition-type'  => 'Jenis Distribusi',
            'document-type'     => 'Jenis Dokumen',
            'tax-closing-entry' => 'Entri Penutupan Pajak',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Distribusi Pajak berhasil diperbarui',
                    'body'  => 'Distribusi pajak telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Distribusi Pajak berhasil dihapus',
                    'body'  => 'Distribusi pajak telah berhasil dihapus.',
                ],
            ],
        ],

        'header-actions' => [
            'create' => [
                'notification' => [
                    'title' => 'Distribusi Pajak berhasil dibuat',
                    'body'  => 'Distribusi pajak telah berhasil dibuat.',
                ],
            ],
        ],
    ],
];
