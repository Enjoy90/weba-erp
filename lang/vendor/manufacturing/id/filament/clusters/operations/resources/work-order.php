<?php

return [
    'navigation' => [
        'title' => 'Work Order',
        'group' => 'Operasi',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title'  => 'Umum',
                'fields' => [
                    'work-order'          => 'Work Order',
                    'work-center'         => 'Work Center',
                    'product'             => 'Produk',
                    'quantity'            => 'Jumlah',
                    'manufacturing-order' => 'Order Produksi',
                    'lot-serial'          => 'Lot/Nomor Seri',
                    'start-date'          => 'Tanggal Mulai',
                    'end-date'            => 'Tanggal Selesai',
                    'date-range-separator'=> 'sampai',
                    'expected-duration'   => 'Durasi Perkiraan',
                    'duration-suffix'     => 'menit',
                    'real-duration'       => 'Durasi Aktual',
                ],
            ],
        ],
        'tabs' => [
            'time-tracking' => [
                'title'      => 'Pelacakan Waktu',
                'add-action' => 'Tambah baris',
                'columns'    => [
                    'user'         => 'Pengguna',
                    'duration'     => 'Durasi',
                    'start-date'   => 'Tanggal Mulai',
                    'end-date'     => 'Tanggal Selesai',
                    'productivity' => 'Produktivitas',
                ],
                'footer' => [
                    'real-duration' => 'Durasi Aktual',
                ],
            ],
            'components' => [
                'title'      => 'Komponen',
                'add-action' => 'Tambah baris',
                'columns'    => [
                    'product'    => 'Produk',
                    'from'       => 'Dari',
                    'to-consume' => 'Akan Dipakai',
                    'quantity'   => 'Jumlah',
                    'uom'        => 'Satuan',
                ],
            ],
            'work-instruction' => [
                'title'   => 'Instruksi Kerja',
                'entries' => [
                    'operation' => 'Operasi',
                    'worksheet' => 'Lembar Kerja',
                ],
            ],
            'blocked-by' => [
                'title'  => 'Diblokir Oleh',
                'fields' => [
                    'work-orders' => 'Work Order',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'operation'           => 'Operasi',
            'work-center'         => 'Work Center',
            'manufacturing-order' => 'Order Produksi',
            'product'             => 'Produk',
            'quantity-remaining'  => 'Sisa Jumlah',
            'lot-serial'          => 'Lot/Nomor Seri',
            'start'               => 'Mulai',
            'end'                 => 'Selesai',
            'expected-duration'   => 'Durasi Perkiraan',
            'real-duration'       => 'Durasi Aktual',
            'status'              => 'Status',
        ],
        'groups' => [
            'status'              => 'Status',
            'work-center'         => 'Work Center',
            'manufacturing-order' => 'Order Produksi',
            'product'             => 'Produk',
            'start'               => 'Mulai',
            'end'                 => 'Selesai',
        ],
        'filters' => [
            'work-order'          => 'Work Order',
            'status'              => 'Status',
            'operation'           => 'Operasi',
            'work-center'         => 'Work Center',
            'manufacturing-order' => 'Order Produksi',
            'product'             => 'Produk',
            'start'               => 'Mulai',
            'end'                 => 'Selesai',
            'created-at'          => 'Dibuat Pada',
            'updated-at'          => 'Diperbarui Pada',
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title'   => 'Umum',
                'entries' => [
                    'work-order'          => 'Work Order',
                    'work-center'         => 'Work Center',
                    'product'             => 'Produk',
                    'quantity'            => 'Jumlah',
                    'manufacturing-order' => 'Order Produksi',
                    'lot-serial'          => 'Lot/Nomor Seri',
                    'start-date'          => 'Tanggal Mulai',
                    'end-date'            => 'Tanggal Selesai',
                    'expected-duration'   => 'Durasi Perkiraan',
                    'real-duration'       => 'Durasi Aktual',
                ],
            ],
        ],
        'tabs' => [
            'time-tracking' => [
                'title'  => 'Pelacakan Waktu',
                'footer' => [
                    'real-duration' => 'Durasi Aktual',
                ],
            ],
            'components' => [
                'title' => 'Komponen',
            ],
            'work-instruction' => [
                'title'   => 'Instruksi Kerja',
                'entries' => [
                    'operation' => 'Operasi',
                    'worksheet' => 'Lembar Kerja',
                ],
            ],
            'blocked-by' => [
                'title'   => 'Diblokir Oleh',
                'columns' => [
                    'work-order'  => 'Work Order',
                    'work-center' => 'Work Center',
                    'status'      => 'Status',
                ],
            ],
        ],
    ],

    'pages' => [
        'list' => [
            'header-actions' => [
                'create' => [
                    'label' => 'Work Order Baru',
                ],
            ],
        ],
    ],
];
