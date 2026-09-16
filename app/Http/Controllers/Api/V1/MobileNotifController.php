<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotifResource;
use App\Models\Berita;
use App\Models\Surat;
use App\Models\User;
use App\Models\NotificationHidden;

class MobileNotifController extends Controller
{
    /**
     * Menampilkan notifikasi mobile.
     *
     * Notifikasi terdiri dari:
     * - Berita: global, hanya 24 jam sejak tanggal_publish
     * - Surat: hanya milik penduduk/user yang login
     * - Verifikasi: hanya milik user yang login
     */
    public function index()
    {
        $user = auth('api')->user();

        /*
        |--------------------------------------------------------------------------
        | Validasi User
        |--------------------------------------------------------------------------
        */

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login.',
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil data penduduk user yang sedang login
        |--------------------------------------------------------------------------
        */

        $penduduk = $user->penduduk;

        /*
        |--------------------------------------------------------------------------
        | Ambil notifikasi yang sudah disembunyikan
        |--------------------------------------------------------------------------
        */

        $hidden = NotificationHidden::where('user_id', $user->id)
            ->get()
            ->groupBy('type')
            ->map(function ($items) {
                return $items->pluck('reference_id')->toArray();
            });

        /*
        |--------------------------------------------------------------------------
        | BERITA
        |--------------------------------------------------------------------------
        |
        | Berita bersifat global.
        |
        | Hanya berita yang:
        | - Dipublikasikan dalam 24 jam terakhir
        | - Tidak disembunyikan oleh user
        | - Tidak memiliki tanggal publikasi di masa depan
        |
        */

        $beritaHidden = $hidden->get('berita', []);

        $berita = Berita::with('category')
            ->whereNotIn('id', $beritaHidden)
            ->whereNotNull('tanggal_publish')
            ->where('tanggal_publish', '>=', now()->subHours(24))
            ->where('tanggal_publish', '<=', now())
            ->latest('tanggal_publish')
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SURAT
        |--------------------------------------------------------------------------
        |
        | Surat hanya boleh tampil untuk penduduk
        | yang dimiliki oleh user yang sedang login.
        |
        | Relasi:
        |
        | users.id
        |     ↓
        | penduduk.user_id
        |     ↓
        | penduduk.id
        |     ↓
        | surat.penduduk_id
        |
        */

        $suratHidden = $hidden->get('surat', []);

        $surat = collect();

        if ($penduduk) {
            $surat = Surat::with('jenisSurat')
                ->where('penduduk_id', $penduduk->id)
                ->whereNotIn('id', $suratHidden)
                ->whereIn('status_surat', [
                    'selesai',
                    'tolak',
                ])
                ->latest('updated_at')
                ->take(10)
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | VERIFIKASI AKUN
        |--------------------------------------------------------------------------
        |
        | Hanya mengambil status verifikasi user yang sedang login.
        |
        */

        $verifikasiHidden = $hidden->get('verifikasi', []);

        $verifikasi = User::where('id', $user->id)
            ->whereNotIn('id', $verifikasiHidden)
            ->whereIn('status_verifikasi', [
                'disetujui',
                'ditolak',
            ])
            ->latest('updated_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Gabungkan Data
        |--------------------------------------------------------------------------
        */

        $data = [
            'berita' => $berita,
            'surat' => $surat,
            'verifikasi' => $verifikasi,
        ];

        /*
        |--------------------------------------------------------------------------
        | Return Resource
        |--------------------------------------------------------------------------
        */

        return (new NotifResource($data))
            ->additional([
                'success' => true,
                'message' => 'List Data Notifikasi',
            ]);
    }


    /**
     * Hapus / sembunyikan semua notifikasi milik user.
     *
     * Data sumber tidak dihapus.
     * Hanya disimpan ke tabel notification_hidden.
     */
    public function destroyAll()
    {
        $user = auth('api')->user();

        /*
        |--------------------------------------------------------------------------
        | Validasi User
        |--------------------------------------------------------------------------
        */

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login.',
            ], 401);
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil data penduduk user
        |--------------------------------------------------------------------------
        */

        $penduduk = $user->penduduk;

        /*
        |--------------------------------------------------------------------------
        | Ambil berita yang masih aktif sebagai notifikasi
        |--------------------------------------------------------------------------
        |
        | Hanya berita yang dipublikasikan dalam 24 jam terakhir.
        |
        */

        $berita = Berita::whereNotNull('tanggal_publish')
            ->where('tanggal_publish', '>=', now()->subHours(24))
            ->where('tanggal_publish', '<=', now())
            ->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | Ambil surat milik user yang sedang login
        |--------------------------------------------------------------------------
        */

        $surat = collect();

        if ($penduduk) {
            $surat = Surat::where('penduduk_id', $penduduk->id)
                ->whereIn('status_surat', [
                    'selesai',
                    'tolak',
                ])
                ->pluck('id');
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil notifikasi verifikasi user yang sedang login
        |--------------------------------------------------------------------------
        */

        $verifikasi = User::where('id', $user->id)
            ->whereIn('status_verifikasi', [
                'disetujui',
                'ditolak',
            ])
            ->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | Siapkan data notification_hidden
        |--------------------------------------------------------------------------
        */

        $notifications = [];

        /*
        |--------------------------------------------------------------------------
        | Berita
        |--------------------------------------------------------------------------
        */

        foreach ($berita as $id) {
            $notifications[] = [
                'user_id' => $user->id,
                'type' => 'berita',
                'reference_id' => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Surat
        |--------------------------------------------------------------------------
        */

        foreach ($surat as $id) {
            $notifications[] = [
                'user_id' => $user->id,
                'type' => 'surat',
                'reference_id' => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Verifikasi
        |--------------------------------------------------------------------------
        */

        foreach ($verifikasi as $id) {
            $notifications[] = [
                'user_id' => $user->id,
                'type' => 'verifikasi',
                'reference_id' => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan tanpa duplikasi
        |--------------------------------------------------------------------------
        */

        if (!empty($notifications)) {
            NotificationHidden::insertOrIgnore($notifications);
        }

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi berhasil dibersihkan.',
        ], 200);
    }
}
