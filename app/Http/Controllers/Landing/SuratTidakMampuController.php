<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\Surat;
use App\Models\SuratTidakMampu;
use App\Models\JenisSurat;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class SuratTidakMampuController extends Controller
{
    public function formTidakMampu(Request $request)
    {
        $nik = $request->query('nik'); // dari URL
        $penduduk = Penduduk::where('nik', $nik)->first();

        if (!$penduduk) {
            return redirect('/')->with('error', 'NIK tidak ditemukan.');
        }

        return view('landing.surat.tidak_mampu', compact('penduduk'));
    }

    public function simpanTidakMampu(Request $request)
    {
        $request->validate([
            'nik' => 'required|exists:penduduk,nik',
            'keperluan' => 'required|string|max:255',
        ]);

        $penduduk = Penduduk::where('nik', $request->nik)->first();
        $jenis = JenisSurat::where('nama_jenis', 'Surat Keterangan Tidak Mampu')->first();

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

        // Simpan ke tabel surat tidak mampu
        SuratTidakMampu::create([
            'surat_id' => $surat->id,
            'penduduk_id' => $penduduk->id,
            'tanggal_pengajuan' => $tanggalHariIni,
            'tanggal_dibuat' => now(),
            'keperluan' => $request->keperluan,
        ]);

        // Use session flash for AJAX response
        if ($request->ajax()) {
            session()->flash('success', 'Permohonan surat keterangan tidak mampu berhasil dibuat. Tunggu konfirmasi dari Aparat Desa');
            return response()->json(['success' => true, 'message' => 'Permohonan surat keterangan tidak mampu berhasil dibuat.']);
        }

        // For non-AJAX requests
        return redirect()->route('landing.surat.index')->with('success', 'Permohonan surat keterangan tidak mampu berhasil dibuat. Tunggu konfirmasi dari Aparat Desa');
    }
}
