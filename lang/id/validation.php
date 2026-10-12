<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pesan Validasi
    |--------------------------------------------------------------------------
    |
    | Pesan galat bawaan kelas validator dalam bahasa Indonesia. Kuncinya sama
    | dengan berkas bahasa Inggris bawaan Laravel.
    |
    */

    'accepted'             => 'Kolom :attribute harus diterima.',
    'accepted_if'          => 'Kolom :attribute harus diterima ketika :other bernilai :value.',
    'active_url'           => 'Kolom :attribute harus berupa URL yang valid.',
    'after'                => 'Kolom :attribute harus berisi tanggal setelah :date.',
    'after_or_equal'       => 'Kolom :attribute harus berisi tanggal setelah atau sama dengan :date.',
    'alpha'                => 'Kolom :attribute hanya boleh berisi huruf.',
    'alpha_dash'           => 'Kolom :attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num'            => 'Kolom :attribute hanya boleh berisi huruf dan angka.',
    'any_of'               => 'Kolom :attribute tidak valid.',
    'array'                => 'Kolom :attribute harus berupa larik.',
    'array_keys'           => 'Kolom :attribute hanya boleh berisi kunci berikut: :values.',
    'ascii'                => 'Kolom :attribute hanya boleh berisi karakter alfanumerik dan simbol satu bita.',
    'base64'               => 'Kolom :attribute harus berupa teks Base64 yang valid.',
    'before'               => 'Kolom :attribute harus berisi tanggal sebelum :date.',
    'before_or_equal'      => 'Kolom :attribute harus berisi tanggal sebelum atau sama dengan :date.',
    'between'              => [
        'array'   => 'Kolom :attribute harus berisi antara :min dan :max item.',
        'file'    => 'Ukuran berkas :attribute harus antara :min dan :max kilobita.',
        'numeric' => 'Nilai :attribute harus antara :min dan :max.',
        'string'  => 'Kolom :attribute harus berisi antara :min dan :max karakter.',
    ],
    'boolean'              => 'Kolom :attribute harus bernilai benar atau salah.',
    'can'                  => 'Kolom :attribute berisi nilai yang tidak diizinkan.',
    'confirmed'            => 'Konfirmasi :attribute tidak cocok.',
    'contains'             => 'Kolom :attribute tidak berisi nilai yang diwajibkan.',
    'current_password'     => 'Kata sandi salah.',
    'date'                 => 'Kolom :attribute harus berisi tanggal yang valid.',
    'date_equals'          => 'Kolom :attribute harus berisi tanggal yang sama dengan :date.',
    'date_format'          => 'Kolom :attribute harus sesuai dengan format :format.',
    'decimal'              => 'Kolom :attribute harus memiliki :decimal angka desimal.',
    'declined'             => 'Kolom :attribute harus ditolak.',
    'declined_if'          => 'Kolom :attribute harus ditolak ketika :other bernilai :value.',
    'different'            => 'Kolom :attribute dan :other harus berbeda.',
    'digits'               => 'Kolom :attribute harus terdiri atas :digits digit.',
    'digits_between'       => 'Kolom :attribute harus terdiri atas :min sampai :max digit.',
    'dimensions'           => 'Ukuran gambar :attribute tidak valid.',
    'distinct'             => 'Kolom :attribute memiliki nilai ganda.',
    'doesnt_contain'       => 'Kolom :attribute tidak boleh berisi salah satu dari: :values.',
    'doesnt_end_with'      => 'Kolom :attribute tidak boleh diakhiri salah satu dari: :values.',
    'doesnt_start_with'    => 'Kolom :attribute tidak boleh diawali salah satu dari: :values.',
    'email'                => 'Kolom :attribute harus berisi alamat email yang valid.',
    'encoding'             => 'Kolom :attribute harus menggunakan pengodean :encoding.',
    'ends_with'            => 'Kolom :attribute harus diakhiri salah satu dari: :values.',
    'enum'                 => ':attribute yang dipilih tidak valid.',
    'exists'               => ':attribute yang dipilih tidak valid.',
    'extensions'           => 'Kolom :attribute harus memiliki salah satu ekstensi berikut: :values.',
    'file'                 => 'Kolom :attribute harus berupa berkas.',
    'filled'               => 'Kolom :attribute harus diisi.',
    'gt'                   => [
        'array'   => 'Kolom :attribute harus berisi lebih dari :value item.',
        'file'    => 'Ukuran berkas :attribute harus lebih dari :value kilobita.',
        'numeric' => 'Nilai :attribute harus lebih dari :value.',
        'string'  => 'Kolom :attribute harus lebih dari :value karakter.',
    ],
    'gte'                  => [
        'array'   => 'Kolom :attribute harus berisi :value item atau lebih.',
        'file'    => 'Ukuran berkas :attribute harus lebih dari atau sama dengan :value kilobita.',
        'numeric' => 'Nilai :attribute harus lebih dari atau sama dengan :value.',
        'string'  => 'Kolom :attribute harus lebih dari atau sama dengan :value karakter.',
    ],
    'hex_color'            => 'Kolom :attribute harus berupa warna heksadesimal yang valid.',
    'image'                => 'Kolom :attribute harus berupa gambar.',
    'in'                   => ':attribute yang dipilih tidak valid.',
    'in_array'             => 'Kolom :attribute harus ada di :other.',
    'in_array_keys'        => 'Kolom :attribute harus berisi paling sedikit salah satu kunci berikut: :values.',
    'integer'              => 'Kolom :attribute harus berupa bilangan bulat.',
    'ip'                   => 'Kolom :attribute harus berupa alamat IP yang valid.',
    'ipv4'                 => 'Kolom :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6'                 => 'Kolom :attribute harus berupa alamat IPv6 yang valid.',
    'json'                 => 'Kolom :attribute harus berupa teks JSON yang valid.',
    'list'                 => 'Kolom :attribute harus berupa daftar.',
    'lowercase'            => 'Kolom :attribute harus ditulis dengan huruf kecil.',
    'lt'                   => [
        'array'   => 'Kolom :attribute harus berisi kurang dari :value item.',
        'file'    => 'Ukuran berkas :attribute harus kurang dari :value kilobita.',
        'numeric' => 'Nilai :attribute harus kurang dari :value.',
        'string'  => 'Kolom :attribute harus kurang dari :value karakter.',
    ],
    'lte'                  => [
        'array'   => 'Kolom :attribute tidak boleh berisi lebih dari :value item.',
        'file'    => 'Ukuran berkas :attribute harus kurang dari atau sama dengan :value kilobita.',
        'numeric' => 'Nilai :attribute harus kurang dari atau sama dengan :value.',
        'string'  => 'Kolom :attribute harus kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address'          => 'Kolom :attribute harus berupa alamat MAC yang valid.',
    'max'                  => [
        'array'   => 'Kolom :attribute tidak boleh berisi lebih dari :max item.',
        'file'    => 'Ukuran berkas :attribute tidak boleh lebih dari :max kilobita.',
        'numeric' => 'Nilai :attribute tidak boleh lebih dari :max.',
        'string'  => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
    ],
    'max_digits'           => 'Kolom :attribute tidak boleh lebih dari :max digit.',
    'mimes'                => 'Kolom :attribute harus berupa berkas berjenis: :values.',
    'mimetypes'            => 'Kolom :attribute harus berupa berkas berjenis: :values.',
    'min'                  => [
        'array'   => 'Kolom :attribute harus berisi paling sedikit :min item.',
        'file'    => 'Ukuran berkas :attribute paling kecil :min kilobita.',
        'numeric' => 'Nilai :attribute paling kecil :min.',
        'string'  => 'Kolom :attribute paling sedikit :min karakter.',
    ],
    'min_digits'           => 'Kolom :attribute paling sedikit :min digit.',
    'missing'              => 'Kolom :attribute harus kosong.',
    'missing_if'           => 'Kolom :attribute harus kosong ketika :other bernilai :value.',
    'missing_unless'       => 'Kolom :attribute harus kosong kecuali :other bernilai :value.',
    'missing_with'         => 'Kolom :attribute harus kosong ketika :values diisi.',
    'missing_with_all'     => 'Kolom :attribute harus kosong ketika :values diisi.',
    'multiple_of'          => 'Nilai :attribute harus kelipatan :value.',
    'not_in'               => ':attribute yang dipilih tidak valid.',
    'not_regex'            => 'Format :attribute tidak valid.',
    'numeric'              => 'Kolom :attribute harus berupa angka.',
    'password'             => [
        'letters'       => 'Kolom :attribute harus berisi paling sedikit satu huruf.',
        'mixed'         => 'Kolom :attribute harus berisi paling sedikit satu huruf besar dan satu huruf kecil.',
        'numbers'       => 'Kolom :attribute harus berisi paling sedikit satu angka.',
        'symbols'       => 'Kolom :attribute harus berisi paling sedikit satu simbol.',
        'uncompromised' => ':attribute tersebut pernah muncul dalam kebocoran data. Silakan pilih :attribute lain.',
    ],
    'present'                => 'Kolom :attribute harus ada.',
    'present_if'             => 'Kolom :attribute harus ada ketika :other bernilai :value.',
    'present_unless'         => 'Kolom :attribute harus ada kecuali :other bernilai :value.',
    'present_with'           => 'Kolom :attribute harus ada ketika :values ada.',
    'present_with_all'       => 'Kolom :attribute harus ada ketika :values ada.',
    'prohibited'             => 'Kolom :attribute tidak boleh diisi.',
    'prohibited_if'          => 'Kolom :attribute tidak boleh diisi ketika :other bernilai :value.',
    'prohibited_if_accepted' => 'Kolom :attribute tidak boleh diisi ketika :other diterima.',
    'prohibited_if_declined' => 'Kolom :attribute tidak boleh diisi ketika :other ditolak.',
    'prohibited_unless'      => 'Kolom :attribute tidak boleh diisi kecuali :other ada di :values.',
    'prohibits'              => 'Kolom :attribute melarang :other diisi.',
    'regex'                  => 'Format :attribute tidak valid.',
    'required'               => 'Kolom :attribute wajib diisi.',
    'required_array_keys'    => 'Kolom :attribute harus berisi entri untuk: :values.',
    'required_if'            => 'Kolom :attribute wajib diisi ketika :other bernilai :value.',
    'required_if_accepted'   => 'Kolom :attribute wajib diisi ketika :other diterima.',
    'required_if_declined'   => 'Kolom :attribute wajib diisi ketika :other ditolak.',
    'required_unless'        => 'Kolom :attribute wajib diisi kecuali :other ada di :values.',
    'required_with'          => 'Kolom :attribute wajib diisi ketika :values diisi.',
    'required_with_all'      => 'Kolom :attribute wajib diisi ketika :values diisi.',
    'required_without'       => 'Kolom :attribute wajib diisi ketika :values tidak diisi.',
    'required_without_all'   => 'Kolom :attribute wajib diisi ketika :values tidak ada yang diisi.',
    'same'                   => 'Kolom :attribute harus sama dengan :other.',
    'size'                   => [
        'array'   => 'Kolom :attribute harus berisi :size item.',
        'file'    => 'Ukuran berkas :attribute harus :size kilobita.',
        'numeric' => 'Nilai :attribute harus :size.',
        'string'  => 'Kolom :attribute harus :size karakter.',
    ],
    'starts_with'          => 'Kolom :attribute harus diawali salah satu dari: :values.',
    'string'               => 'Kolom :attribute harus berupa teks.',
    'timezone'             => 'Kolom :attribute harus berupa zona waktu yang valid.',
    'unique'               => ':attribute sudah digunakan.',
    'uploaded'             => ':attribute gagal diunggah.',
    'uppercase'            => 'Kolom :attribute harus ditulis dengan huruf besar.',
    'url'                  => 'Kolom :attribute harus berupa URL yang valid.',
    'ulid'                 => 'Kolom :attribute harus berupa ULID yang valid.',
    'uuid'                 => 'Kolom :attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Pesan Validasi Khusus
    |--------------------------------------------------------------------------
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Nama Atribut
    |--------------------------------------------------------------------------
    */

    'attributes' => [],

];
