<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;

class SuratController extends Controller
{
    public function index()
    {
        return view('landing.surat.index');
    }

    public function cekNIK(Request $request)
    {
        $nik = $request->input('nik');
        $penduduk = Penduduk::where('nik', $nik)->first();

        if ($penduduk) {
            return response()->json(['status' => 'valid']);
        } else {
            return response()->json(['status' => 'invalid']);
        }
    }
}