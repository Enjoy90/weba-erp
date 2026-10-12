<?php

return [
    'title' => 'Batal',
    'modal' => [
        'heading'     => 'Batalkan Penawaran',
        'description' => 'Apakah Anda yakin ingin membatalkan penawaran ini?',
    ],

    'footer-actions' => [
        'send-and-cancel' => [
            'title' => 'Kirim & Batalkan',

            'notification' => [
                'cancelled' => [
                    'title' => 'Penawaran dibatalkan',
                    'body'  => 'Penawaran telah dibatalkan dan email telah berhasil dikirim.',
                ],
            ],
        ],

        'cancel' => [
            'title' => 'Batalkan',

            'notification' => [
                'cancelled' => [
                    'title' => 'Penawaran dibatalkan',
                    'body'  => 'Penawaran telah berhasil dibatalkan.',
                ],
            ],
        ],

        'close' => [
            'title' => 'Tutup',
        ],
    ],

    'form' => [
        'fields' => [
            'partner'             => 'Mitra',
            'subject'             => 'Subjek',
            'subject-placeholder' => 'Subjek',
            'subject-default'     => 'Penawaran :name telah dibatalkan untuk Pesanan Penjualan #:id',
            'description'         => 'Deskripsi',
            'description-default' => 'Yth. <b>:partner_name</b>, <br/><br/>Kami ingin memberitahukan bahwa Pesanan Penjualan Anda <b>:name</b> telah dibatalkan. Dengan demikian, tidak ada biaya lebih lanjut yang dikenakan untuk pesanan ini. Jika diperlukan pengembalian dana, kami akan memprosesnya sesegera mungkin.<br/><br/>Jika Anda memiliki pertanyaan atau memerlukan bantuan lebih lanjut, jangan ragu untuk menghubungi kami.',
        ],
    ],
];
