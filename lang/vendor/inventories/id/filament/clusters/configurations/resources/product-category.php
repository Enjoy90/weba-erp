<?php

return [
    'navigation' => [
        'title' => 'Kategori',
        'group' => 'Produk',
    ],

    'form' => [
        'sections' => [
            'inventory' => [
                'title' => 'Inventaris',

                'fieldsets' => [
                    'logistics' => [
                        'title' => 'Logistik',

                        'fields' => [
                            'routes' => 'Rute',
                        ],
                    ],
                ],
            ],
        ],
    ],

    'infolist' => [
        'sections' => [
            'inventory' => [
                'title' => 'Inventaris',

                'subsections' => [
                    'logistics' => [
                        'title' => 'Logistik',

                        'entries' => [
                            'routes'     => 'Rute Gudang',
                            'route_name' => 'Nama Rute',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
