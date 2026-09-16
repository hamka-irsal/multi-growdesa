<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\Surat;
use App\Models\SuratKehilangan;
use App\Models\JenisSurat;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class SuratKehilanganController extends Controller
{
    public function formKehilangan(Request $request)
    {
        $nik = $request->query('nik'); // dari URL
        $penduduk = Penduduk::where('nik', $nik)->first();

        if (!$penduduk) {
            return redirect('/')->with('error', 'NIK tidak ditemukan.');
        }

        return view('landing.surat.kehilangan', compact('penduduk'));
    }

    public function simpanKehilangan(Request $request)
    {
        $request->validate([
            'nik' => 'required|exists:penduduk,nik',
            'barang_hilang' => 'required|string',
            'waktu_hilang' => 'required|date',
            'tempat_hilang' => 'required|string',
        ]);
    
        $penduduk = Penduduk::where('nik', $request->nik)->first();
        $jenis = JenisSurat::where('nama_jenis', 'Surat Keterangan Kehilangan')->first();
    
        if (!$jenis || !Schema::hasTable($jenis->nama_tabel)) {
            return redirect()->back()->with('error', 'Jenis surat tidak tersedia.');
        }
    
        $tanggalHariIni = Carbon::today();
    
        // Simpan surat utama
        $surat = Surat::create([
            'kode_unik' => Str::uuid(),
            'no_surat' => null, // bisa digenerate belakangan
            'nama_lengkap' => $penduduk->nama,
            'jenis_surat_id' => $jenis->id,
            'tanggal_pengajuan' => $tanggalHariIni,
            'tanggal_dibuat' => now(),
            'status_surat' => $request->status_surat ?? 'proses',
            'persetujuan' => null,
            'dibuat_oleh' => null, 
            'keterangan' => null,
            'file_surat' => null,
            'penduduk_id' => $penduduk->id,
        ]);
    
        // Simpan ke tabel kehilangan
        SuratKehilangan::create([
            'surat_id' => $surat->id,
            'penduduk_id' => $penduduk->id,
            'nama_lengkap' => $penduduk->nama,
            'barang_hilang' => $request->barang_hilang,
            'waktu_hilang' => $request->waktu_hilang,
            'tempat_hilang' => $request->tempat_hilang,
            'status_surat' => $request->status_surat ?? 'proses',
            'tanggal_pengajuan' => $tanggalHariIni,
            'tanggal_dibuat' => now(),
            'persetujuan' => null,
            'dibuat_oleh' => null,
            'keterangan' => null,
            'file_surat' => null,
        ]);
    
        if ($request->ajax()) {
            session()->flash('success', 'Permohonan surat kehilangan berhasil dibuat. Tunggu konfirmasi dari Aparat Desa');
            return response()->json(['success' => true, 'message' => 'Permohonan surat kehilangan berhasil dibuat.Tunggu konfirmasi dari Aparat Desa']);
        }

        // For non-AJAX requests
        return redirect()->route('landing.surat.index')->with('success', 'Permohonan surat kehilangan berhasil dibuat.Tunggu konfirmasi dari Aparat Desa');
    }
}