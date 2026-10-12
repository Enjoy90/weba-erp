<?php

return [
    'manufacturing-manager' => [
        'unplan-order' => [
            'work-orders-already-done'    => "Beberapa work order sudah selesai, sehingga rencana order produksi ini tidak dapat dibatalkan.\n\nSayang sekali jika semua progres itu terbuang, bukan?",
            'work-orders-already-started' => "Beberapa work order sudah dimulai, sehingga rencana order produksi ini tidak dapat dibatalkan.\n\nSayang sekali jika semua progres itu terbuang, bukan?",
        ],
    ],

    'work-center-productivity-log' => [
        'time-tracking'                    => 'Pelacakan Waktu: :name',
        'no-performance-productivity-loss' => 'Anda perlu menentukan minimal satu kehilangan produktivitas yang tidak diarsipkan dalam kategori \'Performa\'. Buat melalui pengaturan konfigurasi.',
    ],

    'work-center' => [
        'already-unblocked' => 'Blokir sudah dibuka sebelumnya.',
    ],

    'work-order' => [
        'unblock-work-center'        => 'Buka blokir work center untuk memulai work order.',
        'already-done-or-cancelled'  => 'Anda tidak dapat memulai work order yang sudah selesai atau dibatalkan',
        'no-calendar-on-work-center' => 'Tidak ada kalender yang ditetapkan pada work center :name.',
        'no-productivity-loss'       => 'Anda perlu menentukan minimal satu kehilangan produktivitas dalam kategori \'Produktivitas\'. Buat melalui pengaturan konfigurasi.',
        'no-performance-loss'        => 'Anda perlu menentukan minimal satu kehilangan produktivitas dalam kategori \'Performa\'. Buat melalui pengaturan konfigurasi.',
        'impossible-to-plan'         => 'Work order tidak dapat direncanakan. Periksa ketersediaan work center.',
    ],

    'order' => [
        'product-in-byproducts'                    => 'Anda tidak dapat menjadikan :product sebagai produk jadi sekaligus produk sampingan',
        'missing-lot-serial-number'                => 'Anda perlu mengisi Lot/Nomor Seri untuk produk dan "memakainya": :missing_products',
        'serial-number-already-produced'           => 'Nomor seri untuk produk :product ini sudah pernah diproduksi',
        'byproduct-serial-number-already-produced' => 'Nomor seri :number yang digunakan untuk produk sampingan :product sudah pernah diproduksi',
        'component-serial-number-consumed'         => 'Nomor seri :number yang digunakan untuk komponen :component sudah pernah dipakai',
        'components-availability'                  => [
            'available'     => 'Tersedia',
            'not-available' => 'Tidak Tersedia',
            'expected'      => 'Diperkirakan :date',
        ],
    ],
];
