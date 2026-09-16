<?php

namespace App\Http\Controllers\Anjungan;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\Surat;
use Illuminate\Http\Request;

class RiwayatSuratController extends Controller
{
    /**
     * Memproses NIK atau Email untuk melihat riwayat surat.
     */
    public function cekRiwayat(Request $request)
    {
        $request->validate([
            'identifier' => [
                'required',
                function ($attribute, $value, $fail) {
                    $value = trim($value);

                    // Jika 16 digit, dianggap NIK
                    if (preg_match('/^\d{16}$/', $value)) {
                        return;
                    }

                    // Jika bukan NIK, harus berupa email
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail('Masukkan NIK 16 digit atau alamat email yang valid.');
                    }
                },
            ],
        ]);

        return redirect()->route(
            'anjungan.riwayat.show',
            [
                'identifier' => trim($request->identifier),
            ]
        );
    }


    /**
     * Mengecek NIK atau Email melalui AJAX.
     */
    public function cekIdentitas(Request $request)
    {
        $request->validate([
            'identifier' => [
                'required',
                function ($attribute, $value, $fail) {
                    $value = trim($value);

                    if (
                        !preg_match('/^\d{16}$/', $value) &&
                        !filter_var($value, FILTER_VALIDATE_EMAIL)
                    ) {
                        $fail('Masukkan NIK 16 digit atau email yang valid.');
                    }
                },
            ],
        ]);

        $identifier = trim($request->identifier);

        /*
        |--------------------------------------------------------------------------
        | Jika input berupa NIK
        |--------------------------------------------------------------------------
        */

        if (preg_match('/^\d{16}$/', $identifier)) {

            $penduduk = Penduduk::where(
                'nik',
                $identifier
            )->first();

        } else {

            /*
            |--------------------------------------------------------------------------
            | Jika input berupa Email
            | Email diambil dari tabel users melalui relasi penduduk -> user
            |--------------------------------------------------------------------------
            */

            $penduduk = Penduduk::whereHas(
                'user',
                function ($query) use ($identifier) {
                    $query->where(
                        'email',
                        $identifier
                    );
                }
            )->first();
        }


        if ($penduduk) {
            return response()->json([
                'status' => 'valid',
                'message' => 'Data ditemukan.',
            ]);
        }


        return response()->json([
            'status' => 'invalid',
            'message' => 'NIK atau email tidak ditemukan.',
        ]);
    }


    /**
     * Menampilkan seluruh riwayat surat berdasarkan NIK atau Email.
     */
    public function showRiwayat($identifier)
    {
        /*
        |--------------------------------------------------------------------------
        | Cari Penduduk berdasarkan NIK atau Email
        |--------------------------------------------------------------------------
        */

        if (preg_match('/^\d{16}$/', $identifier)) {

            // Cari berdasarkan NIK
            $penduduk = Penduduk::with('user')
                ->where(
                    'nik',
                    $identifier
                )
                ->first();

        } else {

            // Cari berdasarkan Email pada tabel users
            $penduduk = Penduduk::with('user')
                ->whereHas(
                    'user',
                    function ($query) use ($identifier) {
                        $query->where(
                            'email',
                            $identifier
                        );
                    }
                )
                ->first();
        }


        /*
        |--------------------------------------------------------------------------
        | Jika Penduduk tidak ditemukan
        |--------------------------------------------------------------------------
        */

        if (!$penduduk) {
            return redirect()
                ->route('anjungan.riwayat.index')
                ->with(
                    'error',
                    'NIK atau email tidak ditemukan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil seluruh riwayat surat penduduk
        |--------------------------------------------------------------------------
        */

        $surat = Surat::with(
            'jenisSurat'
        )
            ->where(
                'penduduk_id',
                $penduduk->id
            )
            ->latest()
            ->paginate(10);


        /*
        |--------------------------------------------------------------------------
        | Ambil email dari tabel users
        |--------------------------------------------------------------------------
        */

        $email = $penduduk->user->email ?? null;


        return view(
            'anjungan.riwayat.show',
            [
                'identifier' => $identifier,
                'nik' => $penduduk->nik,
                'email' => $email,
                'penduduk' => $penduduk,
                'surat' => $surat,
            ]
        );
    }


    public function cetak($id)
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil surat beserta relasi
        |--------------------------------------------------------------------------
        */

        $surat = Surat::with([
            'penduduk.user',
            'jenisSurat.persetujuan.aparat',
        ])->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Pastikan jenis surat tersedia
        |--------------------------------------------------------------------------
        */

        if (!$surat->jenisSurat) {
            abort(
                404,
                'Jenis surat tidak ditemukan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil nama jenis surat
        |--------------------------------------------------------------------------
        */

        $namaJenis = $surat->jenisSurat->nama_jenis;


        /*
        |--------------------------------------------------------------------------
        | Ambil konfigurasi surat
        |--------------------------------------------------------------------------
        */

        $config = config(
            "surat.{$namaJenis}"
        );


        /*
        |--------------------------------------------------------------------------
        | Pastikan konfigurasi tersedia
        |--------------------------------------------------------------------------
        */

        if (!$config) {
            abort(
                404,
                'Konfigurasi untuk jenis surat "'
                    . $namaJenis
                    . '" belum tersedia.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil model detail dan view khusus Anjungan
        |--------------------------------------------------------------------------
        */

        $model = $config['model'] ?? null;

        $view = $config['anjungan_view'] ?? null;


        /*
        |--------------------------------------------------------------------------
        | Validasi model detail
        |--------------------------------------------------------------------------
        */

        if (
            !$model ||
            !class_exists($model)
        ) {
            abort(
                404,
                'Model detail untuk jenis surat "'
                    . $namaJenis
                    . '" belum tersedia.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Validasi template cetak Anjungan
        |--------------------------------------------------------------------------
        */

        if (
            !$view ||
            !view()->exists($view)
        ) {
            abort(
                404,
                'Template cetak Anjungan untuk jenis surat "'
                    . $namaJenis
                    . '" belum tersedia.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil data detail surat
        |--------------------------------------------------------------------------
        */

        $detail = $model::where(
            'surat_id',
            $surat->id
        )->first();


        /*
        |--------------------------------------------------------------------------
        | Pastikan data detail tersedia
        |--------------------------------------------------------------------------
        */

        if (!$detail) {
            abort(
                404,
                'Data detail surat tidak ditemukan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Data Penduduk
        |--------------------------------------------------------------------------
        */

        $penduduk = $surat->penduduk;


        $detail->dusun =
            $penduduk->dusun ?? '-';

        $detail->desa_kelurahan =
            $penduduk->desa_kelurahan ?? '-';

        $detail->kecamatan =
            $penduduk->kecamatan ?? '-';

        $detail->kabupaten_kota =
            $penduduk->kabupaten_kota ?? '-';

        $detail->provinsi =
            $penduduk->provinsi ?? '-';


        /*
        |--------------------------------------------------------------------------
        | Data penduduk lainnya
        |--------------------------------------------------------------------------
        */

        $detail->nama_lengkap =
            $penduduk->nama_lengkap ?? '-';

        $detail->nik =
            $penduduk->nik ?? '-';

        $detail->alamat =
            $penduduk->alamat ?? '-';

        $detail->rt =
            $penduduk->rt ?? '-';

        $detail->rw =
            $penduduk->rw ?? '-';


        /*
        |--------------------------------------------------------------------------
        | Email Penduduk
        | Diambil dari tabel users
        |--------------------------------------------------------------------------
        */

        $detail->email =
            $penduduk->user->email ?? '-';


        /*
        |--------------------------------------------------------------------------
        | Ambil data persetujuan
        |--------------------------------------------------------------------------
        */

        $persetujuan = $surat
            ->jenisSurat
            ->persetujuan
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Tampilkan halaman cetak khusus Anjungan
        |--------------------------------------------------------------------------
        */

        return view(
            $view,
            compact(
                'surat',
                'detail',
                'persetujuan'
            )
        );
    }
}