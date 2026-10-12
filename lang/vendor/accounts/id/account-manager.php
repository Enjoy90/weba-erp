<?php

return [
    'post-action-validate' => [
        'customer-required'    => 'Masukkan Pelanggan yang valid untuk melanjutkan validasi Faktur Pelanggan.',
        'vendor-required'      => 'Masukkan Pemasok yang valid untuk melanjutkan validasi Tagihan Pemasok.',
        'bank-archived'        => 'Rekening Bank Mitra yang dipilih pada faktur ini sudah diarsipkan.',
        'negative-amount'      => 'Faktur tidak dapat dikonfirmasi dengan jumlah total negatif.',
        'date-required'        => 'Masukkan Tanggal Tagihan/Pengembalian Dana yang valid untuk melanjutkan validasi Tagihan/Pengembalian Dana.',
        'currency-archived'    => 'Anda tidak dapat mengonfirmasi faktur dengan mata uang yang sudah diarsipkan.',
        'account-deprecated'   => 'Satu atau beberapa baris pada faktur ini menggunakan akun yang sudah tidak berlaku.',
        'lines-required'       => 'Tambahkan minimal satu baris pada faktur.',
        'draft-state-required' => 'Hanya faktur berstatus draf yang dapat dikonfirmasi.',
        'journal-archived'     => 'Anda tidak dapat mengonfirmasi faktur dengan jurnal yang sudah diarsipkan.',
    ],

    'documents' => [
        'titles' => [
            'invoice'     => 'Faktur ID #:name',
            'bill'        => 'Tagihan Pemasok ID #:name',
            'refund'      => 'Pengembalian Dana ID #:name',
            'credit-note' => 'Nota Kredit ID #:name',
        ],

        'labels' => [
            'invoice-date'          => 'Tanggal Faktur',
            'bill-date'             => 'Tanggal',
            'refund-date'           => 'Tanggal Pengembalian Dana',
            'credit-note-date'      => 'Tanggal Nota Kredit',
            'source'                => 'Sumber',
            'due-date'              => 'Tanggal Jatuh Tempo',
            'product'               => 'Produk',
            'quantity'              => 'Jumlah',
            'unit'                  => 'Satuan',
            'unit-price'            => 'Harga Satuan',
            'subtotal'              => 'Subtotal',
            'tax'                   => 'Pajak',
            'discount'              => 'Diskon',
            'discount-percentage'   => 'Disk. %',
            'taxes'                 => 'Pajak',
            'amount'                => 'Nilai',
            'grand-total'           => 'Total Keseluruhan',
            'payment-information'   => 'Informasi Pembayaran',
            'payment-communication' => 'Keterangan Pembayaran',
            'account-details'       => 'ke detail rekening berikut:',
        ],
    ],
];
