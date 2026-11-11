<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aparat;
use App\Models\Dusun;
use App\Models\Penduduk;
use App\Models\Produk;
use App\Models\Surat;

class DashboardController extends Controller
{
    /**
     * Mengambil desa_id dari akun yang sedang login.
     */
    private function currentDesaId(): int
    {
        $desaId = auth()->user()?->desa_id;

        abort_unless(
            $desaId,
            403,
            'Akun tidak terhubung dengan desa.'
        );

        return (int) $desaId;
    }


    public function index()
    {
        // ==================================================
        // DESA YANG SEDANG LOGIN
        // ==================================================

        $desaId = $this->currentDesaId();


        // ==================================================
        // 1. JUMLAH PENDUDUK
        // Hanya penduduk dari desa yang sedang login
        // dan akun user-nya sudah disetujui
        // ==================================================

        $jumlahPenduduk = Penduduk::where(
            'desa_id',
            $desaId
        )
            ->whereHas('user', function ($query) {
                $query->where(
                    'status_verifikasi',
                    'disetujui'
                );
            })
            ->count();


        // ==================================================
        // 2. JUMLAH SURAT
        // Hanya surat dari desa yang sedang login
        // ==================================================

        $jumlahSurat = Surat::where(
            'desa_id',
            $desaId
        )->count();


        // ==================================================
        // 3. SURAT SELESAI
        // ==================================================

        $suratSelesai = Surat::where(
            'desa_id',
            $desaId
        )
            ->where(
                'status_surat',
                'selesai'
            )
            ->count();


        // ==================================================
        // 4. SURAT DIPROSES
        // ==================================================

        $suratDiproses = Surat::where(
            'desa_id',
            $desaId
        )
            ->where(
                'status_surat',
                'proses'
            )
            ->count();


        // ==================================================
        // 5. SURAT DITOLAK
        // ==================================================

        $suratDitolak = Surat::where(
            'desa_id',
            $desaId
        )
            ->where(
                'status_surat',
                'tolak'
            )
            ->count();


        // ==================================================
        // 6. JUMLAH PRODUK
        // Hanya produk dari desa yang sedang login
        // ==================================================

        $jumlahProduk = Produk::where(
            'desa_id',
            $desaId
        )->count();


        // ==================================================
        // 7. JUMLAH APARAT
        // Hanya aparat dari desa yang sedang login
        // ==================================================

        $jumlahAparat = Aparat::where(
            'desa_id',
            $desaId
        )->count();


        // ==================================================
        // 8. JUMLAH DUSUN
        // Hanya dusun dari desa yang sedang login
        // ==================================================

        $jumlah_dusun = Dusun::where(
            'desa_id',
            $desaId
        )->count();


        // ==================================================
        // KIRIM DATA KE DASHBOARD
        // ==================================================

        return view(
            'admin.dashboard.index',
            compact(
                'jumlahPenduduk',
                'jumlahSurat',
                'suratSelesai',
                'suratDiproses',
                'suratDitolak',
                'jumlahProduk',
                'jumlahAparat',
                'jumlah_dusun'
            )
        );
    }
}