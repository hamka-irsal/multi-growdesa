<?php

namespace App\Http\Controllers\Anjungan;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\Penduduk;
use App\Models\Surat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SuratController extends Controller
{
    /**
     * Menampilkan daftar jenis surat pada anjungan.
     */
    public function index()
    {
        $dataSurat = JenisSurat::all();

        return view(
            'anjungan.surat.index',
            compact('dataSurat')
        );
    }


    /**
     * Mengecek apakah NIK atau Email penduduk terdaftar.
     */
    public function cekIdentitas(Request $request)
    {
        $request->validate([
            'identifier' => [
                'required',
                function ($attribute, $value, $fail) {

                    $value = trim($value);

                    /*
                    |--------------------------------------------------------------------------
                    | Validasi NIK 16 digit
                    |--------------------------------------------------------------------------
                    */

                    if (preg_match('/^\d{16}$/', $value)) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Validasi Email
                    |--------------------------------------------------------------------------
                    */

                    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Jika bukan NIK dan bukan Email
                    |--------------------------------------------------------------------------
                    */

                    $fail(
                        'Masukkan NIK 16 digit atau email yang valid.'
                    );
                },
            ],
        ]);


        $identifier = trim(
            $request->identifier
        );


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
            | Email diambil dari tabel users
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


        /*
        |--------------------------------------------------------------------------
        | Jika ditemukan
        |--------------------------------------------------------------------------
        */

        if ($penduduk) {

            return response()->json([
                'status' => 'valid',
                'message' => 'NIK atau email ditemukan.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Jika tidak ditemukan
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'status' => 'invalid',
            'message' => 'NIK atau email tidak terdaftar.',
        ]);
    }


    /**
     * Menampilkan form pengajuan surat secara dinamis.
     *
     * Bisa menggunakan:
     * ?identifier=NIK
     * atau
     * ?identifier=email
     */
    public function form(
        Request $request,
        $jenisSurat
    ) {
        /*
        |--------------------------------------------------------------------------
        | Ambil NIK atau Email dari query URL
        |--------------------------------------------------------------------------
        */

        $identifier = trim(
            $request->query('identifier')
        );


        /*
        |--------------------------------------------------------------------------
        | Pastikan identifier tersedia
        |--------------------------------------------------------------------------
        */

        if (empty($identifier)) {

            return redirect()
                ->route('anjungan.surat.index')
                ->with(
                    'error',
                    'NIK atau email tidak ditemukan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Cari penduduk berdasarkan NIK atau Email
        |--------------------------------------------------------------------------
        */

        if (
            preg_match(
                '/^\d{16}$/',
                $identifier
            )
        ) {

            /*
            |--------------------------------------------------------------------------
            | Cari berdasarkan NIK
            |--------------------------------------------------------------------------
            */

            $penduduk = Penduduk::with('user')
                ->where(
                    'nik',
                    $identifier
                )
                ->first();

        } else {

            /*
            |--------------------------------------------------------------------------
            | Cari berdasarkan Email
            |--------------------------------------------------------------------------
            */

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
        | Penduduk tidak ditemukan
        |--------------------------------------------------------------------------
        */

        if (!$penduduk) {

            return redirect()
                ->route('anjungan.surat.index')
                ->with(
                    'error',
                    'NIK atau email tidak terdaftar.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil jenis surat
        |--------------------------------------------------------------------------
        */

        $jenis = JenisSurat::query()
            ->where(
                'id',
                $jenisSurat
            )
            ->orWhere(
                'nama_jenis',
                $jenisSurat
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Jenis surat tidak ditemukan
        |--------------------------------------------------------------------------
        */

        if (!$jenis) {

            abort(
                404,
                'Jenis surat tidak ditemukan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil konfigurasi surat
        |--------------------------------------------------------------------------
        */

        $config = config(
            "surat.{$jenis->nama_jenis}"
        );


        /*
        |--------------------------------------------------------------------------
        | Konfigurasi tidak tersedia
        |--------------------------------------------------------------------------
        */

        if (!$config) {

            abort(
                404,
                'Konfigurasi untuk jenis surat "'
                    . $jenis->nama_jenis
                    . '" belum tersedia.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil form view
        |--------------------------------------------------------------------------
        */

        $formView =
            $config['form_view']
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | Form view tidak tersedia
        |--------------------------------------------------------------------------
        */

        if (!$formView) {

            abort(
                404,
                'Konfigurasi form untuk jenis surat "'
                    . $jenis->nama_jenis
                    . '" belum tersedia.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan file view tersedia
        |--------------------------------------------------------------------------
        */

        if (!view()->exists($formView)) {

            abort(
                404,
                'File form surat "'
                    . $jenis->nama_jenis
                    . '" belum ditemukan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil email dari user
        |--------------------------------------------------------------------------
        */

        $email =
            $penduduk->user->email
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | Tampilkan form
        |--------------------------------------------------------------------------
        */

        return view(
            $formView,
            compact(
                'penduduk',
                'jenis',
                'config',
                'identifier',
                'email'
            )
        );
    }


    /**
     * Menyimpan pengajuan semua jenis surat secara dinamis.
     *
     * Input bisa berupa NIK atau Email.
     */
    public function simpan(
        Request $request,
        $jenisSurat
    ) {
        /*
        |--------------------------------------------------------------------------
        | Validasi NIK atau Email
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'identifier' => [
                'required',
                function ($attribute, $value, $fail) {

                    $value = trim($value);


                    /*
                    |--------------------------------------------------------------------------
                    | NIK
                    |--------------------------------------------------------------------------
                    */

                    if (
                        preg_match(
                            '/^\d{16}$/',
                            $value
                        )
                    ) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Email
                    |--------------------------------------------------------------------------
                    */

                    if (
                        filter_var(
                            $value,
                            FILTER_VALIDATE_EMAIL
                        )
                    ) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Tidak valid
                    |--------------------------------------------------------------------------
                    */

                    $fail(
                        'Masukkan NIK 16 digit atau email yang valid.'
                    );
                },
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Ambil identifier
        |--------------------------------------------------------------------------
        */

        $identifier = trim(
            $request->identifier
        );


        /*
        |--------------------------------------------------------------------------
        | Cari jenis surat
        |--------------------------------------------------------------------------
        */

        $jenis = JenisSurat::query()
            ->where(
                'id',
                $jenisSurat
            )
            ->orWhere(
                'nama_jenis',
                $jenisSurat
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Jenis surat tidak ditemukan
        |--------------------------------------------------------------------------
        */

        if (!$jenis) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Jenis surat tidak ditemukan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil konfigurasi surat
        |--------------------------------------------------------------------------
        */

        $config = config(
            'surat.' . $jenis->nama_jenis
        );


        /*
        |--------------------------------------------------------------------------
        | Konfigurasi tidak tersedia
        |--------------------------------------------------------------------------
        */

        if (empty($config)) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Konfigurasi untuk '
                        . $jenis->nama_jenis
                        . ' belum tersedia.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil model detail surat
        |--------------------------------------------------------------------------
        */

        $model =
            $config['model']
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | Pastikan model tersedia
        |--------------------------------------------------------------------------
        */

        if (
            empty($model) ||
            !class_exists($model)
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Model surat '
                        . $jenis->nama_jenis
                        . ' belum tersedia.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Validasi field tambahan
        |--------------------------------------------------------------------------
        */

        $validationRules =
            $config['validation']
            ?? [];


        if (!empty($validationRules)) {

            $request->validate(
                $validationRules
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Cari data penduduk berdasarkan NIK atau Email
        |--------------------------------------------------------------------------
        */

        if (
            preg_match(
                '/^\d{16}$/',
                $identifier
            )
        ) {

            /*
            |--------------------------------------------------------------------------
            | Cari berdasarkan NIK
            |--------------------------------------------------------------------------
            */

            $penduduk = Penduduk::with('user')
                ->where(
                    'nik',
                    $identifier
                )
                ->first();

        } else {

            /*
            |--------------------------------------------------------------------------
            | Cari berdasarkan Email
            |--------------------------------------------------------------------------
            */

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
        | Pastikan penduduk ditemukan
        |--------------------------------------------------------------------------
        */

        if (!$penduduk) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'NIK atau email tidak terdaftar.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil email dari tabel users
        |--------------------------------------------------------------------------
        */

        $email =
            $penduduk->user->email
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | Simpan data
        |--------------------------------------------------------------------------
        */

        try {

            DB::transaction(
                function () use (
                    $request,
                    $jenis,
                    $config,
                    $model,
                    $penduduk
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Simpan surat utama
                    |--------------------------------------------------------------------------
                    */

                    $surat = Surat::create([

                        'kode_unik' =>
                            (string) Str::uuid(),

                        'no_surat' =>
                            null,

                        'nama_lengkap' =>
                            $penduduk->nama_lengkap,

                        'jenis_surat_id' =>
                            $jenis->id,

                        'tanggal_pengajuan' =>
                            Carbon::today(),

                        'tanggal_dibuat' =>
                            now(),

                        'status_surat' =>
                            'proses',

                        'persetujuan' =>
                            'belum',

                        'dibuat_oleh' =>
                            'user',

                        'keterangan' =>
                            $config['keterangan']
                            ?? 'Permohonan '
                            . $jenis->nama_jenis,

                        'file_surat' =>
                            null,

                        'penduduk_id' =>
                            $penduduk->id,
                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | Ambil data field tambahan
                    |--------------------------------------------------------------------------
                    */

                    $detailData = [];


                    foreach (
                        $config['fields']
                        ?? []
                        as $field
                    ) {

                        $detailData[$field] =
                            $request->input($field);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Tambahkan relasi surat
                    |--------------------------------------------------------------------------
                    */

                    $detailData['surat_id'] =
                        $surat->id;

                    $detailData['penduduk_id'] =
                        $penduduk->id;


                    /*
                    |--------------------------------------------------------------------------
                    | Simpan detail surat
                    |--------------------------------------------------------------------------
                    */

                    $model::create(
                        $detailData
                    );
                }
            );

        } catch (\Throwable $e) {

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Permohonan surat gagal disimpan: '
                        . $e->getMessage()
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Response AJAX
        |--------------------------------------------------------------------------
        */

        if ($request->expectsJson()) {

            return response()->json([

                'success' =>
                    true,

                'message' =>
                    'Permohonan surat berhasil dibuat. '
                    . 'Silakan menunggu konfirmasi dari aparat desa.',

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Response biasa
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'anjungan.surat.index'
            )
            ->with(
                'success',
                'Permohonan surat berhasil dibuat. '
                    . 'Silakan menunggu konfirmasi dari aparat desa.'
            );
    }
}