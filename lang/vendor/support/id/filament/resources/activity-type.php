<?php

return [
    'title' => 'Departemen',

    'navigation' => [
        'title' => 'Departemen',
        'group' => 'Karyawan',
    ],

    'form' => [
        'sections' => [
            'activity-type-details' => [
                'title' => 'Informasi Umum',

                'fields' => [
                    'name'                => 'Jenis Aktivitas',
                    'name-tooltip'        => 'Masukkan nama resmi jenis aktivitas',
                    'action'              => 'Tindakan',
                    'default-user'        => 'Pengguna Bawaan',
                    'summary'             => 'Ringkasan',
                    'note'                => 'Catatan',
                ],
            ],

            'delay-information' => [
                'title' => 'Informasi Jeda',

                'fields' => [
                    'delay-count'            => 'Jumlah Jeda',
                    'delay-unit'             => 'Satuan Jeda',
                    'delay-form'             => 'Jeda Dari',
                    'delay-form-helper-text' => 'Acuan perhitungan jeda',
                ],
            ],

            'advanced-information' => [
                'title' => 'Informasi Lanjutan',

                'fields' => [
                    'icon'                => 'Ikon',
                    'decoration-type'     => 'Jenis Dekorasi',
                    'chaining-type'       => 'Jenis Rangkaian',
                    'suggest'             => 'Sarankan',
                    'trigger'             => 'Picu',
                ],
            ],

            'status-and-configuration-information' => [
                'title' => 'Status & Konfigurasi',

                'fields' => [
                    'status'               => 'Status',
                    'keep-done-activities' => 'Simpan Aktivitas Selesai',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'       => 'Jenis Aktivitas',
            'summary'    => 'Ringkasan',
            'planned-in' => 'Direncanakan Dalam',
            'type'       => 'Jenis',
            'action'     => 'Tindakan',
            'status'     => 'Status',
            'created-at' => 'Dibuat Pada',
            'updated-at' => 'Diperbarui Pada',
        ],

        'groups' => [
            'name'             => 'Nama',
            'action-category'  => 'Kategori Tindakan',
            'status'           => 'Status',
            'delay-count'      => 'Jumlah Jeda',
            'delay-unit'       => 'Satuan Jeda',
            'delay-source'     => 'Acuan Jeda',
            'associated-model' => 'Model Terkait',
            'chaining-type'    => 'Jenis Rangkaian',
            'decoration-type'  => 'Jenis Dekorasi',
            'default-user'     => 'Pengguna Bawaan',
            'creation-date'    => 'Tanggal Dibuat',
            'last-update'      => 'Pembaruan Terakhir',
        ],

        'filters' => [
            'action'    => 'Tindakan',
            'status'    => 'Status',
            'has-delay' => 'Memiliki Jeda',
        ],

        'actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Jenis aktivitas berhasil dipulihkan',
                    'body'  => 'Jenis aktivitas telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Jenis aktivitas berhasil dihapus',
                    'body'  => 'Jenis aktivitas telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Jenis aktivitas berhasil dihapus permanen',
                        'body'  => 'Jenis aktivitas telah berhasil dihapus permanen.',
                    ],
                    'error' => [
                        'title' => 'Jenis aktivitas tidak dapat dihapus',
                        'body'  => 'Jenis aktivitas tidak dapat dihapus karena sedang digunakan.',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Jenis aktivitas berhasil dipulihkan',
                    'body'  => 'Jenis aktivitas yang dipilih telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Jenis aktivitas berhasil dihapus',
                    'body'  => 'Jenis aktivitas yang dipilih telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Jenis aktivitas berhasil dihapus permanen',
                    'body'  => 'Jenis aktivitas yang dipilih telah berhasil dihapus permanen.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'activity-type-details' => [
                'title' => 'Informasi Umum',

                'entries' => [
                    'name'                => 'Jenis Aktivitas',
                    'name-tooltip'        => 'Masukkan nama resmi jenis aktivitas',
                    'action'              => 'Tindakan',
                    'default-user'        => 'Pengguna Bawaan',
                    'plugin'              => 'Plugin',
                    'summary'             => 'Ringkasan',
                    'note'                => 'Catatan',
                ],
            ],

            'delay-information' => [
                'title' => 'Informasi Jeda',

                'entries' => [
                    'delay-count'            => 'Jumlah Jeda',
                    'delay-unit'             => 'Satuan Jeda',
                    'delay-form'             => 'Jeda Dari',
                    'delay-form-helper-text' => 'Acuan perhitungan jeda',
                ],
            ],

            'advanced-information' => [
                'title' => 'Informasi Lanjutan',

                'entries' => [
                    'icon'                => 'Ikon',
                    'decoration-type'     => 'Jenis Dekorasi',
                    'chaining-type'       => 'Jenis Rangkaian',
                    'suggest'             => 'Sarankan',
                    'trigger'             => 'Picu',
                ],
            ],

            'status-and-configuration-information' => [
                'title' => 'Status & Konfigurasi',

                'entries' => [
                    'status'               => 'Status',
                    'keep-done-activities' => 'Simpan Aktivitas Selesai',
                ],
            ],
        ],
    ],
];
