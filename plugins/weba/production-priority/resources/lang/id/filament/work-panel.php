<?php

return [
    'navigation' => [
        'title' => 'Panel Kerja Harian',
    ],

    'greeting' => [
        'morning'   => 'Selamat pagi, :name',
        'afternoon' => 'Selamat siang, :name',
        'evening'   => 'Selamat sore, :name',
        'night'     => 'Selamat malam, :name',
    ],

    'summary' => ':date. Order terlambat: :late. Jatuh tempo dalam :days hari: :due_soon.',

    'tasks' => [
        'heading' => 'Yang perlu dikerjakan hari ini',

        'late' => [
            'title'       => 'Tangani order terlambat',
            'description' => 'Tenggat sudah lewat. Pertimbangkan lembur atau kabari pelanggan.',
            'empty'       => 'Tidak ada order terlambat.',
            'button'      => 'Lihat order terlambat',
        ],

        'plan' => [
            'title'           => 'Terapkan prioritas hari ini',
            'none'            => 'Belum ada hasil SAW. Jalankan SAW untuk mendapat urutan prioritas.',
            'pending'         => 'Hasil SAW ":name" siap. Jadikan :count order teratas sebagai prioritas Urgent.',
            'applied'         => 'Diterapkan oleh :user pada :date untuk :count order teratas.',
            'applied-unknown' => 'Diterapkan pada :date untuk :count order teratas.',
            'apply'           => 'Tinjau dan terapkan',
            'run'             => 'Jalankan SAW',
        ],

        'material' => [
            'title'       => 'Lengkapi bahan baku',
            'description' => 'Order ini belum mendapat bahan penuh.',
            'largest'     => 'Kekurangan terbesar: :product (:quantity :unit).',
            'empty'       => 'Semua bahan baku order aktif sudah tersedia.',
            'button'      => 'Buat permintaan pembelian',
        ],

        'more' => 'dan :count lainnya',
    ],

    'stats' => [
        'heading' => 'Angka hari ini',

        'active' => [
            'label' => 'Order aktif',
            'unit'  => 'order',
            'help'  => 'Order berstatus dikonfirmasi, dikerjakan, atau siap ditutup.',
        ],
        'due-soon' => [
            'label' => 'Jatuh tempo :days hari',
            'unit'  => 'order',
            'help'  => 'Tenggat dalam :days hari ke depan, tidak termasuk yang sudah terlambat.',
        ],
        'progress' => [
            'label' => 'Rata-rata progres',
            'unit'  => '',
            'help'  => 'Rata-rata persentase pekerjaan yang selesai pada order aktif.',
        ],
        'workload' => [
            'label' => 'Sisa beban kerja',
            'unit'  => 'jam',
            'help'  => 'Total jam kerja yang belum dikerjakan di semua work center.',
        ],
        'help-button' => 'Penjelasan :label',
    ],

    'tabs' => [
        'priority'     => 'Urutan prioritas',
        'work-centers' => 'Beban work center',
        'status'       => 'Status order',
    ],

    'priority' => [
        'filter' => [
            'label'     => 'Saring order',
            'all'       => 'Semua',
            'attention' => 'Perlu perhatian',
            'progress'  => 'Sedang dikerjakan',
        ],
        'score-help' => 'Skor SAW bernilai 0 sampai 1, dihitung dari kriteria berbobot. Makin tinggi, makin perlu didahulukan.',
        'columns'    => [
            'rank'     => 'Prioritas',
            'order'    => 'Order',
            'state'    => 'Status',
            'deadline' => 'Tenggat',
            'progress' => 'Progres',
            'score'    => 'Skor',
        ],
        'open'           => 'Buka',
        'progress-label' => 'Progres order :order',
        'empty'          => 'Belum ada hasil SAW',
        'empty-text'     => 'Jalankan SAW untuk mendapat urutan prioritas.',
        'empty-filter'   => 'Tidak ada order yang cocok dengan saringan ini.',
    ],

    'work-centers' => [
        'caption'     => 'Sisa jam kerja dari order aktif, per work center',
        'hours'       => ':hours jam',
        'work-center' => 'Work center',
        'waiting'     => 'Menunggu',
        'running'     => 'Berjalan',
        'orders'      => ':count order',
        'empty'       => 'Tidak ada pekerjaan tersisa di work center mana pun.',
    ],

    'status' => [
        'caption' => 'Sebaran :count order menurut tahap siklusnya',
        'empty'   => 'Belum ada order.',
    ],

    'footer' => [
        'evaluation' => 'Evaluasi terakhir: :name, :date',
        'none'       => 'Belum ada evaluasi SAW.',
        'open'       => 'Buka halaman prioritas lengkap',
    ],
];
