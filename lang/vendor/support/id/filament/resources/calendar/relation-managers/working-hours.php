<?php

return [
    'modal' => [
        'title' => 'Jam Kerja',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title'  => 'Informasi Umum',
                'fields' => [
                    'attendance-name' => 'Nama Kehadiran',
                    'day-of-week'     => 'Hari',
                ],
            ],

            'timing-information' => [
                'title' => 'Informasi Waktu',

                'fields' => [
                    'day-period' => 'Periode Hari',
                    'week-type'  => 'Jenis Minggu',
                    'work-from'  => 'Jam Mulai',
                    'work-to'    => 'Jam Selesai',
                ],
            ],

            'date-information' => [
                'title' => 'Informasi Tanggal',

                'fields' => [
                    'starting-date' => 'Tanggal Mulai',
                    'ending-date'   => 'Tanggal Berakhir',
                ],
            ],

            'additional-information' => [
                'title' => 'Informasi Tambahan',

                'fields' => [
                    'durations-days' => 'Durasi (Hari)',
                    'display-type'   => 'Jenis Tampilan',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'          => 'Nama Kehadiran',
            'day-of-week'   => 'Hari',
            'day-period'    => 'Periode Hari',
            'work-from'     => 'Jam Mulai',
            'work-to'       => 'Jam Selesai',
            'starting-date' => 'Tanggal Mulai',
            'ending-date'   => 'Tanggal Berakhir',
            'display-type'  => 'Jenis Tampilan',
            'created-by'    => 'Dibuat Oleh',
            'created-at'    => 'Dibuat Pada',
            'updated-at'    => 'Diperbarui Pada',
        ],

        'groups' => [
            'activity-type' => 'Jenis Aktivitas',
            'assignment'    => 'Penugasan',
            'assigned-to'   => 'Ditugaskan Kepada',
            'interval'      => 'Interval',
            'delay-unit'    => 'Satuan Jeda',
            'delay-from'    => 'Jeda Dari',
            'created-by'    => 'Dibuat Oleh',
            'created-at'    => 'Dibuat Pada',
            'updated-at'    => 'Diperbarui Pada',
        ],

        'filters' => [
            'display-type' => 'Jenis Tampilan',
            'day-of-week'  => 'Hari',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Jam Kerja berhasil diperbarui',
                    'body'  => 'Jam kerja telah berhasil diperbarui.',
                ],
            ],

            'create' => [
                'notification' => [
                    'title' => 'Jam Kerja berhasil dibuat',
                    'body'  => 'Jam kerja telah berhasil dibuat.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Jam Kerja berhasil dihapus',
                    'body'  => 'Jam kerja telah berhasil dihapus.',
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Jam Kerja berhasil dipulihkan',
                    'body'  => 'Jam kerja telah berhasil dipulihkan.',
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Jam Kerja berhasil dihapus',
                    'body'  => 'Jam kerja yang dipilih telah berhasil dihapus.',
                ],
            ],

            'restore' => [
                'notification' => [
                    'title' => 'Jam Kerja berhasil dipulihkan',
                    'body'  => 'Jam kerja yang dipilih telah berhasil dipulihkan.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Jam Kerja berhasil dihapus permanen',
                    'body'  => 'Jam kerja yang dipilih telah berhasil dihapus permanen.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title' => 'Informasi Umum',

                'entries' => [
                    'name'        => 'Nama Kehadiran',
                    'day-of-week' => 'Hari',
                ],
            ],

            'timing-information' => [
                'title' => 'Informasi Waktu',

                'entries' => [
                    'day-period' => 'Periode Hari',
                    'week-type'  => 'Jenis Minggu',
                    'work-from'  => 'Jam Mulai',
                    'work-to'    => 'Jam Selesai',
                ],
            ],

            'date-information' => [
                'title' => 'Informasi Tanggal',

                'entries' => [
                    'starting-date' => 'Tanggal Mulai',
                    'ending-date'   => 'Tanggal Berakhir',
                ],
            ],

            'additional-information' => [
                'title' => 'Informasi Tambahan',

                'entries' => [
                    'durations-days' => 'Durasi (Hari)',
                    'display-type'   => 'Jenis Tampilan',
                ],
            ],
        ],

        'note' => 'Catatan',
    ],
];
