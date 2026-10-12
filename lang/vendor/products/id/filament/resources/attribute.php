<?php

return [
    'form' => [
        'sections' => [
            'general' => [
                'title'  => 'Umum',

                'fields' => [
                    'name' => 'Nama',
                    'type' => 'Jenis',
                ],
            ],

            'options' => [
                'title'  => 'Opsi',

                'fields' => [
                    'name'        => 'Nama',
                    'color'       => 'Warna',
                    'extra-price' => 'Harga Tambahan',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'name'        => 'Nama',
            'type'        => 'Jenis',
            'deleted-at'  => 'Dihapus Pada',
            'created-at'  => 'Dibuat Pada',
            'updated-at'  => 'Diperbarui Pada',
        ],

        'groups' => [
            'type'       => 'Jenis',
            'created-at' => 'Dibuat Pada',
            'updated-at' => 'Diperbarui Pada',
        ],

        'filters' => [
            'type' => 'Jenis',
        ],

        'actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Atribut berhasil dipulihkan',
                    'body'  => 'Atribut telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Atribut berhasil dihapus',
                    'body'  => 'Atribut telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Atribut berhasil dihapus permanen',
                        'body'  => 'Atribut telah berhasil dihapus secara permanen.',
                    ],

                    'error' => [
                        'title' => 'Atribut tidak dapat dihapus',
                        'body'  => 'Atribut tidak dapat dihapus karena sedang digunakan oleh produk: :products',
                        'more'  => '... +:count lainnya',
                    ],
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Atribut berhasil dipulihkan',
                    'body'  => 'Atribut telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Atribut berhasil dihapus',
                    'body'  => 'Atribut telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'success' => [
                        'title' => 'Atribut berhasil dihapus permanen',
                        'body'  => 'Atribut telah berhasil dihapus secara permanen.',
                    ],

                    'partial' => [
                        'title' => 'Beberapa atribut tidak dapat dihapus',
                        'body'  => 'Atribut ":attributes" tidak dapat dihapus karena sedang digunakan oleh produk: :products',
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
                    'name' => 'Nama',
                    'type' => 'Jenis',
                ],
            ],

            'record-information' => [
                'title' => 'Informasi Data',

                'entries' => [
                    'creator'    => 'Dibuat Oleh',
                    'created_at' => 'Dibuat Pada',
                    'updated_at' => 'Terakhir Diperbarui Pada',
                ],
            ],
        ],
    ],
];
