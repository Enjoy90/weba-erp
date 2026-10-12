<?php

return [
    'navigation' => [
        'title' => 'Order Produksi',
        'group' => 'Operasi',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title'  => 'Umum',
                'fields' => [
                    'product'                => 'Produk',
                    'quantity'               => 'Jumlah',
                    'uom'                    => 'Satuan',
                    'bill-of-material'       => 'Bill of Materials',
                    'scheduled-date'         => 'Tanggal Terjadwal',
                    'scheduled-end'          => 'Jadwal Selesai',
                    'responsible'            => 'Penanggung Jawab',
                    'to-produce'             => 'Akan Diproduksi',
                    'to-produce-placeholder' => 'Pratinjau gambar',
                    'uom-placeholder'        => 'Satuan',
                ],
            ],
        ],
        'tabs' => [
            'components' => [
                'title'        => 'Komponen',
                'add-action'   => 'Tambah baris',
                'process-note' => 'Komponen akan dibuat seiring proses manufaktur disusun.',
                'columns'      => [
                    'component'          => 'Produk',
                    'from'               => 'Dari',
                    'to-consume'         => 'Akan Dipakai',
                    'to-consume-tooltip' => 'Jumlah tersedia tidak mencukupi',
                    'quantity'           => 'Jumlah',
                    'uom'                => 'Satuan',
                    'forecast'           => 'Prakiraan',
                ],
            ],
            'work-orders' => [
                'title'        => 'Work Order',
                'add-action'   => 'Tambah baris',
                'process-note' => 'Work order akan dibuat setelah proses manufaktur dikonfigurasi.',
                'columns'      => [
                    'operation'          => 'Operasi',
                    'work-center'        => 'Work Center',
                    'product'            => 'Produk',
                    'quantity-remaining' => 'Sisa Jumlah',
                    'quantity-produced'  => 'Jumlah Diproduksi',
                    'start'              => 'Mulai',
                    'end'                => 'Selesai',
                    'expected-duration'  => 'Durasi Perkiraan',
                    'real-duration'      => 'Durasi Aktual',
                    'status'             => 'Status',
                    'lot-serial'         => 'Lot/Nomor Seri',
                ],
                'actions'      => [
                    'open-work-order' => [
                        'tooltip' => 'Buka work order',
                    ],

                    'done' => [
                        'label' => 'Selesai',
                    ],
                ],
            ],
            'by-products' => [
                'title'        => 'Produk Sampingan',
                'process-note' => 'Produk sampingan akan dibuat seiring proses manufaktur disusun.',
                'columns'      => [
                    'product'    => 'Produk',
                    'to'         => 'Ke',
                    'to-produce' => 'Akan Diproduksi',
                    'uom'        => 'Satuan',
                ],
            ],
            'miscellaneous' => [
                'title'  => 'Lain-lain',
                'fields' => [
                    'operation-type'             => 'Jenis Operasi',
                    'source'                     => 'Sumber',
                    'finished-products-location' => 'Lokasi Produk Jadi',
                    'company'                    => 'Perusahaan',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'reference'              => 'Referensi',
            'start'                  => 'Mulai',
            'end'                    => 'Selesai',
            'deadline'               => 'Tenggat',
            'product'                => 'Produk',
            'lot-serial-number'      => 'Lot/Nomor Seri',
            'bill-of-material'       => 'Bill of Materials',
            'source'                 => 'Sumber',
            'responsible'            => 'Penanggung Jawab',
            'mo-readiness'           => 'Kesiapan MO',
            'component-status'       => 'Status Komponen',
            'quantity'               => 'Jumlah',
            'uom'                    => 'Satuan',
            'consumption-efficiency' => 'Efisiensi Pemakaian',
            'expected-duration'      => 'Durasi Perkiraan',
            'real-duration'          => 'Durasi Aktual',
            'company'                => 'Perusahaan',
            'state'                  => 'Status',
        ],
        'groups' => [
            'state'            => 'Status',
            'product'          => 'Produk',
            'bill-of-material' => 'Bill of Materials',
            'responsible'      => 'Penanggung Jawab',
            'deadline'         => 'Tenggat',
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title'   => 'Umum',
                'entries' => [
                    'product'                  => 'Produk',
                    'scheduled-date'           => 'Tanggal Terjadwal',
                    'responsible'              => 'Penanggung Jawab',
                    'quantity'                 => 'Jumlah',
                    'uom'                      => 'Satuan',
                    'bill-of-material'         => 'Bill of Materials',
                    'operation-type'           => 'Jenis Operasi',
                    'consumption-efficiency'   => 'Efisiensi Pemakaian',
                ],
            ],
        ],
        'tabs' => [
            'components' => [
                'title'        => 'Komponen',
                'process-note' => 'Komponen akan tersedia setelah proses manufaktur dikonfigurasi.',
                'columns'      => [
                    'component' => 'Komponen',
                    'quantity'  => 'Jumlah',
                    'uom'       => 'Satuan',
                ],
            ],
            'work-orders' => [
                'title'        => 'Work Order',
                'process-note' => 'Work order akan tersedia setelah proses manufaktur dikonfigurasi.',
                'columns'      => [
                    'operation'          => 'Operasi',
                    'work-center'        => 'Work Center',
                    'product'            => 'Produk',
                    'quantity-remaining' => 'Sisa Jumlah',
                    'expected-duration'  => 'Durasi Perkiraan',
                    'real-duration'      => 'Durasi Aktual',
                    'lot-serial'         => 'Lot/Nomor Seri',
                    'start'              => 'Mulai',
                    'end'                => 'Selesai',
                ],
            ],
            'by-products' => [
                'title'        => 'Produk Sampingan',
                'process-note' => 'Produk sampingan akan tersedia setelah proses manufaktur dikonfigurasi.',
                'columns'      => [
                    'product'    => 'Produk',
                    'to'         => 'Ke',
                    'to-produce' => 'Akan Diproduksi',
                    'uom'        => 'Satuan',
                ],
            ],
            'miscellaneous' => [
                'title'   => 'Lain-lain',
                'entries' => [
                    'operation-type'             => 'Jenis Operasi',
                    'source'                     => 'Sumber',
                    'finished-products-location' => 'Lokasi Produk Jadi',
                    'company'                    => 'Perusahaan',
                ],
            ],
        ],
    ],

    'pages' => [
        'shared' => [
            'header-actions' => [
                'confirm' => [
                    'label'        => 'Konfirmasi',
                    'notification' => [
                        'title' => 'Order produksi berhasil dikonfirmasi',
                    ],
                ],

                'cancel' => [
                    'label'        => 'Batal',
                    'notification' => [
                        'title' => 'Order produksi berhasil dibatalkan',
                    ],
                ],
            ],
        ],
    ],
];
