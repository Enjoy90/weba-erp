<?php

return [
    'navigation' => [
        'title' => 'Laporan',
        'group' => 'Inventaris',
    ],

    'moves' => [
        'navigation' => [
            'title' => 'Riwayat Pergerakan Stok',
        ],

        'filters' => [
            'product-category'     => 'Kategori Produk',
            'source-location'      => 'Lokasi Sumber',
            'destination-location' => 'Lokasi Tujuan',
            'package'              => 'Paket',
            'lot'                  => 'Lot/Nomor Seri',
            'package-type'         => 'Jenis Paket',
        ],

        'groups' => [
            'product'   => 'Produk',
            'status'    => 'Status',
            'date'      => 'Tanggal',
            'operation' => 'Operasi',
            'location'  => 'Lokasi',
            'category'  => 'Kategori',
        ],
    ],

    'quantities' => [
        'navigation' => [
            'title' => 'Lokasi',
        ],

        'filters' => [
            'warehouse'        => 'Gudang',
            'location'         => 'Lokasi',
            'product-category' => 'Kategori Produk',
            'storage-category' => 'Kategori Penyimpanan',
            'package'          => 'Paket',
            'lot'              => 'Lot/Nomor Seri',
            'package-type'     => 'Jenis Paket',
        ],

        'groups' => [
            'product'          => 'Produk',
            'product-category' => 'Kategori Produk',
            'location'         => 'Lokasi',
            'storage-category' => 'Kategori Penyimpanan',
            'lot'              => 'Lot/Nomor Seri',
            'package'          => 'Paket',
            'company'          => 'Perusahaan',
        ],
    ],
];
