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
     * Mengambil desa_id dari user yang sedang login.
     */
    private function currentDesaId(): int
    {
        $desaId = auth()->user()?->desa_id;

        abort_unless(
            $desaId,
            403,
            'Akun tidak terhubung dengan desa.'
        );

        return (int) $desaId;
    }

    /**
     * Menampilkan halaman pengajuan surat admin.
     */
    public function index(Request $request)
    {
        $desaId = $this->currentDesaId();

        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Surat::with([
            'penduduk',
            'jenisSurat',
        ])
            ->where('desa_id', $desaId);

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

        $surat = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        /**
         * Hanya penduduk dari desa yang sedang login.
         */
        $penduduk = Penduduk::where(
            'desa_id',
            $desaId
        )
            ->orderBy('nama_lengkap')
            ->get();

        /**
         * Hanya jenis surat dari desa yang sedang login.
         */
        $jenisSurat = JenisSurat::where(
            'desa_id',
            $desaId
        )
            ->orderBy('nama_jenis')
            ->get();

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
        $desaId = $this->currentDesaId();

        $search = $request->input('search');

        $query = Surat::with([
            'penduduk',
            'jenisSurat',
        ])
            ->where('desa_id', $desaId);

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
            $desaId = $this->currentDesaId();

            $query = $request->input('query');

            $surat = Surat::with([
                'penduduk',
                'jenisSurat',
            ])
                ->where('desa_id', $desaId)
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
                    'desa_id' => auth()->user()?->desa_id,
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
        $desaId = $this->currentDesaId();

        $penduduk = Penduduk::where(
            'desa_id',
            $desaId
        )
            ->orderBy('nama_lengkap')
            ->get();

        $jenisSurat = JenisSurat::where(
            'desa_id',
            $desaId
        )
            ->orderBy('nama_jenis')
            ->get();

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
        $desaId = $this->currentDesaId();

        /*
        |--------------------------------------------------------------------------
        | Validasi data utama
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'penduduk_id' => [
                'required',
                'integer',
            ],

            'jenis_surat_id' => [
                'required',
                'integer',
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
        | Ambil penduduk berdasarkan desa aktif
        |--------------------------------------------------------------------------
        */

        $penduduk = Penduduk::where(
            'desa_id',
            $desaId
        )
            ->findOrFail(
                $request->penduduk_id
            );


        /*
        |--------------------------------------------------------------------------
        | Ambil jenis surat berdasarkan desa aktif
        |--------------------------------------------------------------------------
        */

        $jenis = JenisSurat::where(
            'desa_id',
            $desaId
        )
            ->findOrFail(
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
        | Proses penyimpanan
        |--------------------------------------------------------------------------
        */

        try {
            $surat = DB::transaction(
                function () use (
                    $request,
                    $desaId,
                    $jenis,
                    $config,
                    $model,
                    $penduduk,
                    $table
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
                            ->file('file_surat')
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
                        'desa_id' =>
                            $desaId,

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
                    | Ambil field detail berdasarkan config
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
                    | Jika tabel detail memiliki desa_id,
                    | gunakan desa aktif.
                    |--------------------------------------------------------------------------
                    */

                    $columns = Schema::getColumnListing(
                        $table
                    );

                    if (
                        in_array(
                            'desa_id',
                            $columns
                        )
                    ) {
                        $detailData['desa_id'] =
                            $desaId;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Tambahkan relasi surat jika tersedia
                    |--------------------------------------------------------------------------
                    */

                    if (
                        in_array(
                            'surat_id',
                            $columns
                        )
                    ) {
                        $detailData['surat_id'] =
                            $surat->id;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Tambahkan relasi penduduk jika tersedia
                    |--------------------------------------------------------------------------
                    */

                    if (
                        in_array(
                            'penduduk_id',
                            $columns
                        )
                    ) {
                        $detailData['penduduk_id'] =
                            $penduduk->id;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Tambahkan file surat jika tersedia
                    |--------------------------------------------------------------------------
                    */

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
                    'desa_id' =>
                        $desaId,

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
        $desaId = $this->currentDesaId();

        /*
        |--------------------------------------------------------------------------
        | Ambil surat hanya dari desa aktif
        |--------------------------------------------------------------------------
        */

        $surat = Surat::query()
            ->with([
                'penduduk',
                'jenisSurat.persetujuan.aparat',
            ])
            ->where(
                'desa_id',
                $desaId
            )
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

        $namaJenis =
            $surat->jenisSurat->nama_jenis;

        $config =
            $this->getSuratConfig(
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

        $model =
            $config['model']
            ?? null;

        $view =
            $config['admin_view']
            ?? null;


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

        $detailQuery = $model::query()
            ->where(
                'surat_id',
                $surat->id
            );

        /*
        |--------------------------------------------------------------------------
        | Jika tabel detail memiliki desa_id,
        | batasi juga berdasarkan desa aktif.
        |--------------------------------------------------------------------------
        */

        $detailTable =
            (new $model)->getTable();

        if (
            Schema::hasColumn(
                $detailTable,
                'desa_id'
            )
        ) {
            $detailQuery->where(
                'desa_id',
                $desaId
            );
        }

        $detail =
            $detailQuery->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Ambil data penduduk
        |--------------------------------------------------------------------------
        */

        $penduduk =
            $surat->penduduk;


        /*
        |--------------------------------------------------------------------------
        | Tambahkan data wilayah
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
        | Ambil persetujuan berdasarkan desa
        |--------------------------------------------------------------------------
        */

        $persetujuanQuery =
            Persetujuan::query()
                ->with('aparat')
                ->where(
                    'jenis_surat_id',
                    $surat->jenisSurat->id
                );

        /*
        |--------------------------------------------------------------------------
        | Jika persetujuan memiliki desa_id,
        | batasi berdasarkan desa aktif.
        |--------------------------------------------------------------------------
        */

        if (
            Schema::hasColumn(
                (new Persetujuan)->getTable(),
                'desa_id'
            )
        ) {
            $persetujuanQuery->where(
                'desa_id',
                $desaId
            );
        }

        $persetujuan =
            $persetujuanQuery->first();


        /*
        |--------------------------------------------------------------------------
        | Buat PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            $view,
            [
                'surat' =>
                    $surat,

                'detail' =>
                    $detail,

                'penduduk' =>
                    $penduduk,

                'jenisSurat' =>
                    $surat->jenisSurat,

                'persetujuan' =>
                    $persetujuan,
            ]
        )->setPaper(
            'A4',
            'portrait'
        );


        /*
        |--------------------------------------------------------------------------
        | Tampilkan PDF
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
        $desaId =
            $this->currentDesaId();

        /*
        |--------------------------------------------------------------------------
        | Validasi status
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'status_surat' => [
                'required',
                'in:proses,selesai,tolak',
            ],
        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Ambil surat hanya dari desa aktif
            |--------------------------------------------------------------------------
            */

            $surat = Surat::with([
                'jenisSurat',
                'penduduk',
            ])
                ->where(
                    'desa_id',
                    $desaId
                )
                ->findOrFail($id);


            /*
            |--------------------------------------------------------------------------
            | Status lama
            |--------------------------------------------------------------------------
            */

            $statusLama =
                $surat->status_surat;


            /*
            |--------------------------------------------------------------------------
            | Update status
            |--------------------------------------------------------------------------
            */

            $surat->status_surat =
                $request->status_surat;


            /*
            |--------------------------------------------------------------------------
            | Isi tanggal pengajuan jika kosong
            |--------------------------------------------------------------------------
            */

            if (!$surat->tanggal_pengajuan) {
                $surat->tanggal_pengajuan =
                    now();
            }


            /*
            |--------------------------------------------------------------------------
            | Buat nomor surat ketika selesai
            |--------------------------------------------------------------------------
            */

            if (
                $request->status_surat === 'selesai'
                &&
                empty($surat->no_surat)
            ) {

                $formatNomor =
                    $surat
                        ->jenisSurat
                        ->format_nomor;

                if (empty($formatNomor)) {
                    throw new \Exception(
                        'Format nomor surat belum diatur.'
                    );
                }

                $surat->no_surat =
                    $this->generateNomorSuratUnik(
                        $desaId,
                        $surat->jenis_surat_id,
                        $formatNomor
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Isi tanggal dibuat ketika selesai
            |--------------------------------------------------------------------------
            */

            if (
                $request->status_surat === 'selesai'
                &&
                empty($surat->tanggal_dibuat)
            ) {
                $surat->tanggal_dibuat =
                    now();
            }


            /*
            |--------------------------------------------------------------------------
            | Pastikan desa_id tetap milik desa aktif
            |--------------------------------------------------------------------------
            */

            $surat->desa_id =
                $desaId;


            /*
            |--------------------------------------------------------------------------
            | Simpan perubahan
            |--------------------------------------------------------------------------
            */

            $surat->save();


            /*
            |--------------------------------------------------------------------------
            | Update detail surat
            |--------------------------------------------------------------------------
            */

            $this->updateDetailSurat(
                $surat
            );


            /*
            |--------------------------------------------------------------------------
            | Generate PDF ketika selesai
            |--------------------------------------------------------------------------
            */

            if (
                $request->status_surat === 'selesai'
            ) {
                $this->generateFileSurat(
                    $surat
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Commit transaksi
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
                            'storage/'
                            . $surat->file_surat
                        )
                        : null,
                ],
            ]);
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error(
                'Gagal memperbarui status surat.',
                [
                    'desa_id' =>
                        $desaId,

                    'surat_id' =>
                        $id,

                    'status_lama' =>
                        $statusLama ?? null,

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
        if (!$surat->jenisSurat) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil konfigurasi surat
        |--------------------------------------------------------------------------
        */

        $config =
            $this->getSuratConfig(
                $surat
                    ->jenisSurat
                    ->nama_jenis
            );

        if (!$config) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil model detail
        |--------------------------------------------------------------------------
        */

        $model =
            $config['model']
            ?? null;

        if (
            !$model
            || !class_exists($model)
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Query detail berdasarkan surat dan desa
        |--------------------------------------------------------------------------
        */

        $detailQuery =
            $model::where(
                'surat_id',
                $surat->id
            );

        $table =
            (new $model)->getTable();

        if (
            Schema::hasColumn(
                $table,
                'desa_id'
            )
        ) {
            $detailQuery->where(
                'desa_id',
                $surat->desa_id
            );
        }

        $detail =
            $detailQuery->first();

        if (!$detail) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil seluruh kolom tabel detail
        |--------------------------------------------------------------------------
        */

        $columns =
            Schema::getColumnListing(
                $detail->getTable()
            );


        /*
        |--------------------------------------------------------------------------
        | Update status surat
        |--------------------------------------------------------------------------
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


        /*
        |--------------------------------------------------------------------------
        | Update nomor surat
        |--------------------------------------------------------------------------
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


        /*
        |--------------------------------------------------------------------------
        | Pastikan desa_id detail sesuai
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                'desa_id',
                $columns
            )
        ) {
            $detail->desa_id =
                $surat->desa_id;
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan
        |--------------------------------------------------------------------------
        */

        $detail->save();
    }


    /**
     * Membuat file PDF surat dan menyimpan
     * lokasi file ke kolom file_surat.
     */
    private function generateFileSurat(
        Surat $surat
    ): string {
        $desaId =
            $this->currentDesaId();

        /*
        |--------------------------------------------------------------------------
        | Pastikan surat memang milik desa aktif
        |--------------------------------------------------------------------------
        */

        if (
            (int) $surat->desa_id !==
            (int) $desaId
        ) {
            abort(
                403,
                'Anda tidak memiliki akses ke surat ini.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Load relasi
        |--------------------------------------------------------------------------
        */

        $surat->load([
            'penduduk',
            'jenisSurat',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Pastikan jenis surat tersedia
        |--------------------------------------------------------------------------
        */

        if (!$surat->jenisSurat) {
            throw new \Exception(
                'Jenis surat tidak ditemukan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil konfigurasi
        |--------------------------------------------------------------------------
        */

        $config =
            $this->getSuratConfig(
                $surat
                    ->jenisSurat
                    ->nama_jenis
            );

        if (empty($config)) {
            throw new \Exception(
                'Konfigurasi surat tidak ditemukan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil template
        |--------------------------------------------------------------------------
        */

        $view =
            $config['admin_view']
            ?? null;

        if (empty($view)) {
            throw new \Exception(
                'Template cetak surat belum diatur.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan Blade tersedia
        |--------------------------------------------------------------------------
        */

        if (!view()->exists($view)) {
            throw new \Exception(
                'Template surat tidak ditemukan: '
                . $view
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil model detail
        |--------------------------------------------------------------------------
        */

        $model =
            $config['model']
            ?? null;

        if (
            empty($model)
            || !class_exists($model)
        ) {
            throw new \Exception(
                'Model detail surat tidak ditemukan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil detail surat
        |--------------------------------------------------------------------------
        */

        $detailQuery =
            $model::query()
                ->where(
                    'surat_id',
                    $surat->id
                );

        $detailTable =
            (new $model)->getTable();

        if (
            Schema::hasColumn(
                $detailTable,
                'desa_id'
            )
        ) {
            $detailQuery->where(
                'desa_id',
                $desaId
            );
        }

        $detail =
            $detailQuery->first();


        if (!$detail) {
            throw new \Exception(
                'Data detail surat tidak ditemukan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil persetujuan
        |--------------------------------------------------------------------------
        */

        $persetujuanQuery =
            Persetujuan::query()
                ->with('aparat')
                ->where(
                    'jenis_surat_id',
                    $surat
                        ->jenisSurat
                        ->id
                );

        /*
        |--------------------------------------------------------------------------
        | Jika Persetujuan memiliki desa_id,
        | gunakan desa aktif.
        |--------------------------------------------------------------------------
        */

        $persetujuanTable =
            (new Persetujuan)->getTable();

        if (
            Schema::hasColumn(
                $persetujuanTable,
                'desa_id'
            )
        ) {
            $persetujuanQuery->where(
                'desa_id',
                $desaId
            );
        }

        $persetujuan =
            $persetujuanQuery->first();


        /*
        |--------------------------------------------------------------------------
        | TTD Base64
        |--------------------------------------------------------------------------
        */

        $ttdBase64 = null;

        $pathTtd =
            $persetujuan?->file_ttd;

        if (!empty($pathTtd)) {

            $pathTtd = ltrim(
                trim($pathTtd),
                '/'
            );


            /*
            |--------------------------------------------------------------------------
            | Jika database menyimpan storage/...
            |--------------------------------------------------------------------------
            */

            if (
                str_starts_with(
                    $pathTtd,
                    'storage/'
                )
            ) {
                $pathTtd =
                    substr(
                        $pathTtd,
                        strlen('storage/')
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Jika database menyimpan URL lengkap
            |--------------------------------------------------------------------------
            */

            if (
                filter_var(
                    $pathTtd,
                    FILTER_VALIDATE_URL
                )
            ) {

                $urlPath =
                    parse_url(
                        $pathTtd,
                        PHP_URL_PATH
                    );

                $storagePosition =
                    strpos(
                        $urlPath,
                        '/storage/'
                    );

                if (
                    $storagePosition !== false
                ) {
                    $pathTtd =
                        substr(
                            $urlPath,
                            $storagePosition
                            + strlen('/storage/')
                        );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Pastikan file TTD tersedia
            |--------------------------------------------------------------------------
            */

            if (
                Storage::disk('public')
                    ->exists($pathTtd)
            ) {

                $fileTtd =
                    Storage::disk('public')
                        ->get($pathTtd);

                $mimeType =
                    Storage::disk('public')
                        ->mimeType($pathTtd);

                $mimeType =
                    $mimeType
                    ?: 'image/png';

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
                        'desa_id' =>
                            $desaId,

                        'surat_id' =>
                            $surat->id,

                        'path_ttd' =>
                            $pathTtd,
                    ]
                );
            }
        } else {

            Log::warning(
                'Path TTD belum tersedia.',
                [
                    'desa_id' =>
                        $desaId,

                    'surat_id' =>
                        $surat->id,

                    'persetujuan_id' =>
                        $persetujuan?->id,
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Buat nama file PDF
        |--------------------------------------------------------------------------
        */

        $namaTabel =
            $surat
                ->jenisSurat
                ->nama_tabel
            ?? 'surat';

        $namaFile =
            $namaTabel
            . '_'
            . $surat->kode_unik
            . '.pdf';


        /*
        |--------------------------------------------------------------------------
        | Path PDF
        |--------------------------------------------------------------------------
        */

        $pathFile =
            'surat/'
            . $namaFile;


        /*
        |--------------------------------------------------------------------------
        | Hapus file PDF lama
        |--------------------------------------------------------------------------
        */

        if (
            !empty($surat->file_surat)
            &&
            Storage::disk('public')
                ->exists(
                    $surat->file_surat
                )
        ) {
            Storage::disk('public')
                ->delete(
                    $surat->file_surat
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Generate PDF
        |--------------------------------------------------------------------------
        */

        $pdf =
            Pdf::loadView(
                $view,
                [
                    'surat' =>
                        $surat,

                    'detail' =>
                        $detail,

                    'penduduk' =>
                        $surat->penduduk,

                    'jenisSurat' =>
                        $surat->jenisSurat,

                    'persetujuan' =>
                        $persetujuan,

                    'ttdBase64' =>
                        $ttdBase64,
                ]
            );


        /*
        |--------------------------------------------------------------------------
        | Paper
        |--------------------------------------------------------------------------
        */

        $pdf->setPaper(
            'A4',
            'portrait'
        );


        /*
        |--------------------------------------------------------------------------
        | Simpan PDF
        |--------------------------------------------------------------------------
        */

        Storage::disk('public')->put(
            $pathFile,
            $pdf->output()
        );


        /*
        |--------------------------------------------------------------------------
        | Simpan path ke surat
        |--------------------------------------------------------------------------
        */

        $surat->update([
            'file_surat' =>
                $pathFile,
        ]);

        return $pathFile;
    }


    /**
     * Membuat nomor surat unik per desa.
     */
    private function generateNomorSuratUnik(
        int $desaId,
        $jenisSuratId,
        $formatNomor
    ) {
        $parts =
            explode(
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


        /*
        |--------------------------------------------------------------------------
        | Hitung nomor hanya dari surat desa aktif
        |--------------------------------------------------------------------------
        */

        $jumlahSurat =
            Surat::where(
                'desa_id',
                $desaId
            )
                ->where(
                    'jenis_surat_id',
                    $jenisSuratId
                )
                ->where(
                    'no_surat',
                    'like',
                    "%/{$kodeDesa}/{$kodeSurat}/{$bulanRomawi}/{$tahun}"
                )
                ->count();


        $nomorUrut =
            str_pad(
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

            $desaId =
                $this->currentDesaId();


            /*
            |--------------------------------------------------------------------------
            | Ambil surat hanya dari desa aktif
            |--------------------------------------------------------------------------
            */

            $surat =
                Surat::where(
                    'desa_id',
                    $desaId
                )
                    ->findOrFail(
                        $id
                    );


            /*
            |--------------------------------------------------------------------------
            | Hapus file surat
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


            /*
            |--------------------------------------------------------------------------
            | Hapus surat
            |--------------------------------------------------------------------------
            */

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
                    'desa_id' =>
                        auth()->user()?->desa_id,

                    'surat_id' =>
                        $id,

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