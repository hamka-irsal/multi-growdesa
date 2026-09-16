<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\Surat;
use App\Models\SuratPotong; // Pastikan model ini sudah dibuat
use App\Models\JenisSurat;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class SuratPotongHewanController extends Controller
{
    public function formPotongHewan(Request $request)
    {
        $nik = $request->query('nik'); // dari URL
        $penduduk = Penduduk::where('nik', $nik)->first();

        if (!$penduduk) {
            return redirect('/')->with('error', 'NIK tidak ditemukan.');
        }

        return view('landing.surat.potong_hewan', compact('penduduk'));
    }

    public function simpanPotongHewan(Request $request)
    {
        $request->validate([
            'nik' => 'required|exists:penduduk,nik',
            'untuk' => 'required|string|max:255',
            'jenis_hewan' => 'required|string|max:255',
            'warna_bulu' => 'required|string|max:255',
            'tanduk' => 'required|string|max:255',
        ]);

        $penduduk = Penduduk::where('nik', $request->nik)->first();
        $jenis = JenisSurat::where('nama_jenis', 'Surat Izin Potong')->first();

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

        // Simpan ke tabel potong hewan
        SuratPotong::create([
            'surat_id' => $surat->id,
            'penduduk_id' => $penduduk->id,
            'tanggal_pengajuan' => $tanggalHariIni,
            'tanggal_dibuat' => now(),
            'untuk' => $request->untuk,
            'jenis_hewan' => $request->jenis_hewan,
            'warna_bulu' => $request->warna_bulu,
            'tanduk' => $request->tanduk,
        ]);

        // Use session flash for AJAX response
        if ($request->ajax()) {
            session()->flash('success', 'Permohonan surat keterangan potong hewan berhasil dibuat. Tunggu konfirmasi dari Aparat Desa');
            return response()->json(['success' => true, 'message' => 'Permohonan surat keterangan potong hewan berhasil dibuat.']);
        }

        // For non-AJAX requests
        return redirect()->route('landing.surat.index')->with('success', 'Permohonan surat keterangan potong hewan berhasil dibuat. Tunggu konfirmasi dari Aparat Desa');
    }
}