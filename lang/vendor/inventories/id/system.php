<?php

return [
    'inventory-manager' => [
        'check-availability' => [
            'no-moves' => 'Tidak ada yang perlu diperiksa ketersediaannya.',
        ],

        'cancel-move' => [
            'already-done' => 'Anda tidak dapat membatalkan pergerakan stok yang sudah berstatus \'Selesai\'. Buat retur untuk membalikkan pergerakan yang telah terjadi.',
        ],

        'unreserve-move' => [
            'already-done' => 'Anda tidak dapat membatalkan pencadangan pergerakan stok yang sudah berstatus \'Selesai\'.',
        ],

        'validate' => [
            'quantity-rounding-mismatch' => 'Jumlah selesai untuk produk ":product" tidak sesuai dengan presisi pembulatan yang ditetapkan pada satuan ukur ":unit". Ubah jumlah selesai atau presisi pembulatan satuan ukur Anda.',
            'no-negative-quantities'     => 'Jumlah negatif tidak diizinkan',
            'missing-lot-serial-number'  => "Anda perlu mengisi Lot/Nomor Seri untuk produk:\n:products",
        ],

        'run-procurement' => [
            'no-rule-found'      => "Tidak ditemukan aturan untuk pengisian ulang \":product\" di \":location\".\nPeriksa konfigurasi rute pada produk.",
            'no-source-location' => 'Lokasi sumber belum ditetapkan pada aturan stok: :name!',
            'no-vendor-price'    => 'Tidak ada harga pemasok yang sesuai untuk membuat pesanan pembelian bagi produk :product (pemasok belum ditetapkan, jumlah minimum belum tercapai, tanggal tidak valid, ...). Buka formulir produk dan lengkapi daftar pemasok.',
        ],

        'return' => [
            'origin' => 'Retur dari :operation_name',
        ],
    ],

    'move-line' => [
        'negative-quantity-not-allowed' => 'Mencadangkan jumlah negatif tidak diizinkan.',
    ],

    'product-quantity' => [
        'quantity-not-set'                 => 'Jumlah atau Jumlah Dipesan harus diisi.',
        'removal-strategy-not-implemented' => 'Strategi pengeluaran :strategy belum diterapkan.',
        'unreserve-more-than-stock'        => 'Tidak dapat membatalkan pencadangan produk :name melebihi stok yang Anda miliki.',
    ],

    'product' => [
        'endless-loop-rule' => 'Konfigurasi aturan tidak valid, aturan berikut menyebabkan perulangan tanpa akhir: :name',
    ],

    'move' => [
        'quantity-rounding-mismatch' => 'Jumlah selesai untuk produk :product tidak sesuai dengan presisi pembulatan yang ditetapkan pada satuan ukur :unit. Ubah jumlah selesai atau presisi pembulatan satuan ukur Anda.',
        'split-done-or-cancel'       => 'Anda tidak dapat memecah pergerakan stok yang sudah berstatus \'Selesai\' atau \'Dibatalkan\'.',
        'split-draft'                => 'Anda tidak dapat memecah pergerakan berstatus draf. Pergerakan harus dikonfirmasi terlebih dahulu.',
        'serial-already-assigned'    => 'Nomor seri sudah ditetapkan untuk Produk: :product, Nomor Seri: :serial_number',

        'cross-company' => [
            'title' => 'Transfer antarperusahaan tidak diizinkan',
            'body'  => 'Transfer tidak dapat memindahkan stok secara langsung antarlokasi milik perusahaan yang berbeda (:source dan :destination). Transfer antarperusahaan belum didukung.',
        ],
    ],

    'rule' => [
        'delay-on'     => 'Penundaan pada :name',
        'days'         => '+ :days hari',
        'time-horizon' => 'Rentang Waktu',
    ],
];
