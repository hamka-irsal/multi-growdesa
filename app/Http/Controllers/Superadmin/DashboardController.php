<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Aparat;
use App\Models\Dusun;
use App\Models\Penduduk;
use App\Models\Produk;
use App\Models\Surat;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ==================================================
        // 1. JUMLAH PENDUDUK
        // Hanya penduduk yang akun user-nya sudah disetujui
        // ==================================================

        $jumlahPenduduk = Penduduk::whereHas('user', function ($query) {
            $query->where('status_verifikasi', 'disetujui');
        })->count();


        // ==================================================
        // 2. JUMLAH SURAT
        // Semua status surat
        // ==================================================

        $jumlahSurat = Surat::count();


        // ==================================================
        // 3. SURAT SELESAI
        // ==================================================

        $suratSelesai = Surat::where(
            'status_surat',
            'selesai'
        )->count();


        // ==================================================
        // 4. SURAT DIPROSES
        // ==================================================

        $suratDiproses = Surat::where(
            'status_surat',
            'proses'
        )->count();


        // ==================================================
        // 5. SURAT DITOLAK
        // ==================================================

        $suratDitolak = Surat::where(
            'status_surat',
            'tolak'
        )->count();


        // ==================================================
        // 6. JUMLAH PRODUK
        // ==================================================

        $jumlahProduk = Produk::count();


        // ==================================================
        // 7. JUMLAH APARAT
        // ==================================================

        $jumlahAparat = Aparat::count();


        // ==================================================
        // 8. JUMLAH DUSUN
        // Dihitung langsung dari tabel dusun
        // ==================================================

        $jumlah_dusun = Dusun::count();


        // ==================================================
        // KIRIM DATA KE DASHBOARD
        // ==================================================

        return view(
            'superadmin.dashboard.index',
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
