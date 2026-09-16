<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            /*
            |--------------------------------------------------------------------------
            | Penduduk
            |--------------------------------------------------------------------------
            */
            ['name' => 'penduduk.index', 'label' => 'Lihat Data Penduduk'],
            ['name' => 'penduduk.create', 'label' => 'Tambah Penduduk'],
            ['name' => 'penduduk.edit', 'label' => 'Edit Penduduk'],
            ['name' => 'penduduk.delete', 'label' => 'Hapus Penduduk'],
            ['name' => 'penduduk.detail', 'label' => 'Lihat Detail Penduduk'],

            /*
            |--------------------------------------------------------------------------
            | Iklan
            |--------------------------------------------------------------------------
            */
            ['name' => 'iklan.index', 'label' => 'Lihat Iklan'],
            ['name' => 'iklan.create', 'label' => 'Tambah Iklan'],
            ['name' => 'iklan.edit', 'label' => 'Edit Iklan'],
            ['name' => 'iklan.delete', 'label' => 'Hapus Iklan'],

            /*
            |--------------------------------------------------------------------------
            | Pengajuan Surat
            |--------------------------------------------------------------------------
            */
            ['name' => 'surat-pengajuan.index', 'label' => 'Lihat Pengajuan Surat'],
            ['name' => 'surat-pengajuan.detail', 'label' => 'Lihat Detail Pengajuan Surat'],
            ['name' => 'surat-pengajuan.proses', 'label' => 'Proses Pengajuan Surat'],
            ['name' => 'surat-pengajuan.approve', 'label' => 'Setujui Pengajuan Surat'],
            ['name' => 'surat-pengajuan.reject', 'label' => 'Tolak Pengajuan Surat'],
            ['name' => 'surat-pengajuan.delete', 'label' => 'Hapus Pengajuan Surat'],

            /*
            |--------------------------------------------------------------------------
            | Manajemen Surat
            |--------------------------------------------------------------------------
            */
            ['name' => 'surat.index', 'label' => 'Lihat Manajemen Surat'],
            ['name' => 'surat.create', 'label' => 'Tambah Surat'],
            ['name' => 'surat.edit', 'label' => 'Edit Surat'],
            ['name' => 'surat.delete', 'label' => 'Hapus Surat'],
            ['name' => 'surat.detail', 'label' => 'Lihat Detail Surat'],
            ['name' => 'surat.generate', 'label' => 'Generate Surat'],
            ['name' => 'surat.download', 'label' => 'Download Surat'],
            ['name' => 'surat.print', 'label' => 'Cetak Surat'],

            /*
            |--------------------------------------------------------------------------
            | Persetujuan Surat
            |--------------------------------------------------------------------------
            */
            ['name' => 'persetujuan.index', 'label' => 'Lihat Persetujuan Surat'],
            ['name' => 'persetujuan.detail', 'label' => 'Lihat Detail Persetujuan Surat'],
            ['name' => 'persetujuan.approve', 'label' => 'Setujui dan Tanda Tangani Surat'],
            ['name' => 'persetujuan.reject', 'label' => 'Tolak Persetujuan Surat'],

            /*
            |--------------------------------------------------------------------------
            | Berita Desa
            |--------------------------------------------------------------------------
            */
            ['name' => 'berita.index', 'label' => 'Lihat Berita'],
            ['name' => 'berita.create', 'label' => 'Tambah Berita'],
            ['name' => 'berita.edit', 'label' => 'Edit Berita'],
            ['name' => 'berita.delete', 'label' => 'Hapus Berita'],
            ['name' => 'berita.detail', 'label' => 'Lihat Detail Berita'],

            /*
            |--------------------------------------------------------------------------
            | Kategori Berita
            |--------------------------------------------------------------------------
            */
            ['name' => 'kategori-berita.index', 'label' => 'Lihat Kategori Berita'],
            ['name' => 'kategori-berita.create', 'label' => 'Tambah Kategori Berita'],
            ['name' => 'kategori-berita.edit', 'label' => 'Edit Kategori Berita'],
            ['name' => 'kategori-berita.delete', 'label' => 'Hapus Kategori Berita'],

            /*
            |--------------------------------------------------------------------------
            | Produk Desa
            |--------------------------------------------------------------------------
            */
            ['name' => 'produk.index', 'label' => 'Lihat Produk Desa'],
            ['name' => 'produk.create', 'label' => 'Tambah Produk Desa'],
            ['name' => 'produk.edit', 'label' => 'Edit Produk Desa'],
            ['name' => 'produk.delete', 'label' => 'Hapus Produk Desa'],
            ['name' => 'produk.detail', 'label' => 'Lihat Detail Produk Desa'],

            /*
            |--------------------------------------------------------------------------
            | Aparat Desa
            |--------------------------------------------------------------------------
            */
            ['name' => 'aparat.index', 'label' => 'Lihat Aparat Desa'],
            ['name' => 'aparat.create', 'label' => 'Tambah Aparat Desa'],
            ['name' => 'aparat.edit', 'label' => 'Edit Aparat Desa'],
            ['name' => 'aparat.delete', 'label' => 'Hapus Aparat Desa'],
            ['name' => 'aparat.detail', 'label' => 'Lihat Detail Aparat Desa'],

            /*
            |--------------------------------------------------------------------------
            | Operator
            |--------------------------------------------------------------------------
            */
            ['name' => 'user.index', 'label' => 'Lihat Data Operator'],
            ['name' => 'user.create', 'label' => 'Tambah Operator'],
            ['name' => 'user.edit', 'label' => 'Edit Operator'],
            ['name' => 'user.delete', 'label' => 'Hapus Operator'],
            ['name' => 'user.detail', 'label' => 'Lihat Detail Operator'],
            ['name' => 'user.permission', 'label' => 'Atur Permission Operator'],

            /*
            |--------------------------------------------------------------------------
            | Verifikasi Penduduk
            |--------------------------------------------------------------------------
            */
            ['name' => 'verifikasi.index', 'label' => 'Lihat Verifikasi Penduduk'],
            ['name' => 'verifikasi.detail', 'label' => 'Lihat Detail Verifikasi Penduduk'],
            ['name' => 'verifikasi.approve', 'label' => 'Setujui Verifikasi Penduduk'],
            ['name' => 'verifikasi.reject', 'label' => 'Tolak Verifikasi Penduduk'],
        ];

        /*
        |--------------------------------------------------------------------------
        | Nama permission yang diizinkan
        |--------------------------------------------------------------------------
        */

        $permissionNames = collect($permissions)
            ->pluck('name')
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | Hapus permission lama yang tidak ada di daftar
        |--------------------------------------------------------------------------
        */

        Permission::query()
            ->where('guard_name', 'api')
            ->whereNotIn('name', $permissionNames)
            ->delete();

        /*
        |--------------------------------------------------------------------------
        | Tambah atau perbarui permission
        |--------------------------------------------------------------------------
        */

        foreach ($permissions as $permissionData) {
            Permission::updateOrCreate(
                [
                    'name' => $permissionData['name'],
                    'guard_name' => 'api',
                ],
                [
                    'label' => $permissionData['label'],
                ]
            );

            $this->command->info(
                "Permission diproses: {$permissionData['label']}"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Bersihkan cache Spatie
        |--------------------------------------------------------------------------
        */

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $this->command->info(
            'Semua permission admin desa berhasil disinkronkan.'
        );
    }
}
