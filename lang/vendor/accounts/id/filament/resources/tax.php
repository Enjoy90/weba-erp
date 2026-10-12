<?php

return [
    'form' => [
        'sections' => [
            'fields' => [
                'name'                         => 'Nama',
                'tax-type'                     => 'Jenis Pajak',
                'tax-computation'              => 'Perhitungan Pajak',
                'tax-scope'                    => 'Cakupan Pajak',
                'status'                       => 'Status',
                'amount'                       => 'Nilai',
                'formula'                      => 'Rumus',
                'formula-helper-text'          => 'Hanya aritmetika: angka, + - * / ( ), fungsi :functions dan variabel berikut: :variables',
                'children-taxes'               => 'Pajak Turunan',
                'children-taxes-helper-text'   => 'Nilai pajak ini adalah jumlah dari pajak-pajak turunannya.',
                'children-taxes-type-mismatch' => 'Pajak turunan harus berjenis pajak :type atau tidak memiliki jenis pajak. Pajak berikut tidak memenuhi: :taxes',
            ],

            'repeater' => [
                'invoice-repartition-lines' => [
                    'label' => 'Baris Distribusi Faktur',
                ],

                'refund-repartition-lines' => [
                    'label' => 'Baris Distribusi Pengembalian Dana',
                ],

                'fields' => [
                    'type'           => 'Jenis',
                    'factor-percent' => 'Faktor %',
                    'account'        => 'Akun',
                ],
            ],

            'field-set' => [
                'advanced-options' => [
                    'title' => 'Opsi Lanjutan',

                    'fields' => [
                        'invoice-label'       => 'Label faktur',
                        'tax-group'           => 'Grup Pajak',
                        'country'             => 'Negara',
                        'include-in-price'    => 'Termasuk dalam Harga',
                        'include-base-amount' => 'Memengaruhi Dasar Pajak Berikutnya',
                        'is-base-affected'    => 'Dasar Dipengaruhi Pajak Sebelumnya',
                    ],
                ],

                'fields' => [
                    'description' => 'Deskripsi',
                    'legal-notes' => 'Catatan Hukum',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'                   => 'Nama',
            'amount-type'            => 'Jenis Nilai',
            'company'                => 'Perusahaan',
            'tax-group'              => 'Grup Pajak',
            'country'                => 'Negara',
            'tax-type'               => 'Jenis Pajak',
            'tax-scope'              => 'Cakupan Pajak',
            'amount-type'            => 'Jenis Nilai',
            'invoice-label'          => 'Label Faktur',
            'tax-exigibility'        => 'Saat Terutang Pajak',
            'price-include-override' => 'Penggantian Harga Termasuk Pajak',
            'amount'                 => 'Nilai',
            'status'                 => 'Status',
            'include-base-amount'    => 'Sertakan Nilai Dasar',
            'is-base-affected'       => 'Dasar Terpengaruh',
        ],

        'groups' => [
            'name'         => 'Nama',
            'company'      => 'Perusahaan',
            'tax-group'    => 'Grup Pajak',
            'country'      => 'Negara',
            'created-by'   => 'Dibuat oleh',
            'type-tax-use' => 'Penggunaan Pajak',
            'tax-scope'    => 'Cakupan Pajak',
            'amount-type'  => 'Jenis Nilai',
        ],

        'actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Pajak berhasil dihapus',
                        'body'  => 'Pajak telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Pajak tidak dapat dihapus',
                        'body'  => 'Pajak tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Pajak berhasil dihapus',
                        'body'  => 'Pajak-pajak tersebut telah berhasil dihapus.',
                    ],

                    'error' => [
                        'title' => 'Pajak tidak dapat dihapus',
                        'body'  => 'Pajak-pajak tersebut tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'pages' => [
            'create' => [
                'notifications' => [
                    'invalid-repartition-lines' => [
                        'title' => 'Baris Distribusi Tidak Valid',
                    ],
                ],
            ],

            'edit' => [
                'notifications' => [
                    'invalid-repartition-lines' => [
                        'title' => 'Baris Distribusi Tidak Valid',
                    ],
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'entries' => [
                'name'            => 'Nama',
                'tax-type'        => 'Jenis Pajak',
                'tax-computation' => 'Perhitungan Pajak',
                'tax-scope'       => 'Cakupan Pajak',
                'status'          => 'Status',
                'amount'          => 'Nilai',
                'formula'         => 'Rumus',
                'children-taxes'  => 'Pajak Turunan',
            ],

            'field-set' => [
                'advanced-options' => [
                    'title' => 'Opsi Lanjutan',

                    'entries' => [
                        'invoice-label'       => 'Label faktur',
                        'tax-group'           => 'Grup Pajak',
                        'country'             => 'Negara',
                        'include-in-price'    => 'Termasuk dalam harga',
                        'include-base-amount' => 'Sertakan nilai dasar',
                        'is-base-affected'    => 'Dasar terpengaruh',
                    ],
                ],

                'description-and-legal-notes' => [
                    'title'   => 'Deskripsi & Catatan Hukum Faktur',
                    'entries' => [
                        'description' => 'Deskripsi',
                        'legal-notes' => 'Catatan Hukum',
                    ],
                ],
            ],
        ],
    ],

];
