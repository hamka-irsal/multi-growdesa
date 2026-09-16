<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;


class BeritaController extends Controller
{
    public function index()
    {
        // Ambil semua data berita dari database
        $berita = Berita::all();

        // Kirim data ke view landing
        return view('landing.berita.index', compact('berita'));
    }

    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        return view('landing.berita.show', compact('berita'));
    }
}
