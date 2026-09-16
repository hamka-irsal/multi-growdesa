<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\Penduduk;
use App\Models\Surat;
use App\Models\Persetujuan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengajuanSuratController extends Controller
{
    /**
     * Menampilkan halaman pengajuan surat admin.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Surat::with([
            'penduduk',
            'jenisSurat',
        ]);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('no_surat', 'like', "%{$search}%")
                    ->orWhere('nama_lengkap', 'like', "%{$search}%")
                    ->orWhereHas('penduduk', function ($pendudukQuery) use ($search) {
                        $pendudukQuery->where(
                            'nama_lengkap',
                            'like',
                            "%{$search}%"
                        );
                    })
                    ->orWhereHas('jenisSurat', function ($jenisQuery) use ($search) {
                        $jenisQuery->where(
                            'nama_jenis',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        $surat = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $penduduk = Penduduk::orderBy('nama_lengkap')->get();

        $jenisSurat = JenisSurat::orderBy('nama_jenis')->get();

        return view(
            'admin.surat.pengajuan',
            compact(
                'surat',
                'perPage',
                'search',
                'penduduk',
                'jenisSurat'
            )
        );
    }


    /**
     * Mengambil konfigurasi surat berdasarkan nama jenis surat.
     */
    private function getSuratConfig($namaJenis)
    {
        return config("surat.{$namaJenis}");
    }


    /**
     * Mengambil daftar pengajuan surat melalui AJAX.
     */
    public function paginate(Request $request)
    {
        $search = $request->input('search');

        $query = Surat::with([
            'penduduk',
            'jenisSurat',
        ]);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where(
                    'no_surat',
                    'like',
                    "%{$search}%"
                )
                    ->orWhere(
                        'nama_lengkap',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhereHas(
                        'penduduk',
                        function ($pendudukQuery) use ($search) {
                            $pendudukQuery->where(
                                'nama_lengkap',
                                'like',
                                "%{$search}%"
                            );
                        }
                    )
                    ->orWhereHas(
                        'jenisSurat',
                        function ($jenisQuery) use ($search) {
                            $jenisQuery->where(
                                'nama_jenis',
                                'like',
                                "%{$search}%"
                            );
                        }
                    );
            });
        }

        return response()->json(
            $query
                ->latest()
                ->paginate(
                    $request->input('perPage', 10)
                )
        );
    }


    /**
     * Mencari pengajuan surat.
     */
    public function search(Request $request)
    {
        try {

            $query = $request->input('query');

            $surat = Surat::with([
                'penduduk',
                'jenisSurat',
            ])
                ->where(function ($q) use ($query) {

                    $q->where(
                        'nama_lengkap',
                        'like',
                        "%{$query}%"
                    )
                        ->orWhere(
                            'no_surat',
                            'like',
                            "%{$query}%"
                        )
                        ->orWhereHas(
                            'jenisSurat',
                            function ($jenisQuery) use ($query) {

                                $jenisQuery->where(
                                    'nama_jenis',
                                    'like',
                                    "%{$query}%"
                                );
                            }
                        );
                })
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data' => $surat,
            ]);
        } catch (\Throwable $e) {

            Log::error(
                'Terjadi kesalahan saat mencari surat.',
                [
                    'message' => $e->getMessage(),
                ]
            );

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pencarian.',
            ], 500);
        }
    }


    /**
     * Menampilkan form pengajuan surat admin.
     */
    public function create()
    {
        $penduduk = Penduduk::orderBy(
            'nama_lengkap'
        )->get();

        $jenisSurat = JenisSurat::orderBy(
            'nama_jenis'
        )->get();

        return view(
            'admin.surat.pengajuan',
            compact(
                'penduduk',
                'jenisSurat'
            )
        );
    }


    /**
     * Menyimpan pengajuan surat dari admin.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi data utama
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'penduduk_id' => [
                'required',
                'exists:penduduk,id',
            ],

            'jenis_surat_id' => [
                'required',
                'exists:jenis_surat,id',
            ],

            'nama_lengkap' => [
                'nullable',
                'string',
                'max:100',
            ],

            'tanggal_pengajuan' => [
                'nullable',
                'date',
            ],

            'status_surat' => [
                'nullable',
                'in:proses,selesai,tolak',
            ],

            'persetujuan' => [
                'nullable',
                'string',
            ],

            'dibuat_oleh' => [
                'nullable',
                'string',
                'max:100',
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],

            'file_surat' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx',
                'max:2048',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Ambil jenis surat
        |--------------------------------------------------------------------------
        */

        $jenis = JenisSurat::findOrFail(
            $request->jenis_surat_id
        );


        /*
        |--------------------------------------------------------------------------
        | Ambil konfigurasi surat
        |--------------------------------------------------------------------------
        */

        $config = $this->getSuratConfig(
            $jenis->nama_jenis
        );

        if (!$config) {

            return response()->json([
                'success' => false,
                'message' =>
                'Konfigurasi untuk jenis surat "'
                    . $jenis->nama_jenis
                    . '" belum tersedia.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil model detail
        |--------------------------------------------------------------------------
        */

        $model = $config['model'] ?? null;

        if (
            !$model ||
            !class_exists($model)
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                'Model detail untuk jenis surat "'
                    . $jenis->nama_jenis
                    . '" belum tersedia.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan tabel model tersedia
        |--------------------------------------------------------------------------
        */

        $detailModel = new $model;

        $table = $detailModel->getTable();

        if (!Schema::hasTable($table)) {

            return response()->json([
                'success' => false,
                'message' =>
                'Tabel detail surat "'
                    . $table
                    . '" tidak ditemukan.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Validasi field khusus berdasarkan config
        |--------------------------------------------------------------------------
        */

        $validation = $config['validation'] ?? [];

        if (!empty($validation)) {

            $request->validate(
                $validation
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil data penduduk
        |--------------------------------------------------------------------------
        */

        $penduduk = Penduduk::findOrFail(
            $request->penduduk_id
        );


        /*
        |--------------------------------------------------------------------------
        | Proses penyimpanan
        |--------------------------------------------------------------------------
        */

        try {

            $surat = DB::transaction(
                function () use (
                    $request,
                    $jenis,
                    $config,
                    $model,
                    $penduduk
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Upload file surat
                    |--------------------------------------------------------------------------
                    */

                    $filePath = null;

                    if (
                        $request->hasFile(
                            'file_surat'
                        )
                    ) {

                        $filePath = $request
                            ->file(
                                'file_surat'
                            )
                            ->store(
                                'surat',
                                'public'
                            );
                    }


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

                        'penduduk_id' =>
                        $penduduk->id,

                        'jenis_surat_id' =>
                        $jenis->id,

                        'nama_lengkap' =>
                        $request->nama_lengkap
                            ?? $penduduk->nama_lengkap,

                        'tanggal_pengajuan' =>
                        $request->tanggal_pengajuan
                            ?? now(),

                        'tanggal_dibuat' =>
                        now(),

                        'status_surat' =>
                        $request->status_surat
                            ?? 'proses',

                        'persetujuan' =>
                        $request->persetujuan
                            ?? 'belum',

                        'dibuat_oleh' =>
                        $request->dibuat_oleh
                            ?? 'admin',

                        'keterangan' =>
                        $request->keterangan
                            ?? $config['keterangan']
                            ?? 'Permohonan '
                            . $jenis->nama_jenis,

                        'file_surat' =>
                        $filePath,

                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | Ambil field detail hanya dari config
                    |--------------------------------------------------------------------------
                    */

                    $detailData = [];

                    foreach (
                        $config['fields'] ?? []
                        as $field
                    ) {

                        $detailData[$field] =
                            $request->input(
                                $field
                            );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Tambahkan relasi jika kolom tersedia
                    |--------------------------------------------------------------------------
                    */

                    $columns = Schema::getColumnListing(
                        $table = (new $model)->getTable()
                    );

                    if (
                        in_array(
                            'surat_id',
                            $columns
                        )
                    ) {

                        $detailData['surat_id'] =
                            $surat->id;
                    }

                    if (
                        in_array(
                            'penduduk_id',
                            $columns
                        )
                    ) {

                        $detailData['penduduk_id'] =
                            $penduduk->id;
                    }

                    if (
                        in_array(
                            'file_surat',
                            $columns
                        )
                    ) {

                        $detailData['file_surat'] =
                            $filePath;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Simpan detail surat
                    |--------------------------------------------------------------------------
                    */

                    $model::create(
                        $detailData
                    );


                    return $surat;
                }
            );


            return response()->json([

                'success' => true,

                'message' =>
                'Pengajuan surat berhasil disimpan.',

                'data' =>
                $surat,

            ]);
        } catch (\Throwable $e) {

            Log::error(
                'Gagal menyimpan pengajuan surat.',
                [
                    'message' =>
                    $e->getMessage(),

                    'trace' =>
                    $e->getTraceAsString(),
                ]
            );

            return response()->json([

                'success' => false,

                'message' =>
                'Pengajuan surat gagal disimpan. '
                    . 'Silakan periksa kembali data yang diisi.',

            ], 500);
        }
    }


    /**
     * Mencetak surat menggunakan admin_view dari konfigurasi.
     */
    public function cetak($id)
    {
        /*
    |--------------------------------------------------------------------------
    | Ambil surat beserta relasinya
    |--------------------------------------------------------------------------
    */

        $surat = Surat::query()
            ->with([
                'penduduk',
                'jenisSurat.persetujuan.aparat',
            ])
            ->findOrFail($id);

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
    | Ambil konfigurasi berdasarkan jenis surat
    |--------------------------------------------------------------------------
    */

        $namaJenis = $surat->jenisSurat->nama_jenis;

        $config = $this->getSuratConfig(
            $namaJenis
        );

        if (empty($config)) {
            abort(
                404,
                'Konfigurasi untuk jenis surat "'
                    . $namaJenis
                    . '" belum tersedia.'
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Ambil model detail dan template cetak
    |--------------------------------------------------------------------------
    */

        $model = $config['model'] ?? null;

        $view = $config['admin_view'] ?? null;

        /*
    |--------------------------------------------------------------------------
    | Validasi model detail
    |--------------------------------------------------------------------------
    */

        if (
            empty($model)
            || !class_exists($model)
        ) {
            abort(
                404,
                'Model detail surat belum tersedia.'
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Validasi template Blade
    |--------------------------------------------------------------------------
    */

        if (
            empty($view)
            || !view()->exists($view)
        ) {
            abort(
                404,
                'Template cetak admin untuk jenis surat "'
                    . $namaJenis
                    . '" belum tersedia.'
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Ambil detail surat
    |--------------------------------------------------------------------------
    */

        $detail = $model::query()
            ->where(
                'surat_id',
                $surat->id
            )
            ->firstOrFail();

        /*
    |--------------------------------------------------------------------------
    | Ambil data penduduk
    |--------------------------------------------------------------------------
    */

        $penduduk = $surat->penduduk;

        /*
    |--------------------------------------------------------------------------
    | Tambahkan data wilayah ke detail
    |
    | Bagian ini dipertahankan agar template lama yang masih memakai:
    |
    | $detail->kabupaten_kota
    | $detail->kecamatan
    | $detail->desa_kelurahan
    |
    | tetap dapat digunakan.
    |--------------------------------------------------------------------------
    */

        $detail->kabupaten_kota =
            $penduduk?->kabupaten_kota;

        $detail->kecamatan =
            $penduduk?->kecamatan;

        $detail->desa_kelurahan =
            $penduduk?->desa_kelurahan;

        /*
    |--------------------------------------------------------------------------
    | Ambil persetujuan berdasarkan jenis surat
    |--------------------------------------------------------------------------
    */

        $persetujuan = $surat
            ->jenisSurat
            ->persetujuan
            ->first();

        /*
    |--------------------------------------------------------------------------
    | Buat PDF
    |--------------------------------------------------------------------------
    */

        $pdf = Pdf::loadView(
            $view,
            [
                /*
             * Data surat utama.
             */
                'surat' => $surat,

                /*
             * Data detail berdasarkan jenis surat.
             */
                'detail' => $detail,

                /*
             * Kirim penduduk secara langsung.
             *
             * Ini diperlukan agar Blade dapat memakai:
             * $penduduk?->desa_kelurahan
             */
                'penduduk' => $penduduk,

                /*
             * Data jenis surat.
             */
                'jenisSurat' => $surat->jenisSurat,

                /*
             * Data persetujuan dan aparat.
             */
                'persetujuan' => $persetujuan,
            ]
        )->setPaper(
            'A4',
            'portrait'
        );

        /*
    |--------------------------------------------------------------------------
    | Tampilkan PDF di browser
    |--------------------------------------------------------------------------
    */

        $namaFile =
            Str::slug($namaJenis)
            . '-'
            . $surat->id
            . '.pdf';

        return $pdf->stream(
            $namaFile
        );
    }


    /**
     * Mengubah status pengajuan surat.
     */
    public function updateStatus(
        Request $request,
        $id
    ) {
        /**
         * Validasi status surat
         */
        $request->validate([

            'status_surat' => [
                'required',
                'in:proses,selesai,tolak',
            ],

        ]);

        DB::beginTransaction();

        try {

            /**
             * Ambil surat beserta relasi
             */
            $surat = Surat::with([
                'jenisSurat',
                'penduduk',
            ])->findOrFail($id);

            /**
             * Simpan status lama
             *
             * Digunakan untuk mengetahui apakah
             * status baru saja berubah menjadi selesai.
             */
            $statusLama = $surat->status_surat;

            /*
        |--------------------------------------------------------------------------
        | Update status surat
        |--------------------------------------------------------------------------
        */

            $surat->status_surat =
                $request->status_surat;

            /*
        |--------------------------------------------------------------------------
        | Isi tanggal pengajuan jika kosong
        |--------------------------------------------------------------------------
        */

            if (
                !$surat->tanggal_pengajuan
            ) {

                $surat->tanggal_pengajuan =
                    now();
            }

            /*
        |--------------------------------------------------------------------------
        | Buat nomor surat ketika selesai
        |--------------------------------------------------------------------------
        */

            if (

                $request->status_surat
                === 'selesai'

                &&

                empty($surat->no_surat)

            ) {

                $formatNomor =
                    $surat
                    ->jenisSurat
                    ->format_nomor;

                if (
                    empty($formatNomor)
                ) {

                    throw new \Exception(
                        'Format nomor surat belum diatur.'
                    );
                }

                $surat->no_surat =
                    $this->generateNomorSuratUnik(

                        $surat->jenis_surat_id,

                        $formatNomor

                    );
            }

            /*
        |--------------------------------------------------------------------------
        | Isi tanggal dibuat ketika surat selesai
        |--------------------------------------------------------------------------
        */

            if (
                $request->status_surat
                === 'selesai'

                &&

                empty($surat->tanggal_dibuat)
            ) {

                $surat->tanggal_dibuat =
                    now();
            }

            /*
        |--------------------------------------------------------------------------
        | Simpan perubahan surat
        |--------------------------------------------------------------------------
        */

            $surat->save();

            /*
        |--------------------------------------------------------------------------
        | Update status dan nomor surat
        | pada tabel detail
        |--------------------------------------------------------------------------
        */

            $this->updateDetailSurat(
                $surat
            );

            /*
        |--------------------------------------------------------------------------
        | Generate PDF ketika status selesai
        |--------------------------------------------------------------------------
        */

            if (
                $request->status_surat
                === 'selesai'
            ) {

                $this->generateFileSurat(
                    $surat
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Simpan seluruh perubahan
        |--------------------------------------------------------------------------
        */

            DB::commit();

            return response()->json([

                'success' => true,

                'message' =>
                $request->status_surat === 'selesai'
                    ? 'Surat berhasil diselesaikan dan file PDF berhasil dibuat.'
                    : 'Status surat berhasil diperbarui.',

                'data' => [

                    'id' =>
                    $surat->id,

                    'status_surat' =>
                    $surat->status_surat,

                    'no_surat' =>
                    $surat->no_surat,

                    'file_surat' =>
                    $surat->file_surat
                        ? asset(
                            'storage/' .
                                $surat->file_surat
                        )
                        : null,

                ],

            ]);
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error(
                'Gagal memperbarui status surat.',
                [

                    'surat_id' =>
                    $id,

                    'message' =>
                    $e->getMessage(),

                    'file' =>
                    $e->getFile(),

                    'line' =>
                    $e->getLine(),

                ]
            );

            return response()->json([

                'success' => false,

                'message' =>
                'Terjadi kesalahan: '
                    . $e->getMessage(),

            ], 500);
        }
    }

    /**
     * Mengupdate status dan nomor surat
     * pada tabel detail jika kolom tersedia.
     */
    private function updateDetailSurat(
        Surat $surat
    ) {

        if (
            !$surat->jenisSurat
        ) {

            return;
        }

        /**
         * Ambil konfigurasi surat
         */
        $config =
            $this->getSuratConfig(

                $surat
                    ->jenisSurat
                    ->nama_jenis

            );

        if (
            !$config
        ) {

            return;
        }

        /**
         * Ambil model detail
         */
        $model =
            $config['model']
            ?? null;

        if (

            !$model

            ||

            !class_exists($model)

        ) {

            return;
        }

        /**
         * Ambil data detail berdasarkan surat_id
         */
        $detail =
            $model::where(

                'surat_id',

                $surat->id

            )->first();

        if (
            !$detail
        ) {

            return;
        }

        /**
         * Ambil seluruh kolom tabel detail
         */
        $columns =
            Schema::getColumnListing(

                $detail->getTable()

            );

        /**
         * Update status jika kolom tersedia
         */
        if (

            in_array(

                'status_surat',

                $columns

            )

        ) {

            $detail->status_surat =
                $surat->status_surat;
        }

        /**
         * Update nomor surat jika kolom tersedia
         */
        if (

            in_array(

                'no_surat',

                $columns

            )

        ) {

            $detail->no_surat =
                $surat->no_surat;
        }

        /**
         * Simpan perubahan detail
         */
        $detail->save();
    }

    /**
     * Membuat file PDF surat dan menyimpan
     * lokasi file ke kolom file_surat.
     */
    private function generateFileSurat(Surat $surat): string
    {
        /**
         * Pastikan relasi surat tersedia.
         */
        $surat->load([
            'penduduk',
            'jenisSurat',
        ]);

        /**
         * Pastikan jenis surat tersedia.
         */
        if (!$surat->jenisSurat) {
            throw new \Exception(
                'Jenis surat tidak ditemukan.'
            );
        }

        /**
         * Ambil konfigurasi surat.
         */
        $config = $this->getSuratConfig(
            $surat->jenisSurat->nama_jenis
        );

        /**
         * Pastikan konfigurasi tersedia.
         */
        if (empty($config)) {
            throw new \Exception(
                'Konfigurasi surat tidak ditemukan.'
            );
        }

        /**
         * Ambil template surat.
         */
        $view = $config['admin_view'] ?? null;

        /**
         * Pastikan template tersedia.
         */
        if (empty($view)) {
            throw new \Exception(
                'Template cetak surat belum diatur.'
            );
        }

        /**
         * Pastikan file Blade tersedia.
         */
        if (!view()->exists($view)) {
            throw new \Exception(
                'Template surat tidak ditemukan: ' . $view
            );
        }

        /**
         * Ambil model detail surat.
         */
        $model = $config['model'] ?? null;

        /**
         * Pastikan model detail tersedia.
         */
        if (
            empty($model)
            || !class_exists($model)
        ) {
            throw new \Exception(
                'Model detail surat tidak ditemukan.'
            );
        }

        /**
         * Ambil detail berdasarkan surat yang sedang dibuat.
         */
        $detail = $model::query()
            ->where('surat_id', $surat->id)
            ->first();

        /**
         * Pastikan detail tersedia.
         */
        if (!$detail) {
            throw new \Exception(
                'Data detail surat tidak ditemukan.'
            );
        }

        /**
         * Ambil persetujuan khusus untuk surat ini
         * beserta data aparat yang menyetujui.
         *
         * Jangan menggunakan first() tanpa kondisi,
         * karena dapat mengambil persetujuan surat lain.
         */
        /**

         * Muat relasi surat.
         */
        $surat->load([
            'penduduk',
            'jenisSurat',
        ]);

        /**

         * Ambil data persetujuan berdasarkan
         * jenis surat yang sedang dibuat.
         */
        $persetujuan = Persetujuan::query()
            ->with('aparat')
            ->where(
                'jenis_surat_id',
                $surat->jenisSurat->id
            )
            ->first();

        /**

         * Nilai awal gambar TTD.
         */
        $ttdBase64 = null;

        /**

         * Ambil path gambar TTD.
         */
        $pathTtd = $persetujuan?->file_ttd;


        /**
         * Nilai awal gambar TTD.
         */
        $ttdBase64 = null;

        /**
         * Ambil path TTD dari persetujuan.
         */
        $pathTtd = $persetujuan?->file_ttd;

        /**
         * Ubah TTD menjadi Base64 agar dapat
         * dibaca langsung oleh DomPDF.
         */
        if (!empty($pathTtd)) {
            /**
             * Hilangkan slash pada bagian awal.
             */
            $pathTtd = ltrim(
                trim($pathTtd),
                '/'
            );

            /**
             * Jika database menyimpan:
             * storage/ttd/namafile.png
             *
             * ubah menjadi:
             * ttd/namafile.png
             */
            if (
                str_starts_with(
                    $pathTtd,
                    'storage/'
                )
            ) {
                $pathTtd = substr(
                    $pathTtd,
                    strlen('storage/')
                );
            }

            /**
             * Jika database menyimpan URL lengkap,
             * ambil path setelah /storage/.
             */
            if (
                filter_var(
                    $pathTtd,
                    FILTER_VALIDATE_URL
                )
            ) {
                $urlPath = parse_url(
                    $pathTtd,
                    PHP_URL_PATH
                );

                $storagePosition = strpos(
                    $urlPath,
                    '/storage/'
                );

                if ($storagePosition !== false) {
                    $pathTtd = substr(
                        $urlPath,
                        $storagePosition
                            + strlen('/storage/')
                    );
                }
            }

            /**
             * Pastikan file TTD benar-benar ada.
             */
            if (
                Storage::disk('public')->exists(
                    $pathTtd
                )
            ) {
                $fileTtd = Storage::disk('public')->get(
                    $pathTtd
                );

                /**
                 * Ambil MIME type.
                 */
                $mimeType = Storage::disk('public')
                    ->mimeType($pathTtd);

                /**
                 * Gunakan MIME type default
                 * jika gagal terdeteksi.
                 */
                $mimeType = $mimeType
                    ?: 'image/png';

                /**
                 * Buat Data URI Base64.
                 */
                $ttdBase64 =
                    'data:'
                    . $mimeType
                    . ';base64,'
                    . base64_encode(
                        $fileTtd
                    );
            } else {
                Log::warning(
                    'File TTD tidak ditemukan.',
                    [
                        'surat_id' => $surat->id,
                        'path_ttd' => $pathTtd,
                    ]
                );
            }
        } else {
            Log::warning(
                'Path TTD belum tersedia.',
                [
                    'surat_id' => $surat->id,
                    'persetujuan_id' =>
                    $persetujuan?->id,
                ]
            );
        }

        /**
         * Buat nama file PDF.
         */
        $namaTabel =
            $surat->jenisSurat->nama_tabel
            ?? 'surat';

        $namaFile =
            $namaTabel
            . '_'
            . $surat->kode_unik
            . '.pdf';

        /**
         * Path PDF pada disk public.
         */
        $pathFile =
            'surat/'
            . $namaFile;

        /**
         * Hapus file PDF lama.
         */
        if (
            !empty($surat->file_surat)
            && Storage::disk('public')->exists(
                $surat->file_surat
            )
        ) {
            Storage::disk('public')->delete(
                $surat->file_surat
            );
        }

        /**
         * Buat PDF berdasarkan template.
         */
        $pdf = Pdf::loadView(
            $view,
            [
                'surat' => $surat,
                'detail' => $detail,
                'penduduk' => $surat->penduduk,
                'jenisSurat' => $surat->jenisSurat,
                'persetujuan' => $persetujuan,
                'ttdBase64' => $ttdBase64,
            ]
        );

        /**
         * Atur ukuran kertas PDF.
         */
        $pdf->setPaper(
            'A4',
            'portrait'
        );

        /**
         * Simpan file PDF.
         */
        Storage::disk('public')->put(
            $pathFile,
            $pdf->output()
        );

        /**
         * Simpan path PDF ke tabel surat.
         */
        $surat->update([
            'file_surat' => $pathFile,
        ]);

        return $pathFile;
    }


    /**
     * Membuat nomor surat unik.
     */
    private function generateNomorSuratUnik(
        $jenisSuratId,
        $formatNomor
    ) {

        $parts = explode(
            '/',
            $formatNomor
        );


        if (
            count($parts) < 5
        ) {

            throw new \Exception(
                'Format nomor surat tidak valid.'
            );
        }


        $kodeDesa =
            $parts[1];

        $kodeSurat =
            $parts[2];

        $bulanRomawi =
            $parts[3];

        $tahun =
            $parts[4];


        $jumlahSurat = Surat::where(
            'jenis_surat_id',
            $jenisSuratId
        )
            ->where(
                'no_surat',
                'like',
                "%/{$kodeDesa}/{$kodeSurat}/{$bulanRomawi}/{$tahun}"
            )
            ->count();


        $nomorUrut = str_pad(

            $jumlahSurat + 1,

            3,

            '0',

            STR_PAD_LEFT

        );


        return

            "{$nomorUrut}"
            . "/{$kodeDesa}"
            . "/{$kodeSurat}"
            . "/{$bulanRomawi}"
            . "/{$tahun}";
    }


    /**
     * Menghapus pengajuan surat.
     */
    public function destroy($id)
    {
        try {

            $surat = Surat::findOrFail(
                $id
            );


            /*
            |--------------------------------------------------------------------------
            | Hapus file jika tersedia
            |--------------------------------------------------------------------------
            */

            if (
                $surat->file_surat
            ) {

                Storage::disk(
                    'public'
                )->delete(
                    $surat->file_surat
                );
            }


            $surat->delete();


            return response()->json([

                'success' => true,

                'message' =>
                'Pengajuan surat berhasil dihapus.',

            ]);
        } catch (\Throwable $e) {

            Log::error(
                'Gagal menghapus surat.',
                [
                    'message' =>
                    $e->getMessage(),
                ]
            );


            return response()->json([

                'success' => false,

                'message' =>
                'Data surat gagal dihapus.',

            ], 500);
        }
    }
}
