<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Penduduk;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // ==============================
        // BERITA
        // ==============================
        $berita = Berita::orderBy('tanggal_publish', 'desc')
            ->take(3)
            ->get();


        // ==============================
        // DATA KEPENDUDUKAN
        // ==============================

        // Total penduduk
        $totalPenduduk = Penduduk::count();

        // Total pria
        $totalPria = Penduduk::where('jenis_kelamin', 'Laki-laki')
            ->count();

        // Total wanita
        $totalWanita = Penduduk::where('jenis_kelamin', 'Perempuan')
            ->count();


        // ==============================
        // PERSENTASE
        // ==============================

        $persentasePria = $totalPenduduk > 0
            ? round(($totalPria / $totalPenduduk) * 100)
            : 0;

        $persentaseWanita = $totalPenduduk > 0
            ? round(($totalWanita / $totalPenduduk) * 100)
            : 0;


        // ==============================
        // DATA PEKERJAAN
        // ==============================

        $dataPekerjaan = Penduduk::select(
                'jenis_pekerjaan',
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('jenis_pekerjaan')
            ->where('jenis_pekerjaan', '!=', '')
            ->groupBy('jenis_pekerjaan')
            ->orderByDesc('total')
            ->get();


        return view('landing.home', compact(
            'berita',
            'totalPenduduk',
            'totalPria',
            'totalWanita',
            'persentasePria',
            'persentaseWanita',
            'dataPekerjaan'
        ));
    }
}
