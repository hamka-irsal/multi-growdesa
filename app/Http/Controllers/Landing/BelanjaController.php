<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class BelanjaController extends Controller
{
    public function index()
    {
        // Ambil semua data produk dari database
        $produk = Produk::all();

        // Kirim data ke view landing
        return view('landing.belanja.index', compact('produk'));
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('landing.belanja.show', compact('produk'));
    }
}
