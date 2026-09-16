<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\Surat;
use App\Models\SuratUsaha; // Pastikan model ini sudah dibuat
use App\Models\JenisSurat;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class SuratUsahaController extends Controller
{
    public function formUsaha(Request $request)
    {
        $nik = $request->query('nik'); // dari URL
        $penduduk = Penduduk::where('nik', $nik)->first();

        if (!$penduduk) {
            return redirect('/')->with('error', 'NIK tidak ditemukan.');
        }

        return view('landing.surat.usaha', compact('penduduk'));
    }

    public function simpanUsaha(Request $request)
    {
        $request->validate([
            'nik' => 'required|exists:penduduk,nik',
            'jenis_usaha' => 'required|string|max:255',
            'tempat_usaha' => 'required|string|max:255',
            'tahun_berdiri' => 'required|numeric|min:1900|max:' . date('Y'),
        ]);

        $penduduk = Penduduk::where('nik', $request->nik)->first();
        $jenis = JenisSurat::where('nama_jenis', 'Surat Keterangan Usaha')->first();

        if (!$jenis || !Schema::hasTable($jenis->nama_tabel)) {
            return redirect()->back()->with('error', 'Jenis surat tidak tersedia.');
        }

        $tanggalHariIni = Carbon::today();

        // Simpan surat utama
        $surat = Surat::create([
            'kode_unik' => Str::uuid(),
            'no_surat' => null,
            'nama_lengkap' => $penduduk->nama_lengkap,
            'jenis_surat_id' => $jenis->id,
            'tanggal_pengajuan' => $tanggalHariIni,
            'tanggal_dibuat' => now(),
            'status_surat' => $request->status_surat ?? 'proses',
            'persetujuan' => null,
            'dibuat_oleh' => 'aparat',
            'keterangan' => null,
            'file_surat' => null,
            'penduduk_id' => $penduduk->id,
        ]);

        // Simpan ke tabel usaha
        SuratUsaha::create([
            'surat_id' => $surat->id,
            'penduduk_id' => $penduduk->id,
            'tanggal_pengajuan' => $tanggalHariIni,
            'tanggal_dibuat' => now(),
            'jenis_usaha' => $request->jenis_usaha,
            'tempat_usaha' => $request->tempat_usaha,
            'tahun_berdiri' => $request->tahun_berdiri,
        ]);

        // Use session flash for AJAX response
        if ($request->ajax()) {
            session()->flash('success', 'Permohonan surat keterangan usaha berhasil dibuat. Tunggu konfirmasi dari Aparat Desa');
            return response()->json(['success' => true, 'message' => 'Permohonan surat keterangan usaha berhasil dibuat.']);
        }

        // For non-AJAX requests
        return redirect()->route('landing.surat.index')->with('success', 'Permohonan surat keterangan usaha berhasil dibuat. Tunggu konfirmasi dari Aparat Desa');
    }
}