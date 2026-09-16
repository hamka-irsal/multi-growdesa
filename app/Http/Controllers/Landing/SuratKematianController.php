<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\Surat;
use App\Models\SuratKematian; // Pastikan model ini sudah dibuat
use App\Models\JenisSurat;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class SuratKematianController extends Controller
{
    public function formKematian(Request $request)
    {
        $nik = $request->query('nik'); // dari URL
        $penduduk = Penduduk::where('nik', $nik)->first();

        if (!$penduduk) {
            return redirect('/')->with('error', 'NIK tidak ditemukan.');
        }

        return view('landing.surat.kematian', compact('penduduk'));
    }

    public function simpanKematian(Request $request)
    {
        $request->validate([
            'nik' => 'required|exists:penduduk,nik',
            'tanggal' => 'required|date',
            'penyebab' => 'required|string',
            'tempat' => 'required|string',
        ]);

        $penduduk = Penduduk::where('nik', $request->nik)->first();
        $jenis = JenisSurat::where('nama_jenis', 'Surat Keterangan Kematian')->first();

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

        // Simpan ke tabel kematian
        SuratKematian::create([
            'surat_id' => $surat->id,
            'penduduk_id' => $penduduk->id,
            'tanggal_pengajuan' => $tanggalHariIni,
            'tanggal_dibuat' => now(),
            'tanggal' => $request->tanggal,
            'penyebab' => $request->penyebab,
            'tempat' => $request->tempat,
        ]);

        // Use session flash for AJAX response
        if ($request->ajax()) {
            session()->flash('success', 'Permohonan surat kematian berhasil dibuat. Tunggu konfirmasi dari Aparat Desa');
            return response()->json(['success' => true, 'message' => 'Permohonan surat kematian berhasil dibuat. Tunggu konfirmasi dari Aparat Desa']);
        }

        // For non-AJAX requests
        return redirect()->route('landing.surat.index')->with('success', 'Permohonan surat kematian berhasil dibuat. Tunggu konfirmasi dari Aparat Desa');
    }
}
