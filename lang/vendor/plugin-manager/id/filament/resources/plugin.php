<?php

return [

    'title' => 'Plugin',

    'table' => [
        'version'             => 'Versi',
        'dependencies'        => 'Dependensi',
        'dependencies_suffix' => ' Dependensi',
    ],

    'status' => [
        'installed'     => 'Terpasang',
        'not_installed' => 'Belum Terpasang',
    ],

    'filters' => [
        'installation_status' => 'Status Pemasangan',
        'all_plugins'         => 'Semua Plugin',
        'installed'           => 'Terpasang',
        'not_installed'       => 'Belum Terpasang',
        'active_status'       => 'Status Aktif',
        'author'              => 'Pembuat',
        'webkul'              => 'Webkul',
        'third_party'         => 'Pihak Ketiga',
    ],

    'actions' => [
        'install' => [
            'title'       => 'Pasang',
            'heading'     => 'Pasang Plugin :name',
            'description' => 'Apakah Anda yakin ingin memasang plugin \':name\'? Proses ini akan menjalankan migrasi dan seeder.',
            'submit'      => 'Pasang Plugin',
        ],
        'uninstall' => [
            'title'      => 'Copot',
            'heading'    => 'Copot Plugin',
            'submit'     => 'Copot Plugin',
        ],
    ],

    'notifications' => [
        'installed' => [
            'title' => 'Plugin Berhasil Dipasang',
            'body'  => 'Plugin \':name\' telah dipasang.',
        ],
        'installed-failed' => [
            'title' => 'Pemasangan Gagal',
        ],
        'uninstalled' => [
            'title' => 'Plugin Berhasil Dicopot',
            'body'  => 'Plugin \':name\' telah dicopot.',
        ],
        'uninstalled-failed' => [
            'title' => 'Pencopotan Gagal',
        ],
        'uninstalled-blocked' => [
            'title' => 'Plugin Tidak Dapat Dicopot',
            'body'  => 'Plugin \':name\' memiliki plugin dependen terpasang yang harus dicopot terlebih dahulu: :dependents.',
        ],
    ],

    'infolist' => [
        'section'  => [
            'plugin'       => ' Informasi Plugin',
            'dependencies' => 'Dependensi',
        ],
        'name'         => 'Nama Plugin',
        'author'       => 'Pembuat',
        'version'      => 'Versi',
        'dependencies' => 'Plugin yang Dibutuhkan',
        'dependents'   => 'Plugin yang Bergantung pada Plugin Ini',
        'is_installed' => 'Status Pemasangan',
        'license'      => 'Lisensi',
        'summary'      => 'Deskripsi',

        'dependencies-repeater' => [
            'title'        => 'Plugin yang Dibutuhkan',
            'name'         => 'Nama Plugin',
            'is_installed' => 'Terpasang',
            'placeholder'  => 'Tidak ada dependensi yang dibutuhkan',
        ],

        'dependents-repeater' => [
            'title'        => 'Plugin yang Bergantung pada Plugin Ini',
            'name'         => 'Nama Plugin',
            'is_installed' => 'Terpasang',
            'placeholder'  => 'Tidak ada plugin dependen',
        ],

    ],

    'names' => [
        'accounting'     => 'Akuntansi',
        'accounts'       => 'Akun',
        'analytics'      => 'Analitik',
        'barcode'        => 'Barcode',
        'blogs'          => 'Blog',
        'chatter'        => 'Chatter',
        'contacts'       => 'Kontak',
        'employees'      => 'Karyawan',
        'fields'         => 'Kolom Kustom',
        'full-calendar'  => 'Kalender',
        'inventories'    => 'Inventaris',
        'invoices'       => 'Faktur',
        'maintenance'    => 'Pemeliharaan',
        'manufacturing'  => 'Manufaktur',
        'partners'       => 'Mitra',
        'payments'       => 'Pembayaran',
        'plugin-manager' => 'Manajer Plugin',
        'products'       => 'Produk',
        'projects'       => 'Proyek',
        'purchases'      => 'Pembelian',
        'recruitments'   => 'Rekrutmen',
        'sales'          => 'Penjualan',
        'security'       => 'Keamanan',
        'support'        => 'Dukungan',
        'table-views'    => 'Tampilan Tabel',
        'time-off'       => 'Cuti',
        'timesheets'     => 'Timesheet',
        'website'        => 'Situs Web',
    ],

    'summaries' => [
        'accounting'     => 'Kelola bagan akun, jurnal, dan entri keuangan',
        'accounts'       => 'Pengelolaan akun inti dan pengaturan keuangan',
        'analytics'      => 'Laporan dan dasbor untuk wawasan bisnis',
        'barcode'        => 'Aplikasi operasi barcode untuk inventaris dan manufaktur',
        'blogs'          => 'Kelola blog',
        'chatter'        => 'Log aktivitas, pesan, dan tindak lanjut pada data',
        'contacts'       => 'Pengelolaan kontak pelanggan dan pemasok',
        'employees'      => 'Pengelolaan karyawan',
        'fields'         => 'Tambahkan kolom kustom ke resource',
        'full-calendar'  => 'Tampilan kalender dan penjadwalan acara',
        'inventories'    => 'Pengelolaan inventaris dan gudang',
        'invoices'       => 'Pembuatan dan pengelolaan faktur',
        'maintenance'    => 'Pengelolaan pemeliharaan',
        'manufacturing'  => 'Pengelolaan manufaktur dan produksi',
        'partners'       => 'Kelola mitra bisnis',
        'payments'       => 'Kelola pembayaran dan transaksi',
        'plugin-manager' => 'Manajer Plugin untuk Aureus ERP',
        'products'       => 'Katalog produk dan pengelolaan varian',
        'projects'       => 'Perencanaan dan pengelolaan proyek',
        'purchases'      => 'Pengadaan dan pengelolaan pesanan pembelian',
        'recruitments'   => 'Pelacakan pelamar dan perekrutan',
        'sales'          => 'Pengelolaan pipeline penjualan dan peluang',
        'security'       => 'Peran, izin, dan kontrol akses',
        'support'        => 'Dukungan pelanggan dan tiket',
        'table-views'    => 'Tampilan tabel tersimpan yang dapat disesuaikan',
        'time-off'       => 'Pengelolaan dan pelacakan cuti',
        'timesheets'     => 'Pelacakan jam kerja karyawan',
        'website'        => 'Situs web untuk pelanggan',
    ],

];
