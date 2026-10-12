<?php

return [
    'title'        => 'Kirim lewat Email',
    'resend-title' => 'Kirim Ulang lewat Email',
    'quotation'    => 'penawaran',
    'quotations'   => 'penawaran',

    'modal' => [
        'heading' => 'Kirim Penawaran lewat Email',
    ],

    'form' => [
        'fields' => [
            'partners'    => 'Mitra',
            'subject'     => 'Subjek',
            'description' => 'Deskripsi',
            'attachment'  => 'Lampiran',
        ],
    ],

    'actions' => [
        'notification' => [
            'email' => [
                'no_recipients' => [
                    'title' => 'Belum Ada Penerima yang Dipilih',
                    'body'  => 'Pilih minimal satu mitra untuk menerima penawaran.',
                ],

                'all_success' => [
                    'title' => 'Penawaran Terkirim!',
                    'body'  => ':plural Anda berhasil dikirim ke: :recipients',
                ],

                'all_failed' => [
                    'title' => 'Penawaran Gagal Dikirim',
                    'body'  => 'Terjadi kendala saat mengirim penawaran Anda: :failures',
                ],

                'partial_success' => [
                    'title'       => 'Sebagian Penawaran Terkirim',
                    'sent_part'   => 'Berhasil dikirim ke: :recipients',
                    'failed_part' => 'Gagal dikirim ke: :failures',
                ],

                'failure_item' => ':partner (:reason)',
            ],
        ],
    ],

];
