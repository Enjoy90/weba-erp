<?php

return [
    'columns' => [
        'number'          => 'Nomor',
        'state'           => 'Status',
        'customer'        => 'Pelanggan',
        'bill-date'       => 'Tanggal Tagihan',
        'due-date'        => 'Tanggal Jatuh Tempo',
        'tax-excluded'    => 'Tanpa Pajak',
        'tax'             => 'Pajak',
        'total'           => 'Total',
        'amount-due'      => 'Jumlah Terutang',
        'payment-state'   => 'Status Pembayaran',
        'checked'         => 'Diperiksa',
        'accounting-date' => 'Tanggal Akuntansi',
        'source-document' => 'Dokumen Sumber',
        'reference'       => 'Referensi',
        'sales-person'    => 'Tenaga Penjual',
        'bill-currency'   => 'Mata Uang Tagihan',
    ],

    'values' => [
        'yes' => 'Ya',
        'no'  => 'Tidak',
    ],

    'notification' => [
        'completed' => 'Ekspor tagihan Anda telah selesai dan :count baris berhasil diekspor.',
        'failed'    => ':count baris gagal diekspor.',
    ],
];
