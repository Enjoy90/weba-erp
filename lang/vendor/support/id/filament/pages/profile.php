<?php

return [
    'title'                   => 'Profil',
    'heading'                 => 'Profil',
    'subheading'              => 'Kelola pengaturan dan preferensi akun Anda.',
    'information_section'     => 'Informasi Profil',
    'information_description' => 'Perbarui informasi profil dan alamat email akun Anda.',

    'notification' => [
        'success' => [
            'title' => 'Profil berhasil diperbarui',
            'body'  => 'Profil Anda telah berhasil diperbarui.',
        ],

        'error' => [
            'title' => 'Gagal Memperbarui Profil',
            'body'  => 'Terjadi kesalahan saat memperbarui profil Anda.',
        ],

        'validation-error' => [
            'title' => 'Kesalahan Validasi',
        ],
    ],

    'actions' => [
        'save' => 'Simpan Perubahan',
    ],

    'fields' => [
        'avatar'          => 'Foto Profil',
        'name'            => 'Nama',
        'email'           => 'Email',
        'language'        => 'Bahasa Pilihan',
        'language_helper' => 'Antarmuka admin akan ditampilkan dalam bahasa ini.',
    ],

    'password' => [
        'section'     => 'Perbarui Kata Sandi',
        'description' => 'Pastikan akun Anda memakai kata sandi yang panjang dan acak agar tetap aman.',
        'current'     => 'Kata Sandi Saat Ini',
        'new'         => 'Kata Sandi Baru',
        'confirm'     => 'Konfirmasi Kata Sandi',
        'helper'      => 'Minimal 8 karakter.',

        'errors' => [
            'current-required'  => 'Kata sandi saat ini wajib diisi.',
            'current-incorrect' => 'Kata sandi saat ini salah. Silakan coba lagi.',
            'same-as-current'   => 'Kata sandi baru harus berbeda dari kata sandi saat ini.',
        ],

        'current-helper' => 'Masukkan kata sandi saat ini untuk memverifikasi identitas Anda.',

        'notification' => [
            'success' => [
                'title' => 'Kata sandi berhasil diperbarui',
                'body'  => 'Kata sandi Anda telah berhasil diperbarui.',
            ],

            'error' => [
                'title' => 'Gagal Memperbarui Kata Sandi',
                'body'  => 'Terjadi kesalahan saat memperbarui kata sandi Anda.',
            ],
        ],
    ],
];
