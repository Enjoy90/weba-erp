<?php

return [
    'navigation' => [
        'title' => 'Work Center',
        'group' => 'Konfigurasi',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title'  => 'Umum',
                'fields' => [
                    'name'                     => 'Nama',
                    'name-placeholder'         => 'mis. Lini Perakitan 1',
                    'code'                     => 'Kode',
                    'code-placeholder'         => 'mis. AL1',
                    'working-state'            => 'Status Kerja',
                    'color'                    => 'Warna',
                    'tags'                     => 'Tag',
                    'alternative-work-centers' => 'Work Center Alternatif',
                    'company'                  => 'Perusahaan',
                    'calendar'                 => 'Jam Kerja',
                ],
            ],

            'information' => [
                'title'     => 'Informasi Umum',
                'fieldsets' => [
                    'production-information' => 'Informasi Produksi',
                    'costing-information'    => 'Informasi Biaya',
                ],
                'fields' => [
                    'default-capacity' => 'Kapasitas Default',
                    'time-efficiency'  => 'Efisiensi Waktu',
                    'oee-target'       => 'Target OEE',
                    'costs-per-hour'   => 'Biaya per Jam',
                    'cost-suffix'      => 'per jam',
                    'setup-time'       => 'Waktu Persiapan',
                    'cleanup-time'     => 'Waktu Pembersihan',
                    'time-suffix'      => 'menit',
                ],
            ],

            'description' => [
                'title'  => 'Deskripsi',
                'fields' => [
                    'note'             => 'Deskripsi',
                    'note-placeholder' => 'Deskripsi work center...',
                ],
            ],

            'specific-capacity' => [
                'title'  => 'Kapasitas Khusus',
                'fields' => [
                    'records' => 'Kapasitas Khusus',
                ],
                'columns' => [
                    'product'      => 'Produk',
                    'product-uom'  => 'Satuan',
                    'capacity'     => 'Kapasitas',
                    'setup-time'   => 'Waktu Persiapan',
                    'cleanup-time' => 'Waktu Pembersihan',
                ],
                'actions' => [
                    'add' => 'Tambah baris',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'             => 'Nama',
            'code'             => 'Kode',
            'company'          => 'Perusahaan',
            'calendar'         => 'Jam Kerja',
            'working-state'    => 'Status Kerja',
            'default-capacity' => 'Kapasitas',
            'time-efficiency'  => 'Efisiensi',
            'costs-per-hour'   => 'Biaya per Jam',
            'deleted-at'       => 'Dihapus Pada',
            'created-at'       => 'Dibuat Pada',
            'updated-at'       => 'Diperbarui Pada',
        ],

        'groups' => [
            'company' => 'Perusahaan',
        ],

        'filters' => [
            'company'       => 'Perusahaan',
            'working-state' => 'Status Kerja',
        ],

        'actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Work center berhasil dipulihkan',
                    'body'  => 'Work center telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Work center berhasil diarsipkan',
                    'body'  => 'Work center telah berhasil diarsipkan.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Work center berhasil dihapus',
                        'body'  => 'Work center telah dihapus secara permanen.',
                    ],

                    'error' => [
                        'title' => 'Work center tidak dapat dihapus',
                        'body'  => 'Work center tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Work center berhasil dipulihkan',
                    'body'  => 'Work center yang dipilih telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Work center berhasil diarsipkan',
                    'body'  => 'Work center yang dipilih telah berhasil diarsipkan.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Work center berhasil dihapus',
                        'body'  => 'Work center yang dipilih telah dihapus secara permanen.',
                    ],

                    'error' => [
                        'title' => 'Work center tidak dapat dihapus',
                        'body'  => 'Satu atau beberapa work center yang dipilih sedang digunakan.',
                    ],
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title' => 'Informasi Umum',

                'entries' => [
                    'name'                     => 'Nama Work Center',
                    'code'                     => 'Kode',
                    'working-state'            => 'Status Kerja',
                    'tags'                     => 'Tag',
                    'alternative-work-centers' => 'Work Center Alternatif',
                    'company'                  => 'Perusahaan',
                    'calendar'                 => 'Jam Kerja',
                ],
            ],

            'information' => [
                'title'     => 'Informasi Umum',
                'fieldsets' => [
                    'production-information' => 'Informasi Produksi',
                    'costing-information'    => 'Informasi Biaya',
                ],

                'entries' => [
                    'default-capacity' => 'Kapasitas Default',
                    'time-efficiency'  => 'Efisiensi Waktu',
                    'oee-target'       => 'Target OEE',
                    'costs-per-hour'   => 'Biaya per Jam',
                    'cost-suffix'      => 'per work center',
                    'setup-time'       => 'Waktu Persiapan',
                    'cleanup-time'     => 'Waktu Pembersihan',
                    'time-suffix'      => 'menit',
                ],
            ],

            'description' => [
                'title'   => 'Deskripsi',
                'entries' => [
                    'note' => 'Deskripsi',
                ],
            ],

            'specific-capacity' => [
                'title'   => 'Kapasitas Khusus',
                'columns' => [
                    'product'      => 'Produk',
                    'product-uom'  => 'Satuan',
                    'capacity'     => 'Kapasitas',
                    'setup-time'   => 'Waktu Persiapan',
                    'cleanup-time' => 'Waktu Pembersihan',
                ],
            ],

            'record-information' => [
                'title' => 'Informasi Data',

                'entries' => [
                    'created-by'   => 'Dibuat Oleh',
                    'created-at'   => 'Dibuat Pada',
                    'last-updated' => 'Terakhir Diperbarui',
                ],
            ],
        ],
    ],
];
