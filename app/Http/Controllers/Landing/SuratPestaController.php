<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\Surat;
use App\Models\JenisSurat;
use App\Models\SuratPesta;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SuratPestaController extends Controller
{
    public function formPesta()
    {
        $nik = request()->query('nik'); // ambil NIK dari URL
        $penduduk = Penduduk::where('nik', $nik)->first();

        if (!$penduduk) {
            return redirect('/')->with('error', 'NIK tidak ditemukan.');
        }

        return view('landing.surat.pesta', compact('penduduk'));
    }

    public function simpanPesta(Request $request)
    {
        $request->validate([
            'nik' => 'required|exists:penduduk,nik',
            'untuk' => 'required|string|max:255',
        ]);

        $penduduk = Penduduk::where('nik', $request->nik)->first();
        $jenis = JenisSurat::where('nama_jenis', 'Surat Izin Pesta')->first();

        if (!$jenis || !Schema::hasTable($jenis->nama_tabel)) {
            return redirect()->back()->with('error', 'Jenis surat tidak tersedia.');
        }

        $tanggalHariIni = Carbon::today();

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

        SuratPesta::create([
            'surat_id' => $surat->id,
            'penduduk_id' => $penduduk->id,
            'tanggal_pengajuan' => $tanggalHariIni,
            'tanggal_dibuat' => now(),
            'untuk' => $request->untuk,
        ]);

        if ($request->ajax()) {
            session()->flash('success', 'Permohonan surat pesta berhasil dibuat. Tunggu konfirmasi dari Aparat Desa.');
            return response()->json(['success' => true, 'message' => 'Permohonan surat pesta berhasil dibuat.']);
        }

        return redirect()->route('landing.surat.index')->with('success', 'Permohonan surat pesta berhasil dibuat. Tunggu konfirmasi dari Aparat Desa.');
    }
}