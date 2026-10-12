<?php

return [
    'title' => 'Tim',

    'navigation' => [
        'title' => 'Tim',
    ],

    'form' => [
        'fields' => [
            'name' => 'Nama',
        ],
    ],

    'table' => [
        'columns' => [
            'name'       => 'Nama',
            'created-by' => 'Dibuat Oleh',
        ],

        'actions' => [
            'edit' => [
                'notification' => [
                    'title' => 'Tim berhasil diperbarui',
                    'body'  => 'Tim telah berhasil diperbarui.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Tim berhasil dihapus',
                    'body'  => 'Tim telah berhasil dihapus.',
                ],
            ],
        ],

        'empty-state-actions' => [
            'create' => [
                'notification' => [
                    'title' => 'Tim berhasil dibuat',
                    'body'  => 'Tim telah berhasil dibuat.',
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'entries' => [
                'name'          => 'Nama',
                'job-title'     => 'Jabatan',
                'work-email'    => 'Email Kantor',
                'work-mobile'   => 'Ponsel Kantor',
                'work-phone'    => 'Telepon Kantor',
                'manager'       => 'Manajer',
                'department'    => 'Departemen',
                'job-position'  => 'Posisi Pekerjaan',
                'team-tags'     => 'Tag Tim',
                'coach'         => 'Pembimbing',
            ],
        ],
    ],

    'infolist' => [
        'entries' => [
            'name' => 'Nama',
        ],
    ],
];
