<?php

return [
    'before-save' => [
        'notification' => [
            'error' => [
                'tracking-update' => [
                    'title' => 'Gagal memperbarui pelacakan',
                    'body'  => 'Anda tidak dapat mengubah pelacakan inventaris produk yang sudah pernah digunakan.',
                ],

                'reordering-rules' => [
                    'title' => 'Gagal memperbarui produk',
                    'body'  => 'Masih ada aturan pemesanan ulang yang aktif pada produk ini. Arsipkan atau hapus aturan tersebut terlebih dahulu.',
                ],

                'reserved' => [
                    'title' => 'Gagal memperbarui pelacakan',
                    'body'  => 'Anda tidak dapat mengubah pelacakan inventaris produk yang sedang dicadangkan pada pergerakan stok. Jika perlu mengubah pelacakan inventaris, batalkan dulu pencadangan pergerakan stok tersebut.',
                ],

                'qty-not-zero' => [
                    'title' => 'Gagal memperbarui pelacakan',
                    'body'  => 'Jumlah tersedia harus diatur ke nol sebelum mengubah pelacakan inventaris.',
                ],

                'available-quantity' => [
                    'title' => 'Gagal memperbarui produk',
                    'body'  => 'Jumlah tersedia harus diatur ke nol sebelum produk ini dapat ditandai sebagai tidak dapat disimpan.',
                ],

                'track-by-update' => [
                    'title' => 'Gagal memperbarui pelacakan',
                    'body'  => 'Ada produk dalam stok yang belum memiliki lot/nomor seri. Anda dapat menetapkan lot/nomor seri melalui penyesuaian inventaris.',
                ],
            ],
        ],
    ],
];
