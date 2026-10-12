<?php

return [
    'setup' => [
        'title'               => 'Jadwalkan Aktivitas',
        'submit-action-title' => 'Jadwalkan',

        'form' => [
            'fields' => [
                'activity-plan' => 'Rencana Aktivitas',
                'plan-date'     => 'Tanggal Rencana',
                'plan-summary'  => 'Ringkasan Rencana',
                'activity-type' => 'Jenis Aktivitas',
                'due-date'      => 'Tanggal Jatuh Tempo',
                'summary'       => 'Ringkasan',
                'assigned-to'   => 'Ditugaskan Kepada',
                'log-note'      => 'Catatan internal',
            ],
        ],

        'actions' => [
            'notification' => [
                'success' => [
                    'title' => 'Aktivitas berhasil dibuat',
                    'body'  => 'Aktivitas telah berhasil dibuat.',
                ],

                'warning'  => [
                    'title' => 'Tidak ada berkas baru',
                    'body'  => 'Semua berkas sudah diunggah.',
                ],

                'error' => [
                    'title' => 'Gagal membuat aktivitas',
                    'body'  => 'Gagal membuat aktivitas ',
                ],
            ],
        ],
    ],
];
