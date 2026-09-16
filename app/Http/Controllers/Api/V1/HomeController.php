<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Berita;
use App\Models\Iklan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HomeResource;

class HomeController extends Controller
{
    /**
     * Menampilkan data untuk halaman beranda.
     */
    public function __invoke(Request $request)
    {
        // Ambil maksimal 5 iklan yang aktif
        $iklans = Iklan::query()
            ->where('is_active', true)
            ->latest()
            ->take(5)
            ->get();

        // Ambil 5 berita terbaru beserta kategorinya
        $beritaTerbaru = Berita::query()
            ->with('category')
            ->latest('tanggal_publish')
            ->take(5)
            ->get();

        return new HomeResource([
            'iklans' => $iklans,
            'berita_terbaru' => $beritaTerbaru,
        ]);
    }
}
