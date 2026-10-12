<?php

return [

    'uninstall' => [
        'title'   => 'Konfirmasi Pencopotan',
        'message' => 'Apakah Anda yakin ingin mencopot plugin :name?',
        'warning' => '⚠️ Tindakan ini tidak dapat dibatalkan dan akan menghapus data secara permanen.',
    ],

    'dependents' => [
        'title'         => 'Plugin Dependen',
        'description'   => 'Plugin berikut bergantung pada plugin ini. Plugin dependen yang terpasang harus dicopot terlebih dahulu.',
        'installed'     => 'Terpasang',
        'not_installed' => 'Belum Terpasang',
    ],

    'dependency_warning' => [
        'title'   => 'Tindakan Diperlukan',
        'message' => '⚠️ Copot terlebih dahulu plugin dependen berikut sebelum mencopot :name.',
    ],

    'data_impact' => [
        'title'       => 'Dampak Data',
        'description' => 'Tabel database berikut berisi data yang akan dihapus secara permanen.',
        'records'     => ':count data',
    ],

];
