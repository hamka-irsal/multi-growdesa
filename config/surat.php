<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Surat Pengantar
    |--------------------------------------------------------------------------
    */

    'Surat Pengantar' => [

        // Tambahan untuk API
        'slug' => 'surat_pengantar',

        'nama' => 'Surat Pengantar',

        'api_enabled' => true,

        'icon' => 'file-text',

        'color' => '#2563EB',

        'urutan' => 1,

        // Konfigurasi lama tetap
        'model' => App\Models\SuratPengantar::class,

        'table' => 'surat_pengantar',

        // Form pengajuan dari Anjungan
        'form_view' => 'anjungan.surat.pengantar',

        // Template cetak dari Admin Panel
        'admin_view' => 'admin.surat.cetak.pengantar',

        // Template cetak dari Anjungan
        'anjungan_view' => 'anjungan.riwayat.cetak.pengantar',

        // Field yang disimpan ke tabel surat_pengantar
        'fields' => [
            'keperluan_antar',
            'keterangan_antar',
        ],

        // Validasi input
        'validation' => [

            'keperluan_antar' => [
                'required',
                'string',
                'max:255',
            ],

            'keterangan_antar' => [
                'nullable',
                'string',
            ],

        ],

        // Tambahan form dinamis untuk Mobile API
        'form_fields' => [

            [
                'name' => 'keperluan_antar',
                'label' => 'Keperluan',
                'type' => 'text',
                'placeholder' => 'Masukkan keperluan surat',
                'required' => true,
                'max_length' => 255,
            ],

            [
                'name' => 'keterangan_antar',
                'label' => 'Keterangan Tambahan',
                'type' => 'textarea',
                'placeholder' => 'Masukkan keterangan tambahan',
                'required' => false,
            ],

        ],

        'keterangan' => 'Permohonan Surat Pengantar',

    ],


    /*
    |--------------------------------------------------------------------------
    | Surat Kehilangan
    |--------------------------------------------------------------------------
    */

    'Surat Kehilangan' => [

        // Tambahan untuk API
        'slug' => 'surat_kehilangan',

        'nama' => 'Surat Keterangan Kehilangan',

        'api_enabled' => true,

        'icon' => 'search',

        'color' => '#DC2626',

        'urutan' => 2,

        // Konfigurasi lama tetap
        'model' => App\Models\SuratKehilangan::class,

        'table' => 'surat_kehilangan',

        // Form pengajuan dari Anjungan
        'form_view' => 'anjungan.surat.kehilangan',

        // Template cetak dari Admin Panel
        'admin_view' => 'admin.surat.cetak.kehilangan',

        // Template cetak dari Anjungan
        'anjungan_view' => 'anjungan.riwayat.cetak.kehilangan',

        // Field yang disimpan ke tabel surat_kehilangan
        'fields' => [
            'barang_hilang',
            'keperluan_kepengurusan',
        ],

        // Validasi input
        'validation' => [

            'barang_hilang' => [
                'required',
                'string',
                'max:255',
            ],

            'keperluan_kepengurusan' => [
                'required',
                'string',
                'max:255',
            ],

        ],

        // Tambahan form dinamis untuk Mobile API
        'form_fields' => [

            [
                'name' => 'barang_hilang',
                'label' => 'Barang atau Dokumen yang Hilang',
                'type' => 'text',
                'placeholder' => 'Contoh: KTP, SIM, atau STNK',
                'required' => true,
                'max_length' => 255,
            ],

            [
                'name' => 'keperluan_kepengurusan',
                'label' => 'Keperluan Pengurusan',
                'type' => 'textarea',
                'placeholder' => 'Masukkan keperluan pengurusan',
                'required' => true,
                'max_length' => 255,
            ],

        ],

        'keterangan' =>
            'Permohonan Surat Keterangan Kehilangan',

    ],


    /*
    |--------------------------------------------------------------------------
    | Surat Kematian
    |--------------------------------------------------------------------------
    */

    'Surat Kematian' => [

        // Tambahan untuk API
        'slug' => 'surat_kematian',

        'nama' => 'Surat Keterangan Kematian',

        'api_enabled' => true,

        'icon' => 'file-heart',

        'color' => '#475569',

        'urutan' => 3,

        // Konfigurasi lama tetap
        'model' => App\Models\SuratKematian::class,

        'table' => 'surat_kematian',

        // Form pengajuan dari Anjungan
        'form_view' => 'anjungan.surat.kematian',

        // Template cetak dari Admin Panel
        'admin_view' => 'admin.surat.cetak.kematian',

        // Template cetak dari Anjungan
        'anjungan_view' => 'anjungan.riwayat.cetak.kematian',

        // Field yang disimpan ke tabel surat_kematian
        'fields' => [
            'tanggal_kematian',
        ],

        // Validasi input
        'validation' => [

            'tanggal_kematian' => [
                'required',
                'date',
            ],

        ],

        // Tambahan form dinamis untuk Mobile API
        'form_fields' => [

            [
                'name' => 'tanggal_kematian',
                'label' => 'Tanggal Kematian',
                'type' => 'date',
                'placeholder' => 'Pilih tanggal kematian',
                'required' => true,
            ],

        ],

        'keterangan' =>
            'Permohonan Surat Keterangan Kematian',

    ],


    /*
    |--------------------------------------------------------------------------
    | Surat Domisili
    |--------------------------------------------------------------------------
    */

    'Surat Domisili' => [

        // Tambahan untuk API
        'slug' => 'surat_domisili',

        'nama' => 'Surat Keterangan Domisili',

        'api_enabled' => true,

        'icon' => 'map-pin',

        'color' => '#059669',

        'urutan' => 4,

        // Konfigurasi lama tetap
        'model' => App\Models\SuratDomisili::class,

        'table' => 'surat_domisili',

        // Form pengajuan dari Anjungan
        'form_view' => 'anjungan.surat.domisili',

        // Template cetak dari Admin Panel
        'admin_view' => 'admin.surat.cetak.domisili',

        // Template cetak dari Anjungan
        'anjungan_view' => 'anjungan.riwayat.cetak.domisili',

        // Tidak memiliki input tambahan
        'fields' => [],

        // Tidak memiliki validasi tambahan
        'validation' => [],

        // Tidak memiliki form tambahan.
        // Data domisili diambil dari data penduduk.
        'form_fields' => [],

        'informasi' =>
            'Data alamat akan diambil otomatis dari profil penduduk.',

        'keterangan' =>
            'Permohonan Surat Keterangan Domisili',

    ],


    /*
    |--------------------------------------------------------------------------
    | Surat Usaha
    |--------------------------------------------------------------------------
    */

    'Surat Usaha' => [

        // Tambahan untuk API
        'slug' => 'surat_usaha',

        'nama' => 'Surat Keterangan Usaha',

        'api_enabled' => true,

        'icon' => 'briefcase-business',

        'color' => '#D97706',

        'urutan' => 5,

        // Konfigurasi lama tetap
        'model' => App\Models\SuratUsaha::class,

        'table' => 'surat_usaha',

        // Form pengajuan dari Anjungan
        'form_view' => 'anjungan.surat.usaha',

        // Template cetak dari Admin Panel
        'admin_view' => 'admin.surat.cetak.usaha',

        // Template cetak dari Anjungan
        'anjungan_view' => 'anjungan.riwayat.cetak.usaha',

        // Field yang disimpan ke tabel surat_usaha
        'fields' => [
            'nama_usaha',
            'jenis_usaha',
            'alamat_usaha',
            'tahun_berdiri',
        ],

        // Validasi input
        'validation' => [

            'nama_usaha' => [
                'required',
                'string',
                'max:255',
            ],

            'jenis_usaha' => [
                'required',
                'string',
                'max:255',
            ],

            'alamat_usaha' => [
                'required',
                'string',
                'max:255',
            ],

            'tahun_berdiri' => [
                'required',
                'integer',
                'min:1900',
                'max:' . date('Y'),
            ],

        ],

        // Tambahan form dinamis untuk Mobile API
        'form_fields' => [

            [
                'name' => 'nama_usaha',
                'label' => 'Nama Usaha',
                'type' => 'text',
                'placeholder' => 'Masukkan nama usaha',
                'required' => true,
                'max_length' => 255,
            ],

            [
                'name' => 'jenis_usaha',
                'label' => 'Jenis Usaha',
                'type' => 'text',
                'placeholder' => 'Contoh: Perdagangan',
                'required' => true,
                'max_length' => 255,
            ],

            [
                'name' => 'alamat_usaha',
                'label' => 'Alamat Usaha',
                'type' => 'textarea',
                'placeholder' => 'Masukkan alamat usaha',
                'required' => true,
                'max_length' => 255,
            ],

            [
                'name' => 'tahun_berdiri',
                'label' => 'Tahun Berdiri',
                'type' => 'number',
                'placeholder' => 'Contoh: 2020',
                'required' => true,
                'min' => 1900,
                'max' => (int) date('Y'),
            ],

        ],

        'keterangan' =>
            'Permohonan Surat Keterangan Usaha',

    ],


    /*
    |--------------------------------------------------------------------------
    | Surat Tidak Mampu
    |--------------------------------------------------------------------------
    */

    'Surat Tidak Mampu' => [

        // Tambahan untuk API
        'slug' => 'surat_tidak_mampu',

        'nama' => 'Surat Keterangan Tidak Mampu',

        'api_enabled' => true,

        'icon' => 'hand-heart',

        'color' => '#7C3AED',

        'urutan' => 6,

        // Konfigurasi lama tetap
        'model' => App\Models\SuratTidakMampu::class,

        'table' => 'surat_tidak_mampu',

        // Form pengajuan dari Anjungan
        'form_view' => 'anjungan.surat.tidak_mampu',

        // Template cetak dari Admin Panel
        'admin_view' => 'admin.surat.cetak.tidak_mampu',

        // Template cetak dari Anjungan
        'anjungan_view' => 'anjungan.riwayat.cetak.tidak_mampu',

        // Tidak memiliki input tambahan
        'fields' => [],

        // Tidak memiliki validasi tambahan
        'validation' => [],

        // Tidak memiliki form tambahan.
        // Data penduduk diambil otomatis dari profil.
        'form_fields' => [],

        'informasi' =>
            'Data penduduk akan diambil otomatis dari profil.',

        'keterangan' =>
            'Permohonan Surat Keterangan Tidak Mampu',

    ],

];
