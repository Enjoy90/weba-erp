<?php

return [
    'navigation' => [
        'title' => 'Kolom Kustom',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'fields' => [
                    'name'              => 'Nama',
                    'code'              => 'kode',
                    'code-helper-text'  => 'Kode harus diawali huruf atau garis bawah, dan hanya boleh berisi huruf, angka, dan garis bawah.',
                ],
            ],

            'options' => [
                'title' => 'Opsi',

                'fields' => [
                    'add-option' => 'Tambah Opsi',
                ],
            ],

            'form-settings' => [
                'title' => 'Pengaturan Form',

                'field-sets' => [
                    'validations' => [
                        'title' => 'Validasi',

                        'fields' => [
                            'validation'     => 'Validasi',
                            'field'          => 'Kolom',
                            'value'          => 'Nilai',
                            'add-validation' => 'Tambah Validasi',
                        ],
                    ],

                    'additional-settings' => [
                        'title' => 'Pengaturan Tambahan',

                        'fields' => [
                            'setting'     => 'Pengaturan',
                            'value'       => 'Nilai',
                            'color'       => 'Warna',
                            'add-setting' => 'Tambah Pengaturan',

                            'color-options' => [
                                'danger'    => 'Bahaya',
                                'info'      => 'Info',
                                'primary'   => 'Utama',
                                'secondary' => 'Sekunder',
                                'warning'   => 'Peringatan',
                                'success'   => 'Sukses',
                            ],

                            'grid-options' => [
                                'row'    => 'Baris',
                                'column' => 'Kolom',
                            ],

                            'input-modes' => [
                                'text'     => 'Teks',
                                'email'    => 'Email',
                                'numeric'  => 'Numerik',
                                'integer'  => 'Bilangan Bulat',
                                'password' => 'Kata Sandi',
                                'tel'      => 'Telepon',
                                'url'      => 'URL',
                                'color'    => 'Warna',
                                'none'     => 'Tidak Ada',
                                'decimal'  => 'Desimal',
                                'search'   => 'Pencarian',
                                'url'      => 'URL',
                            ],
                        ],
                    ],
                ],

                'validations' => [
                    'common' => [
                        'gt'                   => 'Lebih Besar Dari',
                        'gte'                  => 'Lebih Besar Dari atau Sama Dengan',
                        'lt'                   => 'Lebih Kecil Dari',
                        'lte'                  => 'Lebih Kecil Dari atau Sama Dengan',
                        'max-size'             => 'Ukuran Maksimal',
                        'min-size'             => 'Ukuran Minimal',
                        'multiple-of'          => 'Kelipatan Dari',
                        'nullable'             => 'Boleh Kosong',
                        'prohibited'           => 'Dilarang',
                        'prohibited-if'        => 'Dilarang Jika',
                        'prohibited-unless'    => 'Dilarang Kecuali',
                        'prohibits'            => 'Melarang',
                        'required'             => 'Wajib',
                        'required-if'          => 'Wajib Jika',
                        'required-if-accepted' => 'Wajib Jika Diterima',
                        'required-unless'      => 'Wajib Kecuali',
                        'required-with'        => 'Wajib Bersama',
                        'required-with-all'    => 'Wajib Bersama Semua',
                        'required-without'     => 'Wajib Tanpa',
                        'required-without-all' => 'Wajib Tanpa Semua',
                        'rules'                => 'Aturan Kustom',
                        'unique'               => 'Unik',
                    ],

                    'text' => [
                        'alpha-dash'        => 'Alfanumerik dan Tanda Hubung',
                        'alpha-num'         => 'Alfanumerik',
                        'ascii'             => 'ASCII',
                        'doesnt-end-with'   => 'Tidak Diakhiri Dengan',
                        'doesnt-start-with' => 'Tidak Diawali Dengan',
                        'ends-with'         => 'Diakhiri Dengan',
                        'filled'            => 'Terisi',
                        'ip'                => 'IP',
                        'ipv4'              => 'IPv4',
                        'ipv6'              => 'IPv6',
                        'length'            => 'Panjang',
                        'mac-address'       => 'Alamat MAC',
                        'max-length'        => 'Panjang Maksimal',
                        'min-length'        => 'Panjang Minimal',
                        'regex'             => 'Regex',
                        'starts-with'       => 'Diawali Dengan',
                        'ulid'              => 'ULID',
                        'uuid'              => 'UUID',
                    ],

                    'textarea' => [
                        'filled'     => 'Terisi',
                        'max-length' => 'Panjang Maksimal',
                        'min-length' => 'Panjang Minimal',
                    ],

                    'select' => [
                        'different'  => 'Berbeda Dari',
                        'exists'     => 'Ada',
                        'in'         => 'Termasuk Dalam',
                        'not-in'     => 'Tidak Termasuk Dalam',
                        'same'       => 'Sama Dengan',
                    ],

                    'radio' => [],

                    'checkbox' => [
                        'accepted' => 'Diterima',
                        'declined' => 'Ditolak',
                    ],

                    'toggle' => [
                        'accepted' => 'Diterima',
                        'declined' => 'Ditolak',
                    ],

                    'checkbox-list' => [
                        'in'        => 'Termasuk Dalam',
                        'max-items' => 'Item Maksimal',
                        'min-items' => 'Item Minimal',
                    ],

                    'datetime' => [
                        'after'           => 'Setelah',
                        'after-or-equal'  => 'Setelah atau Sama Dengan',
                        'before'          => 'Sebelum',
                        'before-or-equal' => 'Sebelum atau Sama Dengan',
                    ],

                    'editor' => [
                        'filled'     => 'Terisi',
                        'max-length' => 'Panjang Maksimal',
                        'min-length' => 'Panjang Minimal',
                    ],

                    'markdown' => [
                        'filled'     => 'Terisi',
                        'max-length' => 'Panjang Maksimal',
                        'min-length' => 'Panjang Minimal',
                    ],

                    'color' => [
                        'hex-color' => 'Warna Hex',
                    ],
                ],

                'settings' => [
                    'text' => [
                        'autocapitalize'    => 'Kapitalisasi Otomatis',
                        'autocomplete'      => 'Lengkapi Otomatis',
                        'autofocus'         => 'Fokus Otomatis',
                        'default'           => 'Nilai Bawaan',
                        'disabled'          => 'Nonaktif',
                        'helper-text'       => 'Teks Bantuan',
                        'hint'              => 'Petunjuk',
                        'hint-color'        => 'Warna Petunjuk',
                        'hint-icon'         => 'Ikon Petunjuk',
                        'id'                => 'Id',
                        'input-mode'        => 'Mode Input',
                        'mask'              => 'Pola Input',
                        'placeholder'       => 'Placeholder',
                        'prefix'            => 'Prefiks',
                        'prefix-icon'       => 'Ikon Prefiks',
                        'prefix-icon-color' => 'Warna Ikon Prefiks',
                        'read-only'         => 'Hanya Baca',
                        'step'              => 'Kenaikan',
                        'suffix'            => 'Sufiks',
                        'suffix-icon'       => 'Ikon Sufiks',
                        'suffix-icon-color' => 'Warna Ikon Sufiks',
                    ],

                    'textarea' => [
                        'autofocus'     => 'Fokus Otomatis',
                        'autosize'      => 'Ukuran Otomatis',
                        'cols'          => 'Jumlah Kolom',
                        'default'       => 'Nilai Bawaan',
                        'disabled'      => 'Nonaktif',
                        'helper-text'   => 'Teks Bantuan',
                        'hint'          => 'Petunjuk',
                        'hint-color'    => 'Warna Petunjuk',
                        'hint-icon'     => 'Ikon Petunjuk',
                        'id'            => 'Id',
                        'placeholder'   => 'Placeholder',
                        'read-only'     => 'Hanya Baca',
                        'rows'          => 'Jumlah Baris',
                    ],

                    'select' => [
                        'default'                   => 'Nilai Bawaan',
                        'disabled'                  => 'Nonaktif',
                        'helper-text'               => 'Teks Bantuan',
                        'hint'                      => 'Petunjuk',
                        'hint-color'                => 'Warna Petunjuk',
                        'hint-icon'                 => 'Ikon Petunjuk',
                        'id'                        => 'Id',
                        'loading-message'           => 'Pesan Saat Memuat',
                        'no-search-results-message' => 'Pesan Pencarian Tanpa Hasil',
                        'options-limit'             => 'Batas Opsi',
                        'preload'                   => 'Muat di Awal',
                        'searchable'                => 'Dapat Dicari',
                        'search-debounce'           => 'Jeda Pencarian',
                        'searching-message'         => 'Pesan Saat Mencari',
                        'search-prompt'             => 'Petunjuk Pencarian',
                    ],

                    'radio' => [
                        'default'     => 'Nilai Bawaan',
                        'disabled'    => 'Nonaktif',
                        'helper-text' => 'Teks Bantuan',
                        'hint'        => 'Petunjuk',
                        'hint-color'  => 'Warna Petunjuk',
                        'hint-icon'   => 'Ikon Petunjuk',
                        'id'          => 'Id',
                    ],

                    'checkbox' => [
                        'default'     => 'Nilai Bawaan',
                        'disabled'    => 'Nonaktif',
                        'helper-text' => 'Teks Bantuan',
                        'hint'        => 'Petunjuk',
                        'hint-color'  => 'Warna Petunjuk',
                        'hint-icon'   => 'Ikon Petunjuk',
                        'id'          => 'Id',
                        'inline'      => 'Sebaris',
                    ],

                    'toggle' => [
                        'default'     => 'Nilai Bawaan',
                        'disabled'    => 'Nonaktif',
                        'helper-text' => 'Teks Bantuan',
                        'hint'        => 'Petunjuk',
                        'hint-color'  => 'Warna Petunjuk',
                        'hint-icon'   => 'Ikon Petunjuk',
                        'id'          => 'Id',
                        'off-color'   => 'Warna Saat Mati',
                        'off-icon'    => 'Ikon Saat Mati',
                        'on-color'    => 'Warna Saat Aktif',
                        'on-icon'     => 'Ikon Saat Aktif',
                    ],

                    'checkbox-list' => [
                        'bulk-toggleable'           => 'Dapat Dipilih Massal',
                        'columns'                   => 'Jumlah Kolom',
                        'default'                   => 'Nilai Bawaan',
                        'disabled'                  => 'Nonaktif',
                        'grid-direction'            => 'Arah Grid',
                        'helper-text'               => 'Teks Bantuan',
                        'hint'                      => 'Petunjuk',
                        'hint-color'                => 'Warna Petunjuk',
                        'hint-icon'                 => 'Ikon Petunjuk',
                        'id'                        => 'Id',
                        'max-items'                 => 'Item Maksimal',
                        'min-items'                 => 'Item Minimal',
                        'no-search-results-message' => 'Pesan Pencarian Tanpa Hasil',
                        'searchable'                => 'Dapat Dicari',
                    ],

                    'datetime' => [
                        'close-on-date-selection' => 'Tutup Saat Tanggal Dipilih',
                        'default'                 => 'Nilai Bawaan',
                        'disabled'                => 'Nonaktif',
                        'disabled-dates'          => 'Tanggal Nonaktif',
                        'display-format'          => 'Format Tampilan',
                        'first-day-of-week'       => 'Hari Pertama dalam Minggu',
                        'format'                  => 'Format',
                        'helper-text'             => 'Teks Bantuan',
                        'hint'                    => 'Petunjuk',
                        'hint-color'              => 'Warna Petunjuk',
                        'hint-icon'               => 'Ikon Petunjuk',
                        'hours-step'              => 'Kenaikan Jam',
                        'id'                      => 'Id',
                        'locale'                  => 'Lokal',
                        'minutes-step'            => 'Kenaikan Menit',
                        'seconds'                 => 'Detik',
                        'seconds-step'            => 'Kenaikan Detik',
                        'timezone'                => 'Zona Waktu',
                        'week-starts-on-monday'   => 'Minggu Dimulai Hari Senin',
                        'week-starts-on-sunday'   => 'Minggu Dimulai Hari Minggu',
                    ],

                    'editor' => [
                        'default'      => 'Nilai Bawaan',
                        'disabled'     => 'Nonaktif',
                        'helper-text'  => 'Teks Bantuan',
                        'hint'         => 'Petunjuk',
                        'hint-color'   => 'Warna Petunjuk',
                        'hint-icon'    => 'Ikon Petunjuk',
                        'id'           => 'Id',
                        'placeholder'  => 'Placeholder',
                        'read-only'    => 'Hanya Baca',
                    ],

                    'markdown' => [
                        'default'      => 'Nilai Bawaan',
                        'disabled'     => 'Nonaktif',
                        'helper-text'  => 'Teks Bantuan',
                        'hint'         => 'Petunjuk',
                        'hint-color'   => 'Warna Petunjuk',
                        'hint-icon'    => 'Ikon Petunjuk',
                        'id'           => 'Id',
                        'placeholder'  => 'Placeholder',
                        'read-only'    => 'Hanya Baca',
                    ],

                    'color' => [
                        'default'     => 'Nilai Bawaan',
                        'disabled'    => 'Nonaktif',
                        'helper-text' => 'Teks Bantuan',
                        'hint'        => 'Petunjuk',
                        'hint-color'  => 'Warna Petunjuk',
                        'hint-icon'   => 'Ikon Petunjuk',
                        'hsl'         => 'HSL',
                        'id'          => 'Id',
                        'rgb'         => 'RGB',
                        'rgba'        => 'RGBA',
                    ],

                    'file' => [
                        'accepted-file-types'                   => 'Jenis Berkas yang Diterima',
                        'append-files'                          => 'Tambahkan Berkas di Akhir',
                        'deletable'                             => 'Dapat Dihapus',
                        'directory'                             => 'Direktori',
                        'downloadable'                          => 'Dapat Diunduh',
                        'fetch-file-information'                => 'Ambil Informasi Berkas',
                        'file-attachments-directory'            => 'Direktori Lampiran Berkas',
                        'file-attachments-visibility'           => 'Visibilitas Lampiran Berkas',
                        'image'                                 => 'Gambar',
                        'image-crop-aspect-ratio'               => 'Rasio Aspek Potong Gambar',
                        'image-editor'                          => 'Editor Gambar',
                        'image-editor-aspect-ratios'            => 'Rasio Aspek Editor Gambar',
                        'image-editor-empty-fill-color'         => 'Warna Isian Kosong Editor Gambar',
                        'image-editor-mode'                     => 'Mode Editor Gambar',
                        'image-preview-height'                  => 'Tinggi Pratinjau Gambar',
                        'image-resize-mode'                     => 'Mode Ubah Ukuran Gambar',
                        'image-resize-target-height'            => 'Tinggi Target Ubah Ukuran Gambar',
                        'image-resize-target-width'             => 'Lebar Target Ubah Ukuran Gambar',
                        'loading-indicator-position'            => 'Posisi Indikator Memuat',
                        'move-files'                            => 'Pindahkan Berkas',
                        'openable'                              => 'Dapat Dibuka',
                        'orient-images-from-exif'               => 'Orientasi Gambar dari EXIF',
                        'panel-aspect-ratio'                    => 'Rasio Aspek Panel',
                        'panel-layout'                          => 'Tata Letak Panel',
                        'previewable'                           => 'Dapat Dipratinjau',
                        'remove-uploaded-file-button-position'  => 'Posisi Tombol Hapus Berkas Terunggah',
                        'reorderable'                           => 'Dapat Diurutkan Ulang',
                        'store-files'                           => 'Simpan Berkas',
                        'upload-button-position'                => 'Posisi Tombol Unggah',
                        'uploading-message'                     => 'Pesan Saat Mengunggah',
                        'upload-progress-indicator-position'    => 'Posisi Indikator Progres Unggah',
                        'visibility'                            => 'Visibilitas',
                    ],
                ],
            ],

            'table-settings' => [
                'title' => 'Pengaturan Tabel',

                'fields' => [
                    'use-in-table'  => 'Gunakan di Tabel',
                    'setting'       => 'Pengaturan',
                    'value'         => 'Nilai',
                    'color'         => 'Warna',
                    'alignment'     => 'Perataan',
                    'font-weight'   => 'Ketebalan Huruf',
                    'icon-position' => 'Posisi Ikon',
                    'size'          => 'Ukuran',
                    'add-setting'   => 'Tambah Pengaturan',

                    'color-options' => [
                        'danger'    => 'Bahaya',
                        'info'      => 'Info',
                        'primary'   => 'Utama',
                        'secondary' => 'Sekunder',
                        'warning'   => 'Peringatan',
                        'success'   => 'Sukses',
                    ],

                    'alignment-options' => [
                        'start'   => 'Awal',
                        'left'    => 'Kiri',
                        'center'  => 'Tengah',
                        'end'     => 'Akhir',
                        'right'   => 'Kanan',
                        'justify' => 'Rata Kiri Kanan',
                        'between' => 'Di Antara',
                    ],

                    'font-weight-options' => [
                        'thin'        => 'Tipis',
                        'extra-light' => 'Ekstra Ringan',
                        'light'       => 'Ringan',
                        'normal'      => 'Normal',
                        'medium'      => 'Sedang',
                        'semi-bold'   => 'Semi Tebal',
                        'bold'        => 'Tebal',
                        'extra-bold'  => 'Ekstra Tebal',
                        'black'       => 'Sangat Tebal',
                    ],

                    'icon-position-options' => [
                        'before'  => 'Sebelum',
                        'after'   => 'Sesudah',
                    ],

                    'size-options' => [
                        'extra-small' => 'Ekstra Kecil',
                        'small'       => 'Kecil',
                        'medium'      => 'Sedang',
                        'large'       => 'Besar',
                    ],
                ],

                'settings' => [
                    'common' => [
                        'align-end'              => 'Rata Akhir',
                        'alignment'              => 'Perataan',
                        'align-start'            => 'Rata Awal',
                        'badge'                  => 'Lencana',
                        'boolean'                => 'Boolean',
                        'color'                  => 'Warna',
                        'copyable'               => 'Dapat Disalin',
                        'copy-message'           => 'Pesan Salin',
                        'copy-message-duration'  => 'Durasi Pesan Salin',
                        'default'                => 'Bawaan',
                        'filterable'             => 'Dapat Difilter',
                        'groupable'              => 'Dapat Dikelompokkan',
                        'grow'                   => 'Melebar',
                        'icon'                   => 'Ikon',
                        'icon-color'             => 'Warna Ikon',
                        'icon-position'          => 'Posisi Ikon',
                        'label'                  => 'Label',
                        'limit'                  => 'Batas',
                        'line-clamp'             => 'Batas Baris',
                        'money'                  => 'Uang',
                        'placeholder'            => 'Placeholder',
                        'prefix'                 => 'Prefiks',
                        'searchable'             => 'Dapat Dicari',
                        'size'                   => 'Ukuran',
                        'sortable'               => 'Dapat Diurutkan',
                        'suffix'                 => 'Sufiks',
                        'toggleable'             => 'Dapat Disembunyikan',
                        'tooltip'                => 'Tooltip',
                        'vertical-alignment'     => 'Perataan Vertikal',
                        'vertically-align-start' => 'Rata Atas',
                        'weight'                 => 'Ketebalan',
                        'width'                  => 'Lebar',
                        'words'                  => 'Batas Kata',
                        'wrap-header'            => 'Lipat Judul Kolom',
                        'column-span'            => 'Rentang Kolom',
                        'helper-text'            => 'Teks Bantuan',
                        'hint'                   => 'Petunjuk',
                        'hint-color'             => 'Warna Petunjuk',
                        'hint-icon'              => 'Ikon Petunjuk',
                    ],

                    'datetime' => [
                        'date'              => 'Tanggal',
                        'date-time'         => 'Tanggal dan Waktu',
                        'date-time-tooltip' => 'Tooltip Tanggal dan Waktu',
                        'since'             => 'Sejak',
                    ],
                ],
            ],

            'infolist-settings' => [
                'title' => 'Pengaturan Infolist',

                'fields' => [
                    'setting'       => 'Pengaturan',
                    'value'         => 'Nilai',
                    'color'         => 'Warna',
                    'font-weight'   => 'Ketebalan Huruf',
                    'icon-position' => 'Posisi Ikon',
                    'size'          => 'Ukuran',
                    'add-setting'   => 'Tambah Pengaturan',

                    'color-options' => [
                        'danger'    => 'Bahaya',
                        'info'      => 'Info',
                        'primary'   => 'Utama',
                        'secondary' => 'Sekunder',
                        'warning'   => 'Peringatan',
                        'success'   => 'Sukses',
                    ],

                    'font-weight-options' => [
                        'thin'        => 'Tipis',
                        'extra-light' => 'Ekstra Ringan',
                        'light'       => 'Ringan',
                        'normal'      => 'Normal',
                        'medium'      => 'Sedang',
                        'semi-bold'   => 'Semi Tebal',
                        'bold'        => 'Tebal',
                        'extra-bold'  => 'Ekstra Tebal',
                        'black'       => 'Sangat Tebal',
                    ],

                    'icon-position-options' => [
                        'before'  => 'Sebelum',
                        'after'   => 'Sesudah',
                    ],

                    'size-options' => [
                        'extra-small' => 'Ekstra Kecil',
                        'small'       => 'Kecil',
                        'medium'      => 'Sedang',
                        'large'       => 'Besar',
                    ],
                ],

                'settings' => [
                    'common' => [
                        'align-end'              => 'Rata Akhir',
                        'alignment'              => 'Perataan',
                        'align-start'            => 'Rata Awal',
                        'badge'                  => 'Lencana',
                        'boolean'                => 'Boolean',
                        'color'                  => 'Warna',
                        'copyable'               => 'Dapat Disalin',
                        'copy-message'           => 'Pesan Salin',
                        'copy-message-duration'  => 'Durasi Pesan Salin',
                        'default'                => 'Bawaan',
                        'filterable'             => 'Dapat Difilter',
                        'groupable'              => 'Dapat Dikelompokkan',
                        'grow'                   => 'Melebar',
                        'icon'                   => 'Ikon',
                        'icon-color'             => 'Warna Ikon',
                        'icon-position'          => 'Posisi Ikon',
                        'label'                  => 'Label',
                        'limit'                  => 'Batas',
                        'line-clamp'             => 'Batas Baris',
                        'money'                  => 'Uang',
                        'placeholder'            => 'Placeholder',
                        'prefix'                 => 'Prefiks',
                        'searchable'             => 'Dapat Dicari',
                        'size'                   => 'Ukuran',
                        'sortable'               => 'Dapat Diurutkan',
                        'suffix'                 => 'Sufiks',
                        'toggleable'             => 'Dapat Disembunyikan',
                        'tooltip'                => 'Tooltip',
                        'vertical-alignment'     => 'Perataan Vertikal',
                        'vertically-align-start' => 'Rata Atas',
                        'weight'                 => 'Ketebalan',
                        'width'                  => 'Lebar',
                        'words'                  => 'Batas Kata',
                        'wrap-header'            => 'Lipat Judul Kolom',
                        'column-span'            => 'Rentang Kolom',
                        'helper-text'            => 'Teks Bantuan',
                        'hint'                   => 'Petunjuk',
                        'hint-color'             => 'Warna Petunjuk',
                        'hint-icon'              => 'Ikon Petunjuk',
                    ],

                    'datetime' => [
                        'date'              => 'Tanggal',
                        'date-time'         => 'Tanggal dan Waktu',
                        'date-time-tooltip' => 'Tooltip Tanggal dan Waktu',
                        'since'             => 'Sejak',
                    ],

                    'checkbox-list' => [
                        'separator'                => 'Pemisah',
                        'list-with-line-breaks'    => 'Daftar dengan Baris Baru',
                        'bulleted'                 => 'Berpoin',
                        'limit-list'               => 'Batasi Daftar',
                        'expandable-limited-list'  => 'Daftar Terbatas yang Dapat Diperluas',
                    ],

                    'select' => [
                        'separator'                => 'Pemisah',
                        'list-with-line-breaks'    => 'Daftar dengan Baris Baru',
                        'bulleted'                 => 'Berpoin',
                        'limit-list'               => 'Batasi Daftar',
                        'expandable-limited-list'  => 'Daftar Terbatas yang Dapat Diperluas',
                    ],

                    'checkbox' => [
                        'boolean'     => 'Boolean',
                        'false-icon'  => 'Ikon Salah',
                        'true-icon'   => 'Ikon Benar',
                        'true-color'  => 'Warna Benar',
                        'false-color' => 'Warna Salah',
                    ],

                    'toggle' => [
                        'boolean'     => 'Boolean',
                        'false-icon'  => 'Ikon Salah',
                        'true-icon'   => 'Ikon Benar',
                        'true-color'  => 'Warna Benar',
                        'false-color' => 'Warna Salah',
                    ],
                ],
            ],

            'settings' => [
                'title' => 'Pengaturan',

                'fields' => [
                    'type'           => 'Jenis',
                    'input-type'     => 'Jenis Input',
                    'is-multiselect' => 'Pilihan Ganda',
                    'sort-order'     => 'Urutan',

                    'type-options' => [
                        'text'          => 'Input Teks',
                        'textarea'      => 'Area Teks',
                        'select'        => 'Pilihan',
                        'checkbox'      => 'Kotak Centang',
                        'radio'         => 'Radio',
                        'toggle'        => 'Sakelar',
                        'checkbox-list' => 'Daftar Kotak Centang',
                        'datetime'      => 'Pemilih Tanggal dan Waktu',
                        'editor'        => 'Editor Teks Kaya',
                        'markdown'      => 'Editor Markdown',
                        'color'         => 'Pemilih Warna',
                    ],

                    'input-type-options' => [
                        'text'     => 'Teks',
                        'email'    => 'Email',
                        'numeric'  => 'Numerik',
                        'integer'  => 'Bilangan Bulat',
                        'password' => 'Kata Sandi',
                        'tel'      => 'Telepon',
                        'url'      => 'URL',
                        'color'    => 'Warna',
                    ],
                ],
            ],

            'resource' => [
                'title' => 'Resource',

                'fields' => [
                    'plugin'   => 'Plugin',
                    'resource' => 'Resource',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'code'       => 'Kode',
            'name'       => 'Nama',
            'type'       => 'Jenis',
            'resource'   => 'Resource',
            'created-at' => 'Dibuat Pada',
        ],

        'groups' => [
        ],

        'filters' => [
            'type'     => 'Jenis',
            'resource' => 'Resource',

            'type-options' => [
                'text'          => 'Input Teks',
                'textarea'      => 'Area Teks',
                'select'        => 'Pilihan',
                'checkbox'      => 'Kotak Centang',
                'radio'         => 'Radio',
                'toggle'        => 'Sakelar',
                'checkbox-list' => 'Daftar Kotak Centang',
                'datetime'      => 'Pemilih Tanggal dan Waktu',
                'editor'        => 'Editor Teks Kaya',
                'markdown'      => 'Editor Markdown',
                'color'         => 'Pemilih Warna',
            ],
        ],

        'actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Kolom berhasil dipulihkan',
                    'body'  => 'Kolom telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Kolom berhasil dihapus',
                    'body'  => 'Kolom telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Kolom berhasil dihapus permanen',
                    'body'  => 'Kolom telah berhasil dihapus permanen.',
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Kolom berhasil dipulihkan',
                    'body'  => 'Kolom yang dipilih telah berhasil dipulihkan.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Kolom berhasil dihapus',
                    'body'  => 'Kolom yang dipilih telah berhasil dihapus.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Kolom berhasil dihapus permanen',
                    'body'  => 'Kolom yang dipilih telah berhasil dihapus permanen.',
                ],
            ],
        ],
    ],
];
