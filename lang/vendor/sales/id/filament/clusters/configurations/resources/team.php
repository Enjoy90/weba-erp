<?php

return [
    'title' => 'Tim Penjualan',

    'navigation' => [
        'title' => 'Tim Penjualan',
    ],

    'form' => [
        'sections' => [
            'fields' => [
                'name'     => 'Tim Penjualan',
                'status'   => 'Status',
                'fieldset' => [
                    'team-details' => [
                        'title'  => 'Detail Tim',
                        'fields' => [
                            'team-leader'            => 'Ketua Tim',
                            'company'                => 'Perusahaan',
                            'invoiced-target'        => 'Target Faktur',
                            'invoiced-target-suffix' => '/ Bulan',
                            'color'                  => 'Warna',
                            'members'                => 'Anggota',
                        ],
                    ],
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'id'              => 'ID',
            'company'         => 'Perusahaan',
            'team-leader'     => 'Ketua Tim',
            'name'            => 'Nama',
            'status'          => 'Status',
            'invoiced-target' => 'Target Faktur',
            'color'           => 'Warna',
            'created-by'      => 'Dibuat oleh',
            'created-at'      => 'Dibuat pada',
            'updated-at'      => 'Diperbarui pada',
        ],

        'filters' => [
            'name'        => 'Nama',
            'team-leader' => 'Ketua Tim',
            'company'     => 'Perusahaan',
            'created-by'  => 'Dibuat oleh',
            'updated-at'  => 'Diperbarui pada',
            'created-at'  => 'Dibuat pada',
        ],

        'groups' => [
            'name'        => 'Nama',
            'company'     => 'Perusahaan',
            'team-leader' => 'Ketua Tim',
            'created-at'  => 'Dibuat pada',
            'updated-at'  => 'Diperbarui pada',
        ],

        'actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Tim penjualan berhasil dipulihkan',
                    'body'  => 'Tim penjualan telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Tim penjualan berhasil dihapus',
                    'body'  => 'Tim penjualan telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Tim penjualan berhasil dihapus permanen',
                    'body'  => 'Tim penjualan telah berhasil dihapus permanen.',
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Tim penjualan berhasil dipulihkan',
                    'body'  => 'Tim penjualan yang dipilih telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Tim penjualan berhasil dihapus',
                    'body'  => 'Tim penjualan yang dipilih telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Tim penjualan berhasil dihapus permanen',
                    'body'  => 'Tim penjualan yang dipilih telah berhasil dihapus permanen.',
                ],
            ],
        ],

        'empty-state-action' => [
            'create' => [
                'notification' => [
                    'title' => 'Tim penjualan berhasil dibuat',
                    'body'  => 'Tim penjualan telah berhasil dibuat.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'entries' => [
                'name'     => 'Tim Penjualan',
                'status'   => 'Status',
                'fieldset' => [
                    'team-details' => [
                        'title'   => 'Detail Tim',
                        'entries' => [
                            'team-leader'            => 'Ketua Tim',
                            'company'                => 'Perusahaan',
                            'invoiced-target'        => 'Target Faktur',
                            'invoiced-target-suffix' => '/ Bulan',
                            'color'                  => 'Warna',
                            'members'                => 'Anggota',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
