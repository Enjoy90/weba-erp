<?php

return [
    'navigation' => [
        'title' => 'Produk',
        'group' => 'Inventaris',
    ],

    'global-search' => [
        'partner' => 'Mitra',
        'origin'  => 'Asal',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'title' => 'Umum',

                'fields' => [
                    'receive-from'         => 'Terima Dari',
                    'contact'              => 'Kontak',
                    'delivery-address'     => 'Alamat Pengiriman',
                    'operation-type'       => 'Jenis Operasi',
                    'source-location'      => 'Lokasi Sumber',
                    'destination-location' => 'Lokasi Tujuan',
                ],
            ],

            'additional-fields' => [
                'title' => 'Informasi Tambahan',
            ],
        ],

        'tabs' => [
            'operations' => [
                'title' => 'Operasi',

                'columns' => [
                    'product'                    => 'Produk',
                    'final-location'             => 'Lokasi Akhir',
                    'description'                => 'Deskripsi',
                    'scheduled-at'               => 'Dijadwalkan Pada',
                    'deadline'                   => 'Tenggat',
                    'packaging'                  => 'Kemasan',
                    'demand'                     => 'Permintaan',
                    'quantity'                   => 'Jumlah',
                    'insufficient-stock-tooltip' => 'Jumlah yang tersedia tidak mencukupi',
                    'unit'                       => 'Satuan',
                    'picked'                     => 'Diambil',
                ],

                'actions' => [
                    'open-product' => [
                        'tooltip' => 'Buka produk',
                    ],
                ],

                'fields' => [
                    'product'        => 'Produk',
                    'final-location' => 'Lokasi Akhir',
                    'description'    => 'Deskripsi',
                    'scheduled-at'   => 'Dijadwalkan Pada',
                    'deadline'       => 'Tenggat',
                    'packaging'      => 'Kemasan',
                    'demand'         => 'Permintaan',
                    'quantity'       => 'Jumlah',
                    'unit'           => 'Satuan',
                    'picked'         => 'Diambil',

                    'lines' => [
                        'modal-heading'             => 'Kelola Pergerakan Stok',
                        'modal-submit-action-label' => 'Simpan',
                        'add-line'                  => 'Tambah Baris',

                        'actions' => [
                            'generate' => 'Buat Nomor Seri/Lot',
                            'import'   => 'Impor Nomor Seri/Lot',
                        ],

                        'fields' => [
                            'lot'                => 'Lot/Nomor Seri',
                            'pick-from'          => 'Ambil Dari',
                            'location'           => 'Simpan Ke',
                            'package'            => 'Paket Tujuan',
                            'quantity'           => 'Jumlah',
                            'uom'                => 'Satuan Ukur',
                            'first-lot'          => 'Nomor Lot Pertama',
                            'quantity-per-lot'   => 'Jumlah per Lot',
                            'quantity-received'  => 'Jumlah Diterima',
                            'keep-current-lines' => 'Pertahankan baris saat ini',
                            'serials'            => 'Lot/Nomor Seri',
                            'serials-helper'     => 'Satu lot/nomor seri per baris.',
                        ],
                    ],
                ],
            ],

            'additional' => [
                'title' => 'Tambahan',

                'fields' => [
                    'responsible'                  => 'Penanggung Jawab',
                    'shipping-policy'              => 'Kebijakan Pengiriman',
                    'shipping-policy-hint-tooltip' => 'Menentukan apakah barang dikirim sebagian atau sekaligus.',
                    'scheduled-at'                 => 'Dijadwalkan Pada',
                    'scheduled-at-hint-tooltip'    => 'Waktu terjadwal untuk memproses bagian pertama pengiriman. Mengisi nilai di sini secara manual akan menjadikannya tanggal yang diharapkan untuk semua pergerakan stok.',
                    'source-document'              => 'Dokumen Sumber',
                    'source-document-hint-tooltip' => 'Referensi dokumen',
                ],
            ],

            'note' => [
                'title' => 'Catatan',

                'fields' => [

                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'favorite'        => 'Favorit',
            'reference'       => 'Referensi',
            'from'            => 'Dari',
            'to'              => 'Ke',
            'contact'         => 'Kontak',
            'responsible'     => 'Penanggung Jawab',
            'scheduled-at'    => 'Dijadwalkan Pada',
            'deadline'        => 'Tenggat',
            'closed-at'       => 'Ditutup Pada',
            'source-document' => 'Dokumen Sumber',
            'operation-type'  => 'Jenis Operasi',
            'company'         => 'Perusahaan',
            'state'           => 'Status',
            'deleted-at'      => 'Dihapus Pada',
            'created-at'      => 'Dibuat Pada',
            'updated-at'      => 'Diperbarui Pada',
        ],

        'groups' => [
            'state'           => 'Status',
            'source-document' => 'Dokumen Sumber',
            'operation-type'  => 'Jenis Operasi',
            'scheduled-at'    => 'Dijadwalkan Pada',
            'created-at'      => 'Dibuat Pada',
        ],

        'filters' => [
            'operation-type'       => 'Jenis Operasi',
            'name'                 => 'Nama',
            'state'                => 'Status',
            'partner'              => 'Mitra',
            'responsible'          => 'Penanggung Jawab',
            'owner'                => 'Pemilik',
            'source-location'      => 'Lokasi Sumber',
            'destination-location' => 'Lokasi Tujuan',
            'deadline'             => 'Tenggat',
            'scheduled-at'         => 'Dijadwalkan Pada',
            'closed-at'            => 'Ditutup Pada',
            'created-at'           => 'Dibuat Pada',
            'updated-at'           => 'Diperbarui Pada',
            'company'              => 'Perusahaan',
            'creator'              => 'Pembuat',
        ],
    ],

    'infolist' => [
        'sections' => [
            'general' => [
                'title'   => 'Informasi Umum',
                'entries' => [
                    'contact'              => 'Kontak',
                    'operation-type'       => 'Jenis Operasi',
                    'source-location'      => 'Lokasi Sumber',
                    'destination-location' => 'Lokasi Tujuan',
                ],
            ],
        ],

        'tabs' => [
            'operations' => [
                'title'   => 'Operasi',
                'entries' => [
                    'product'        => 'Produk',
                    'final-location' => 'Lokasi Akhir',
                    'description'    => 'Deskripsi',
                    'scheduled-at'   => 'Dijadwalkan Pada',
                    'deadline'       => 'Tenggat',
                    'packaging'      => 'Kemasan',
                    'demand'         => 'Permintaan',
                    'quantity'       => 'Jumlah',
                    'unit'           => 'Satuan',
                    'picked'         => 'Diambil',
                ],
            ],
            'additional' => [
                'title'   => 'Informasi Tambahan',
                'entries' => [
                    'responsible'     => 'Penanggung Jawab',
                    'shipping-policy' => 'Kebijakan Pengiriman',
                    'scheduled-at'    => 'Dijadwalkan Pada',
                    'source-document' => 'Dokumen Sumber',
                ],
            ],
            'note' => [
                'title' => 'Catatan',
            ],
        ],
    ],

    'tabs' => [
        'todo'        => 'Akan Dikerjakan',
        'my'          => 'Transfer Saya',
        'starred'     => 'Berbintang',
        'draft'       => 'Draf',
        'waiting'     => 'Menunggu',
        'ready'       => 'Siap',
        'late'        => 'Terlambat',
        'done'        => 'Selesai',
        'canceled'    => 'Dibatalkan',
        'back-orders' => 'Backorder',
    ],

    'notifications' => [
        'uom-precision-warning' => [
            'title' => 'Peringatan Presisi Satuan Ukur',
            'body'  => 'Anda menggunakan satuan ukur yang lebih kecil daripada satuan yang dipakai untuk menyimpan stok produk ini. Hal ini dapat menimbulkan masalah pembulatan pada jumlah yang dicadangkan. Pertimbangkan untuk memakai satuan ukur terkecil untuk penilaian stok, atau kurangi presisi pembulatan satuan dasar Anda.',
        ],
    ],
];
