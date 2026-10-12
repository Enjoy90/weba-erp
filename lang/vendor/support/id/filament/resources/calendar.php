<?php

return [
    'title' => 'Jadwal Kerja',

    'navigation' => [
        'title' => 'Jadwal Kerja',
    ],

    'groups' => [
        'status'     => 'Status',
        'created-by' => 'Dibuat Oleh',
        'created-at' => 'Dibuat Pada',
        'updated-at' => 'Diperbarui Pada',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title'  => 'Informasi Umum',
                'fields' => [
                    'name'                  => 'Nama',
                    'schedule-name'         => 'Nama Jadwal',
                    'schedule-name-tooltip' => 'Tuliskan nama jadwal kerja yang deskriptif.',
                    'timezone'              => 'Zona Waktu',
                    'timezone-tooltip'      => 'Pilih zona waktu untuk jadwal kerja.',
                    'company'               => 'Perusahaan',
                ],
            ],

            'configuration' => [
                'title'  => 'Konfigurasi Jam Kerja',
                'fields' => [
                    'hours-per-day'                   => 'Jam per Hari',
                    'hours-per-day-suffix'            => 'Jam',
                    'full-time-required-hours'        => 'Jam Wajib Penuh Waktu',
                    'full-time-required-hours-suffix' => 'Jam per Minggu',
                ],
            ],

            'flexibility' => [
                'title'  => 'Fleksibilitas',
                'fields' => [
                    'status'                     => 'Status',
                    'two-weeks-calendar'         => 'Kalender Dua Mingguan',
                    'two-weeks-calendar-tooltip' => 'Aktifkan jadwal kerja bergantian setiap dua minggu.',
                    'flexible-hours'             => 'Jam Fleksibel',
                    'flexible-hours-tooltip'     => 'Izinkan karyawan memiliki jam kerja fleksibel.',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'id'             => 'ID',
            'name'           => 'Nama Jadwal',
            'timezone'       => 'Zona Waktu',
            'company'        => 'Perusahaan',
            'flexible-hours' => 'Jam Fleksibel',
            'status'         => 'Status',
            'daily-hours'    => 'Jam Harian',
            'created-by'     => 'Dibuat Oleh',
            'created-at'     => 'Dibuat Pada',
            'updated-at'     => 'Diperbarui Pada',
        ],

        'filters' => [
            'company'                  => 'Perusahaan',
            'is-active'                => 'Status',
            'two-week-calendar'        => 'Kalender Dua Mingguan',
            'flexible-hours'           => 'Jam Fleksibel',
            'timezone'                 => 'Zona Waktu',
            'name'                     => 'Nama Jadwal',
            'attendance'               => 'Kehadiran',
            'created-by'               => 'Dibuat Oleh',
            'daily-hours'              => 'Jam Harian',
            'full-time-required-hours' => 'Jam Wajib Penuh Waktu',
            'updated-at'               => 'Diperbarui Pada',
            'created-at'               => 'Dibuat Pada',
        ],

        'groups' => [
            'name'           => 'Nama Jadwal',
            'status'         => 'Status',
            'timezone'       => 'Zona Waktu',
            'flexible-hours' => 'Jam Fleksibel',
            'daily-hours'    => 'Jam Harian',
            'created-by'     => 'Dibuat Oleh',
            'created-at'     => 'Dibuat Pada',
            'updated-at'     => 'Diperbarui Pada',
        ],

        'actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Jadwal Kerja berhasil dipulihkan',
                    'body'  => 'Jadwal kerja telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Jadwal Kerja berhasil dihapus',
                    'body'  => 'Jadwal kerja telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Jadwal Kerja berhasil dihapus permanen',
                    'body'  => 'Jadwal kerja telah berhasil dihapus permanen.',
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Jadwal Kerja berhasil dipulihkan',
                    'body'  => 'Jadwal kerja yang dipilih telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Jadwal Kerja berhasil dihapus',
                    'body'  => 'Jadwal kerja yang dipilih telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Jadwal Kerja berhasil dihapus permanen',
                    'body'  => 'Jadwal kerja yang dipilih telah berhasil dihapus permanen.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title'   => 'Informasi Umum',
                'entries' => [
                    'name'                  => 'Nama',
                    'schedule-name'         => 'Nama Jadwal',
                    'schedule-name-tooltip' => 'Tuliskan nama jadwal kerja yang deskriptif.',
                    'timezone'              => 'Zona Waktu',
                    'timezone-tooltip'      => 'Pilih zona waktu untuk jadwal kerja.',
                    'company'               => 'Perusahaan',
                ],
            ],

            'configuration' => [
                'title'   => 'Konfigurasi Jam Kerja',
                'entries' => [
                    'hours-per-day'                   => 'Jam per Hari',
                    'hours-per-day-suffix'            => ' Jam',
                    'full-time-required-hours'        => 'Jam Wajib Penuh Waktu',
                    'full-time-required-hours-suffix' => ' Jam per Minggu',
                ],
            ],

            'flexibility' => [
                'title'   => 'Fleksibilitas',
                'entries' => [
                    'status'                     => 'Status',
                    'two-weeks-calendar'         => 'Kalender Dua Mingguan',
                    'two-weeks-calendar-tooltip' => 'Aktifkan jadwal kerja bergantian setiap dua minggu.',
                    'flexible-hours'             => 'Jam Fleksibel',
                    'flexible-hours-tooltip'     => 'Izinkan karyawan memiliki jam kerja fleksibel.',
                ],
            ],
        ],
    ],
];
