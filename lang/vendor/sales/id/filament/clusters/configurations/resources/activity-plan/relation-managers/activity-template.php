<?php

return [
    'form' => [
        'sections' => [
            'activity-details' => [
                'title' => 'Detail Aktivitas',

                'fields' => [
                    'activity-type' => 'Jenis Aktivitas',
                    'summary'       => 'Ringkasan',
                    'note'          => 'Catatan',
                ],
            ],

            'assignment' => [
                'title' => 'Penugasan',

                'fields' => [
                    'assignment' => 'Penugasan',
                    'assignee'   => 'Penerima Tugas',
                ],
            ],

            'delay-information' => [
                'title' => 'Informasi Jeda',

                'fields' => [
                    'delay-count'            => 'Jumlah Jeda',
                    'delay-unit'             => 'Satuan Jeda',
                    'delay-from'             => 'Jeda Dihitung Dari',
                    'delay-from-helper-text' => 'Sumber perhitungan jeda',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'activity-type' => 'Jenis Aktivitas',
            'summary'       => 'Ringkasan',
            'assignment'    => 'Penugasan',
            'assigned-to'   => 'Ditugaskan Kepada',
            'interval'      => 'Interval',
            'delay-unit'    => 'Satuan Jeda',
            'delay-from'    => 'Jeda Dihitung Dari',
            'created-by'    => 'Dibuat oleh',
            'created-at'    => 'Dibuat pada',
            'updated-at'    => 'Diperbarui pada',
        ],

        'groups' => [
            'activity-type' => 'Jenis Aktivitas',
            'assignment'    => 'Penugasan',
            'assigned-to'   => 'Ditugaskan Kepada',
            'interval'      => 'Interval',
            'delay-unit'    => 'Satuan Jeda',
            'delay-from'    => 'Jeda Dihitung Dari',
            'created-by'    => 'Dibuat oleh',
            'created-at'    => 'Dibuat pada',
            'updated-at'    => 'Diperbarui pada',
        ],

        'filters' => [
            'activity-type'   => 'Jenis Aktivitas',
            'activity-status' => 'Status Aktivitas',
            'has-delay'       => 'Memiliki Jeda',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Template aktivitas berhasil diperbarui',
                    'body'  => 'Template aktivitas telah berhasil diperbarui.',
                ],
            ],

            'create' => [
                'notification' => [
                    'title' => 'Template aktivitas berhasil dibuat',
                    'body'  => 'Template aktivitas telah berhasil dibuat.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Template aktivitas berhasil dihapus',
                    'body'  => 'Template aktivitas telah berhasil dihapus.',
                ],
            ],
        ],

        'bulk-actions' => [
            'delete' => [
                'notification' => [
                    'title' => 'Template aktivitas berhasil dihapus',
                    'body'  => 'Template aktivitas yang dipilih telah berhasil dihapus.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'activity-details' => [
                'title' => 'Detail Aktivitas',

                'entries' => [
                    'activity-type' => 'Jenis Aktivitas',
                    'summary'       => 'Ringkasan',
                ],
            ],

            'assignment' => [
                'title' => 'Penugasan',

                'entries' => [
                    'assignment' => 'Penugasan',
                    'assignee'   => 'Penerima Tugas',
                ],
            ],

            'delay-information' => [
                'title' => 'Informasi Jeda',

                'entries' => [
                    'delay-count'            => 'Jumlah Jeda',
                    'delay-unit'             => 'Satuan Jeda',
                    'delay-from'             => 'Jeda Dihitung Dari',
                    'delay-from-helper-text' => 'Sumber perhitungan jeda',
                ],
            ],
        ],

        'note' => 'Catatan',
    ],
];
