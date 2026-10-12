<?php

return [
    'title' => 'Kelola Operasi',

    'form' => [
        'enable-work-orders' => [
            'label'       => 'Work Order',
            'helper-text' => 'Jalankan operasi di work center yang ditentukan.',
            'link-text'   => 'Konfigurasi work center',
        ],

        'enable-work-order-dependencies' => [
            'label'       => 'Ketergantungan Work Order',
            'helper-text' => 'Atur urutan pemrosesan work order. Aktifkan fitur ini dari tab Lain-lain pada setiap BoM.',
        ],

        'enable-byproducts' => [
            'label'       => 'Produk Sampingan',
            'helper-text' => 'Hasilkan produk sampingan selama produksi (A + B → C + D).',
        ],
    ],
];
