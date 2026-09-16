<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\Surat;
use Illuminate\Support\Facades\Log;


class RiwayatSuratController extends Controller
{
    public function index()
    {
        return view('landing.riwayat.index'); // halaman input NIK
    }

    public function cekRiwayat(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16'
        ]);
        return redirect()->route('landing.riwayat.show', ['nik' => $request->nik]);
    }

    public function showRiwayat($nik)
    {
        $penduduk = Penduduk::where('nik', $nik)->first();

        if (!$penduduk) {
            return back()->with('error', 'NIK tidak ditemukan.');
        }

        $surat = $penduduk->surat()->get();

        return view('landing.riwayat.show', [
            'nik' => $nik,
            'surat' => $surat,
        ]);
    }

    public function cetak($id)
    {
        try {
            // Tambahkan logging di awal untuk tracking
            Log::info('Memulai proses cetak surat dengan ID: ' . $id);

            // Ambil surat berdasarkan ID
            $surat = \App\Models\Surat::with(['penduduk', 'jenisSurat.persetujuan'])->find($id);

            // Jika surat tidak ditemukan, tampilkan halaman error khusus alih-alih redirect
            if (!$surat) {
                Log::warning('Surat dengan ID ' . $id . ' tidak ditemukan');
                return response()->view('errors.custom', [
                    'message' => 'Data surat dengan ID tersebut tidak ditemukan.'
                ], 404);
            }

            // Cek jenis surat
            if (!$surat->jenisSurat) {
                Log::warning('Jenis surat untuk ID ' . $id . ' tidak tersedia');
                return response()->view('errors.custom', [
                    'message' => 'Jenis surat tidak ditemukan dalam relasi.'
                ], 404);
            }

            // Ambil persetujuan, tapi jangan redirect jika tidak ada
            $persetujuan = optional($surat->jenisSurat->persetujuan)->first();

            // Ambil informasi wilayah dari penduduk (jika tersedia)
            $kabupaten = $surat->penduduk->kabupaten ?? 'Kabupaten Default';
            $kecamatan = $surat->penduduk->kecamatan ?? 'Kecamatan Default';
            $desa = $surat->penduduk->desa ?? 'Desa Default';

            // Pastikan nama jenis surat cocok
            $namaJenis = $surat->jenisSurat->nama_jenis;

            // Switch case seperti sebelumnya, tapi ubah penanganan error
            switch ($namaJenis) {
                case 'Surat Keterangan Kehilangan':
                    $detail = \App\Models\SuratKehilangan::where('surat_id', $surat->id)->first();

                    // Jika detail tidak ditemukan, tetap lanjutkan dengan detail kosong
                    if (!$detail) {
                        Log::warning('Detail surat kehilangan untuk ID ' . $id . ' tidak ditemukan');
                        $detail = new \stdClass(); // Buat objek kosong
                    }

                    // Set properti yang diperlukan
                    $detail->kabupaten_kota = $kabupaten;
                    $detail->kecamatan = $kecamatan;
                    $detail->desa_kelurahan = $desa;
                    $detail->penduduk = $surat->penduduk;
                    $detail->tanggal_dibuat = now()->translatedFormat('d F Y');

                    $viewName = 'landing.riwayat.cetak.kehilangan';

                    // Jika view tidak ada, buat view sederhana
                    if (!view()->exists($viewName)) {
                        Log::error("View $viewName tidak ditemukan");
                        return response()->view('errors.custom', [
                            'message' => "Template view untuk $namaJenis tidak ditemukan."
                        ], 404);
                    }

                    Log::info('Rendering view ' . $viewName);
                    return view($viewName, compact('surat', 'detail', 'persetujuan'));

                case 'Surat Keterangan Kematian':
                    $detail = \App\Models\SuratKematian::where('surat_id', $surat->id)->first();

                    // Jika detail tidak ditemukan, tetap lanjutkan dengan detail kosong
                    if (!$detail) {
                        Log::warning('Detail surat kematian untuk ID ' . $id . ' tidak ditemukan');
                        $detail = new \stdClass(); // Buat objek kosong

                        // Set default values untuk menghindari error di view
                        $detail->tanggal_meninggal = now()->translatedFormat('d F Y');
                        $detail->penyebab_meninggal = 'Tidak diketahui';
                        $detail->tempat_meninggal = 'Tidak diketahui';
                    }

                    // Format tanggal meninggal jika tersedia
                    if (isset($detail->tanggal_meninggal) && !is_string($detail->tanggal_meninggal)) {
                        $detail->tanggal_meninggal = \Carbon\Carbon::parse($detail->tanggal_meninggal)
                            ->translatedFormat('d F Y');
                    }

                    // Set properti yang diperlukan
                    $detail->kabupaten_kota = $kabupaten;
                    $detail->kecamatan = $kecamatan;
                    $detail->desa_kelurahan = $desa;
                    $detail->penduduk = $surat->penduduk;
                    $detail->tanggal_dibuat = now()->translatedFormat('d F Y');

                    // Tambahkan logging khusus untuk data kematian
                    Log::info('Data Surat Kematian:', [
                        'surat_id' => $surat->id,
                        'detail_id' => $detail->id ?? 'null',
                        'tanggal_meninggal' => $detail->tanggal_meninggal ?? 'null',
                        'penyebab_meninggal' => $detail->penyebab_meninggal ?? 'null',
                        'tempat_meninggal' => $detail->tempat_meninggal ?? 'null'
                    ]);

                    $viewName = 'landing.riwayat.cetak.kematian';

                    // Jika view tidak ada, buat view sederhana
                    if (!view()->exists($viewName)) {
                        Log::error("View $viewName tidak ditemukan");
                        return response()->view('errors.custom', [
                            'message' => "Template view untuk $namaJenis tidak ditemukan."
                        ], 404);
                    }

                    Log::info('Rendering view ' . $viewName);
                    return view($viewName, compact('surat', 'detail', 'persetujuan'));

                    // Tambahkan case ini di dalam switch statement pada fungsi cetak()
                case 'Surat Keterangan Usaha':
                    $detail = \App\Models\SuratUsaha::where('surat_id', $surat->id)->first();

                    // Jika detail tidak ditemukan, tetap lanjutkan dengan detail kosong
                    if (!$detail) {
                        Log::warning('Detail surat usaha untuk ID ' . $id . ' tidak ditemukan');
                        $detail = new \stdClass(); // Buat objek kosong

                        // Set default values untuk menghindari error di view
                        $detail->jenis_usaha = 'Tidak diketahui';
                        $detail->tempat_usaha = 'Tidak diketahui';
                        $detail->tahun_berdiri = date('Y');
                    }

                    // Set properti yang diperlukan
                    $detail->kabupaten_kota = $kabupaten;
                    $detail->kecamatan = $kecamatan;
                    $detail->desa_kelurahan = $desa;
                    $detail->penduduk = $surat->penduduk;
                    $detail->tanggal_dibuat = now()->translatedFormat('d F Y');

                    // Tambahkan logging khusus untuk data usaha
                    Log::info('Data Surat Keterangan Usaha:', [
                        'surat_id' => $surat->id,
                        'detail_id' => $detail->id ?? 'null',
                        'jenis_usaha' => $detail->jenis_usaha ?? 'null',
                        'tempat_usaha' => $detail->tempat_usaha ?? 'null',
                        'tahun_berdiri' => $detail->tahun_berdiri ?? 'null'
                    ]);

                    $viewName = 'landing.riwayat.cetak.usaha';

                    // Jika view tidak ada, buat view sederhana
                    if (!view()->exists($viewName)) {
                        Log::error("View $viewName tidak ditemukan");
                        return response()->view('errors.custom', [
                            'message' => "Template view untuk $namaJenis tidak ditemukan."
                        ], 404);
                    }

                    Log::info('Rendering view ' . $viewName);
                    return view($viewName, compact('surat', 'detail', 'persetujuan'));

                case 'Surat Keterangan Tidak Mampu':
                    $detail = \App\Models\SuratTidakMampu::where('surat_id', $surat->id)->first();

                    // Jika detail tidak ditemukan, tetap lanjutkan dengan detail kosong
                    if (!$detail) {
                        Log::warning('Detail surat tidak mampu untuk ID ' . $id . ' tidak ditemukan');
                        $detail = new \stdClass(); // Buat objek kosong

                        // Set default values untuk menghindari error di view
                        $detail->keperluan = 'Tidak diketahui';
                    }

                    // Set properti yang diperlukan
                    $detail->kabupaten_kota = $kabupaten;
                    $detail->kecamatan = $kecamatan;
                    $detail->desa_kelurahan = $desa;
                    $detail->penduduk = $surat->penduduk;
                    $detail->tanggal_dibuat = now()->translatedFormat('d F Y');

                    // Tambahkan logging khusus untuk data surat tidak mampu
                    Log::info('Data Surat Keterangan Tidak Mampu:', [
                        'surat_id' => $surat->id,
                        'detail_id' => $detail->id ?? 'null',
                        'keperluan' => $detail->keperluan ?? 'null'
                    ]);

                    $viewName = 'landing.riwayat.cetak.tidak_mampu';

                    // Jika view tidak ada, buat view sederhana
                    if (!view()->exists($viewName)) {
                        Log::error("View $viewName tidak ditemukan");
                        return response()->view('errors.custom', [
                            'message' => "Template view untuk $namaJenis tidak ditemukan."
                        ], 404);
                    }

                    Log::info('Rendering view ' . $viewName);
                    return view($viewName, compact('surat', 'detail', 'persetujuan'));

                    //case surat potong
                case 'Surat Izin Potong':
                    $detail = \App\Models\SuratPotong::where('surat_id', $surat->id)->first();

                    // Jika detail tidak ditemukan, tetap lanjutkan dengan detail kosong
                    if (!$detail) {
                        Log::warning('Detail surat izin potong untuk ID ' . $id . ' tidak ditemukan');
                        $detail = new \stdClass(); // Buat objek kosong

                        // Set default values untuk menghindari error di view
                        $detail->untuk = 'Tidak diketahui';
                        $detail->jenis_hewan = 'Tidak diketahui';
                        $detail->warna_bulu = 'Tidak diketahui';
                        $detail->tanduk = 'Tidak diketahui';
                    }

                    // Set properti yang diperlukan
                    $detail->kabupaten_kota = $kabupaten;
                    $detail->kecamatan = $kecamatan;
                    $detail->desa_kelurahan = $desa;
                    $detail->penduduk = $surat->penduduk;
                    $detail->tanggal_dibuat = now()->translatedFormat('d F Y');

                    // Tambahkan logging khusus untuk data surat izin potong
                    Log::info('Data Surat Izin Potong:', [
                        'surat_id' => $surat->id,
                        'detail_id' => $detail->id ?? 'null',
                        'untuk' => $detail->untuk ?? 'null',
                        'jenis_hewan' => $detail->jenis_hewan ?? 'null',
                        'warna_bulu' => $detail->warna_bulu ?? 'null',
                        'tanduk' => $detail->tanduk ?? 'null'
                    ]);

                    $viewName = 'landing.riwayat.cetak.potong_hewan';

                    // Jika view tidak ada, buat view sederhana
                    if (!view()->exists($viewName)) {
                        Log::error("View $viewName tidak ditemukan");
                        return response()->view('errors.custom', [
                            'message' => "Template view untuk $namaJenis tidak ditemukan."
                        ], 404);
                    }

                    Log::info('Rendering view ' . $viewName);
                    return view($viewName, compact('surat', 'detail', 'persetujuan'));

                case 'Surat Izin Pesta':
                    $detail = \App\Models\SuratPesta::where('surat_id', $surat->id)->first();

                    // Jika detail tidak ditemukan, tetap lanjutkan dengan detail kosong
                    if (!$detail) {
                        Log::warning('Detail surat izin pesta untuk ID ' . $id . ' tidak ditemukan');
                        $detail = new \stdClass(); // Buat objek kosong

                        // Set default values untuk menghindari error di view
                        $detail->untuk = 'Tidak diketahui';
                    }

                    // Set properti yang diperlukan
                    $detail->kabupaten_kota = $kabupaten;
                    $detail->kecamatan = $kecamatan;
                    $detail->desa_kelurahan = $desa;
                    $detail->penduduk = $surat->penduduk;
                    $detail->tanggal_dibuat = now()->translatedFormat('d F Y');

                    // Tambahkan logging khusus untuk data surat izin pesta
                    Log::info('Data Surat Izin Pesta:', [
                        'surat_id' => $surat->id,
                        'detail_id' => $detail->id ?? 'null',
                        'untuk' => $detail->untuk ?? 'null'
                    ]);

                    $viewName = 'landing.riwayat.cetak.pesta';

                    // Jika view tidak ada, buat view sederhana
                    if (!view()->exists($viewName)) {
                        Log::error("View $viewName tidak ditemukan");
                        return response()->view('errors.custom', [
                            'message' => "Template view untuk $namaJenis tidak ditemukan."
                        ], 404);
                    }

                    Log::info('Rendering view ' . $viewName);
                    return view($viewName, compact('surat', 'detail', 'persetujuan'));


                default:
                    // Cek apakah view ada untuk jenis ini secara dinamis
                    $viewName = 'landing.riwayat.cetak.' . strtolower(str_replace(' ', '_', $namaJenis));

                    // Log untuk debugging
                    Log::info("Mencoba mencari view: $viewName");

                    if (view()->exists($viewName)) {
                        // Coba dapatkan kelas model secara dinamis
                        $modelClass = '\\App\\Models\\Surat' . str_replace(' ', '', $namaJenis);

                        Log::info("Mencoba mencari model: $modelClass");

                        if (class_exists($modelClass)) {
                            $detail = $modelClass::where('surat_id', $surat->id)->first();

                            // Jika detail tidak ditemukan, tetap lanjutkan dengan detail kosong
                            if (!$detail) {
                                Log::warning("Detail untuk $namaJenis dengan surat ID $id tidak ditemukan");
                                $detail = new \stdClass(); // Buat objek kosong
                            }

                            // Set properti yang diperlukan
                            $detail->kabupaten_kota = $kabupaten;
                            $detail->kecamatan = $kecamatan;
                            $detail->desa_kelurahan = $desa;
                            $detail->penduduk = $surat->penduduk;
                            $detail->tanggal_dibuat = now()->translatedFormat('d F Y');

                            Log::info("Rendering view dinamis: $viewName");
                            return view($viewName, compact('surat', 'detail', 'persetujuan'));
                        } else {
                            Log::error("Model $modelClass tidak ditemukan");
                            return response()->view('errors.custom', [
                                'message' => "Model untuk jenis surat $namaJenis tidak ditemukan."
                            ], 404);
                        }
                    } else {
                        Log::error("View $viewName tidak ditemukan");
                        return response()->view('errors.custom', [
                            'message' => 'Jenis surat "' . $namaJenis . '" belum didukung dalam sistem cetak.'
                        ], 404);
                    }
            }
        } catch (\Exception $e) {
            // Tampilkan error di halaman baru, bukan redirect
            Log::error('Error saat mencetak surat: ' . $e->getMessage());
            Log::error('File: ' . $e->getFile() . ', Line: ' . $e->getLine());
            Log::error($e->getTraceAsString());

            return response()->view('errors.custom', [
                'message' => 'Terjadi kesalahan saat mencetak surat: ' . $e->getMessage()
            ], 500);
        }
    }
}
