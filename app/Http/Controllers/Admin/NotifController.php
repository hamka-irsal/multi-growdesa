<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotifController extends Controller
{
    /**
     * Mengambil jumlah notifikasi.
     *
     * Digunakan untuk badge 🔔 pada navbar.
     *
     * Notifikasi:
     * 1. Surat dengan status proses
     * 2. Akun penduduk dengan status verifikasi pending
     */
    public function count()
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | Jumlah Surat Masuk
            |--------------------------------------------------------------------------
            */

            $jumlahSurat = Surat::where(
                'status_surat',
                'proses'
            )->count();


            /*
            |--------------------------------------------------------------------------
            | Jumlah Akun Menunggu Verifikasi
            |--------------------------------------------------------------------------
            */

            $jumlahVerifikasi = User::where(
                'status_verifikasi',
                'pending'
            )
                ->where(
                    'role',
                    'penduduk'
                )
                ->count();


            /*
            |--------------------------------------------------------------------------
            | Total Notifikasi
            |--------------------------------------------------------------------------
            */

            $total =
                $jumlahSurat +
                $jumlahVerifikasi;


            return response()->json([
                'success' => true,

                'data' => [
                    'surat' =>
                        $jumlahSurat,

                    'verifikasi' =>
                        $jumlahVerifikasi,

                    'total' =>
                        $total,
                ],
            ]);

        } catch (\Throwable $e) {

            Log::error(
                'Kesalahan saat mengambil jumlah notifikasi',
                [
                    'message' =>
                        $e->getMessage(),

                    'file' =>
                        $e->getFile(),

                    'line' =>
                        $e->getLine(),
                ]
            );


            return response()->json([
                'success' => false,

                'message' =>
                    'Gagal mengambil jumlah notifikasi.',

                'data' => [
                    'surat' => 0,

                    'verifikasi' => 0,

                    'total' => 0,
                ],
            ], 500);
        }
    }


    /**
     * Mengambil 10 notifikasi terbaru.
     *
     * Digunakan untuk dropdown notifikasi navbar.
     */
    public function latest()
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | Surat Masuk
            |--------------------------------------------------------------------------
            |
            | Hanya surat yang masih dalam proses
            | yang ditampilkan sebagai notifikasi.
            |
            */

            $surat = Surat::with([
                'penduduk',
                'jenisSurat',
            ])
                ->where(
                    'status_surat',
                    'proses'
                )
                ->latest('created_at')
                ->take(10)
                ->get();


            /*
            |--------------------------------------------------------------------------
            | Akun Menunggu Verifikasi
            |--------------------------------------------------------------------------
            */

            $verifikasi = User::with([
                'penduduk',
            ])
                ->where(
                    'status_verifikasi',
                    'pending'
                )
                ->where(
                    'role',
                    'penduduk'
                )
                ->latest('created_at')
                ->take(10)
                ->get();


            /*
            |--------------------------------------------------------------------------
            | Collection Notifikasi
            |--------------------------------------------------------------------------
            */

            $notifikasi = collect();


            /*
            |--------------------------------------------------------------------------
            | NOTIFIKASI SURAT
            |--------------------------------------------------------------------------
            */

            foreach ($surat as $item) {

                /*
                |--------------------------------------------------------------------------
                | Nama Pemohon
                |--------------------------------------------------------------------------
                */

                $namaPemohon =
                    $item->nama_lengkap;


                /*
                | Jika nama_lengkap pada surat kosong,
                | ambil dari relasi penduduk.
                */

                if (
                    empty($namaPemohon) &&
                    $item->penduduk
                ) {

                    $namaPemohon =
                        $item->penduduk->nama_lengkap
                        ?? $item->penduduk->nama
                        ?? 'Penduduk';
                }


                /*
                |--------------------------------------------------------------------------
                | Nama Jenis Surat
                |--------------------------------------------------------------------------
                */

                $namaJenisSurat =
                    'Pengajuan Surat Baru';


                if ($item->jenisSurat) {

                    $namaJenisSurat =
                        $item->jenisSurat->nama
                        ?? $item->jenisSurat->nama_surat
                        ?? $item->jenisSurat->jenis_surat
                        ?? 'Pengajuan Surat Baru';
                }


                /*
                |--------------------------------------------------------------------------
                | Tambahkan ke collection
                |--------------------------------------------------------------------------
                */

                $notifikasi->push([

                    'id' =>
                        $item->id,

                    'tipe' =>
                        'surat',

                    'judul' =>
                        $namaJenisSurat,

                    'pesan' =>
                        'Pengajuan surat dari ' .
                        ($namaPemohon ?: 'Penduduk'),

                    'nama' =>
                        $namaPemohon
                        ?: 'Penduduk',

                    'kode_unik' =>
                        $item->kode_unik,

                    'no_surat' =>
                        $item->no_surat,

                    'status' =>
                        $item->status_surat,

                    'tanggal' =>
                        $item->tanggal_pengajuan
                        ?? $item->created_at,

                    'created_at' =>
                        $item->created_at,

                    /*
                    |--------------------------------------------------------------------------
                    | Klik notifikasi surat
                    |--------------------------------------------------------------------------
                    |
                    | Langsung menuju halaman pengajuan surat.
                    |
                    */

                    'url' =>
                        route(
                            'admin.surat.pengajuan'
                        ),

                    'aksi' =>
                        'Lihat Pengajuan',

                    'icon' =>
                        'fas fa-envelope',

                    'warna' =>
                        'primary',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | NOTIFIKASI VERIFIKASI AKUN
            |--------------------------------------------------------------------------
            */

            foreach ($verifikasi as $item) {

                /*
                |--------------------------------------------------------------------------
                | Nama Penduduk
                |--------------------------------------------------------------------------
                */

                $namaPenduduk =
                    null;


                if ($item->penduduk) {

                    $namaPenduduk =
                        $item->penduduk->nama_lengkap
                        ?? $item->penduduk->nama
                        ?? null;
                }


                /*
                |--------------------------------------------------------------------------
                | Jika data penduduk tidak memiliki nama,
                | gunakan nama dari tabel users.
                |--------------------------------------------------------------------------
                */

                $namaPenduduk =
                    $namaPenduduk
                    ?? $item->name
                    ?? 'Penduduk';


                /*
                |--------------------------------------------------------------------------
                | NIK
                |--------------------------------------------------------------------------
                */

                $nik =
                    $item->nik;


                if (
                    empty($nik) &&
                    $item->penduduk
                ) {

                    $nik =
                        $item->penduduk->nik
                        ?? null;
                }


                /*
                |--------------------------------------------------------------------------
                | Tambahkan notifikasi
                |--------------------------------------------------------------------------
                */

                $notifikasi->push([

                    'id' =>
                        $item->id,

                    'tipe' =>
                        'verifikasi',

                    'judul' =>
                        'Verifikasi Akun',

                    'pesan' =>
                        'Akun ' .
                        $namaPenduduk .
                        ' menunggu verifikasi.',

                    'nama' =>
                        $namaPenduduk,

                    'email' =>
                        $item->email,

                    'nik' =>
                        $nik,

                    'status' =>
                        $item->status_verifikasi,

                    'tanggal' =>
                        $item->created_at,

                    'created_at' =>
                        $item->created_at,

                    /*
                    |--------------------------------------------------------------------------
                    | Klik notifikasi verifikasi
                    |--------------------------------------------------------------------------
                    |
                    | Langsung menuju halaman verifikasi.
                    |
                    */

                    'url' =>
                        route(
                            'admin.verifikasi.index'
                        ),

                    'aksi' =>
                        'Verifikasi Akun',

                    'icon' =>
                        'fas fa-user-check',

                    'warna' =>
                        'warning',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Urutkan Semua Notifikasi
            |--------------------------------------------------------------------------
            */

            $notifikasi = $notifikasi
                ->sortByDesc(
                    'created_at'
                )
                ->values()
                ->take(10);


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' => true,

                'data' =>
                    $notifikasi,

                'total' =>
                    $notifikasi->count(),
            ]);

        } catch (\Throwable $e) {

            Log::error(
                'Kesalahan saat mengambil notifikasi terbaru',
                [
                    'message' =>
                        $e->getMessage(),

                    'file' =>
                        $e->getFile(),

                    'line' =>
                        $e->getLine(),
                ]
            );


            return response()->json([

                'success' => false,

                'message' =>
                    'Gagal mengambil notifikasi terbaru.',

                'data' => [],

                'total' => 0,

            ], 500);
        }
    }
}
