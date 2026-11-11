<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Persetujuan;
use App\Models\JenisSurat;
use App\Models\Aparat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PersetujuanController extends Controller
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
     * Menampilkan daftar persetujuan.
     */
    public function index(Request $request)
    {
        $desaId = $this->currentDesaId();

        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Persetujuan::with([
            'jenisSurat',
            'aparat'
        ])
            ->where('desa_id', $desaId);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->whereHas(
                    'jenisSurat',
                    function ($jenisQuery) use ($search) {
                        $jenisQuery->where(
                            'nama_jenis',
                            'like',
                            "%{$search}%"
                        );
                    }
                )
                    ->orWhere(
                        'jabatan',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhereHas(
                        'aparat',
                        function ($aparatQuery) use ($search) {
                            $aparatQuery->where(
                                'nama',
                                'like',
                                "%{$search}%"
                            );
                        }
                    );
            });
        }

        $persetujuan = $query
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();


        /**
         * Hanya jenis surat milik desa aktif.
         */
        $jenisSuratList = JenisSurat::where(
            'desa_id',
            $desaId
        )
            ->orderBy('nama_jenis')
            ->get();


        /**
         * Hanya aparat milik desa aktif.
         */
        $aparatList = Aparat::where(
            'desa_id',
            $desaId
        )
            ->orderBy('nama')
            ->get();


        return view(
            'admin.persetujuan.index',
            compact(
                'persetujuan',
                'perPage',
                'search',
                'jenisSuratList',
                'aparatList'
            )
        );
    }


    /**
     * Mencari jenis surat.
     */
    public function search(Request $request)
    {
        try {

            $desaId = $this->currentDesaId();

            $query = $request->input('query');

            $jenisSurat = JenisSurat::where(
                'desa_id',
                $desaId
            )
                ->where(function ($q) use ($query) {
                    $q->where(
                        'nama_jenis',
                        'like',
                        '%' . $query . '%'
                    )
                        ->orWhere(
                            'format_surat',
                            'like',
                            '%' . $query . '%'
                        );
                })
                ->get();


            return response()->json([
                'success' => true,
                'data' => $jenisSurat
            ]);

        } catch (\Throwable $e) {

            Log::error(
                'Kesalahan saat pencarian jenis surat.',
                [
                    'desa_id' =>
                        auth()->user()?->desa_id,

                    'message' =>
                        $e->getMessage(),
                ]
            );

            return response()->json([
                'success' => false,
                'message' =>
                    'Terjadi kesalahan saat pencarian!'
            ], 500);
        }
    }


    /**
     * Pagination data persetujuan melalui AJAX.
     */
    public function paginate(Request $request)
    {
        try {

            $desaId = $this->currentDesaId();

            $search =
                $request->input('query');

            $query = Persetujuan::with([
                'jenisSurat',
                'aparat'
            ])
                ->where(
                    'desa_id',
                    $desaId
                );


            if (!empty($search)) {

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'jabatan',
                        'like',
                        "%{$search}%"
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
                        )
                        ->orWhereHas(
                            'aparat',
                            function ($aparatQuery) use ($search) {
                                $aparatQuery->where(
                                    'nama',
                                    'like',
                                    "%{$search}%"
                                );
                            }
                        );
                });
            }


            $persetujuan = $query
                ->orderBy(
                    'id',
                    'desc'
                )
                ->paginate(
                    $request->input(
                        'perPage',
                        10
                    )
                );


            return response()->json(
                $persetujuan
            );

        } catch (\Throwable $e) {

            Log::error(
                'Kesalahan saat memuat data persetujuan.',
                [
                    'desa_id' =>
                        auth()->user()?->desa_id,

                    'message' =>
                        $e->getMessage(),
                ]
            );

            return response()->json([
                'success' => false,
                'message' =>
                    'Terjadi kesalahan saat memuat data!'
            ], 500);
        }
    }


    /**
     * Menampilkan satu data persetujuan.
     */
    public function show($id)
    {
        $desaId =
            $this->currentDesaId();

        $data = Persetujuan::with([
            'jenisSurat',
            'aparat'
        ])
            ->where(
                'desa_id',
                $desaId
            )
            ->find($id);


        if (!$data) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Data tidak ditemukan'
            ], 404);
        }


        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }


    /**
     * Form create persetujuan.
     */
    public function create()
    {
        $desaId =
            $this->currentDesaId();


        $jenisSurat =
            JenisSurat::where(
                'desa_id',
                $desaId
            )
                ->orderBy(
                    'nama_jenis'
                )
                ->get();


        $aparat =
            Aparat::where(
                'desa_id',
                $desaId
            )
                ->orderBy(
                    'nama'
                )
                ->get();


        return view(
            'admin.persetujuan.create',
            compact(
                'jenisSurat',
                'aparat'
            )
        );
    }


    /**
     * Menyimpan persetujuan.
     */
    public function store(Request $request)
    {
        $desaId =
            $this->currentDesaId();


        /*
        |--------------------------------------------------------------------------
        | Validasi dasar
        |--------------------------------------------------------------------------
        */

        $validator = Validator::make(
            $request->all(),
            [
                'jenis_surat_id' =>
                    'required|integer',

                'aparat_id' =>
                    'required|integer',

                'file_ttd' =>
                    'required|image|mimes:png,jpg,jpeg|max:2048',
            ],
            [
                'jenis_surat_id.required' =>
                    'Jenis surat wajib dipilih.',

                'jenis_surat_id.integer' =>
                    'Jenis surat tidak valid.',

                'aparat_id.required' =>
                    'Penandatangan wajib dipilih.',

                'aparat_id.integer' =>
                    'Penandatangan tidak valid.',

                'file_ttd.required' =>
                    'File tanda tangan wajib diupload.',

                'file_ttd.image' =>
                    'File tanda tangan harus berupa gambar.',

                'file_ttd.mimes' =>
                    'File tanda tangan harus berupa PNG, JPG, atau JPEG.',

                'file_ttd.max' =>
                    'Ukuran file tanda tangan maksimal 2MB.',
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Validasi gagal.',
                'errors' =>
                    $validator->errors(),
            ], 422);
        }


        DB::beginTransaction();


        try {

            /*
            |--------------------------------------------------------------------------
            | Ambil jenis surat hanya dari desa aktif
            |--------------------------------------------------------------------------
            */

            $jenisSurat =
                JenisSurat::where(
                    'desa_id',
                    $desaId
                )
                    ->findOrFail(
                        $request->jenis_surat_id
                    );


            /*
            |--------------------------------------------------------------------------
            | Ambil aparat hanya dari desa aktif
            |--------------------------------------------------------------------------
            */

            $aparat =
                Aparat::where(
                    'desa_id',
                    $desaId
                )
                    ->findOrFail(
                        $request->aparat_id
                    );


            /*
            |--------------------------------------------------------------------------
            | Upload file TTD
            |--------------------------------------------------------------------------
            */

            $path =
                $request
                    ->file('file_ttd')
                    ->store(
                        'ttd',
                        'public'
                    );


            /*
            |--------------------------------------------------------------------------
            | Simpan persetujuan
            |--------------------------------------------------------------------------
            */

            $persetujuan =
                Persetujuan::create([
                    'desa_id' =>
                        $desaId,

                    'jenis_surat_id' =>
                        $jenisSurat->id,

                    'aparat_id' =>
                        $aparat->id,

                    'jabatan' =>
                        $aparat->jabatan,

                    'file_ttd' =>
                        $path,
                ]);


            DB::commit();


            Log::info(
                'Persetujuan berhasil ditambahkan.',
                [
                    'desa_id' =>
                        $desaId,

                    'id' =>
                        $persetujuan->id,

                    'jenis_surat_id' =>
                        $persetujuan->jenis_surat_id,

                    'aparat_id' =>
                        $persetujuan->aparat_id,

                    'nama_aparat' =>
                        $aparat->nama,

                    'jabatan' =>
                        $aparat->jabatan,
                ]
            );


            return response()->json([
                'success' => true,

                'message' =>
                    'Data persetujuan berhasil disimpan.',

                'data' =>
                    $persetujuan->load([
                        'jenisSurat',
                        'aparat'
                    ]),
            ], 201);

        } catch (\Throwable $e) {

            DB::rollBack();


            Log::error(
                'Gagal menyimpan persetujuan.',
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
                    'Gagal menyimpan data persetujuan.',

                'error' =>
                    $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Mengambil data untuk edit.
     */
    public function edit($id)
    {
        $desaId =
            $this->currentDesaId();


        $data =
            Persetujuan::with([
                'jenisSurat',
                'aparat'
            ])
                ->where(
                    'desa_id',
                    $desaId
                )
                ->find($id);


        if (!$data) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Data tidak ditemukan'
            ], 404);
        }


        return response()->json([
            'success' => true,

            'data' => [

                'id' =>
                    $data->id,

                'jenis_surat_id' =>
                    $data->jenis_surat_id,

                'aparat_id' =>
                    $data->aparat_id,

                'aparat' =>
                    $data->aparat
                    ? [
                        'id' =>
                            $data->aparat->id,

                        'nama' =>
                            $data->aparat->nama,

                        'jabatan' =>
                            $data->aparat->jabatan,
                    ]
                    : null,

                'file_ttd_url' =>
                    $data->file_ttd
                    ? asset(
                        'storage/'
                        . $data->file_ttd
                    )
                    : null,
            ]
        ]);
    }


    /**
     * Memperbarui persetujuan.
     */
    public function update(
        Request $request,
        $id
    ) {
        $desaId =
            $this->currentDesaId();


        /*
        |--------------------------------------------------------------------------
        | Ambil data hanya dari desa aktif
        |--------------------------------------------------------------------------
        */

        $data =
            Persetujuan::where(
                'desa_id',
                $desaId
            )
                ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        $validator = Validator::make(
            $request->all(),
            [
                'jenis_surat_id' =>
                    'required|integer',

                'aparat_id' =>
                    'required|integer',

                'file_ttd' =>
                    'nullable|image|mimes:png,jpg,jpeg|max:2048',
            ],
            [
                'jenis_surat_id.required' =>
                    'Jenis surat wajib dipilih.',

                'jenis_surat_id.integer' =>
                    'Jenis surat tidak valid.',

                'aparat_id.required' =>
                    'Penandatangan wajib dipilih.',

                'aparat_id.integer' =>
                    'Penandatangan tidak valid.',

                'file_ttd.image' =>
                    'File tanda tangan harus berupa gambar.',

                'file_ttd.mimes' =>
                    'File tanda tangan harus PNG, JPG, atau JPEG.',

                'file_ttd.max' =>
                    'Ukuran file tanda tangan maksimal 2MB.',
            ]
        );


        if ($validator->fails()) {

            return response()->json([
                'success' => false,

                'message' =>
                    'Validasi gagal.',

                'errors' =>
                    $validator->errors()
            ], 422);
        }


        DB::beginTransaction();


        try {

            /*
            |--------------------------------------------------------------------------
            | Jenis surat harus dari desa aktif
            |--------------------------------------------------------------------------
            */

            $jenisSurat =
                JenisSurat::where(
                    'desa_id',
                    $desaId
                )
                    ->findOrFail(
                        $request->jenis_surat_id
                    );


            /*
            |--------------------------------------------------------------------------
            | Aparat harus dari desa aktif
            |--------------------------------------------------------------------------
            */

            $aparat =
                Aparat::where(
                    'desa_id',
                    $desaId
                )
                    ->findOrFail(
                        $request->aparat_id
                    );


            /*
            |--------------------------------------------------------------------------
            | Update jenis surat dan aparat
            |--------------------------------------------------------------------------
            */

            $data->jenis_surat_id =
                $jenisSurat->id;

            $data->aparat_id =
                $aparat->id;

            $data->jabatan =
                $aparat->jabatan;

            $data->desa_id =
                $desaId;


            /*
            |--------------------------------------------------------------------------
            | Jika ada file TTD baru
            |--------------------------------------------------------------------------
            */

            if (
                $request->hasFile(
                    'file_ttd'
                )
            ) {

                /*
                |--------------------------------------------------------------------------
                | Hapus file TTD lama
                |--------------------------------------------------------------------------
                */

                if (
                    $data->file_ttd
                    &&
                    Storage::disk('public')
                        ->exists(
                            $data->file_ttd
                        )
                ) {
                    Storage::disk('public')
                        ->delete(
                            $data->file_ttd
                        );
                }


                /*
                |--------------------------------------------------------------------------
                | Simpan file TTD baru
                |--------------------------------------------------------------------------
                */

                $data->file_ttd =
                    $request
                        ->file('file_ttd')
                        ->store(
                            'ttd',
                            'public'
                        );
            }


            /*
            |--------------------------------------------------------------------------
            | Simpan
            |--------------------------------------------------------------------------
            */

            $data->save();


            DB::commit();


            Log::info(
                'Persetujuan berhasil diperbarui.',
                [
                    'desa_id' =>
                        $desaId,

                    'persetujuan_id' =>
                        $data->id,

                    'jenis_surat_id' =>
                        $data->jenis_surat_id,

                    'aparat_id' =>
                        $aparat->id,

                    'nama_aparat' =>
                        $aparat->nama,

                    'jabatan' =>
                        $aparat->jabatan,
                ]
            );


            return response()->json([
                'success' => true,

                'message' =>
                    'Data persetujuan berhasil diperbarui.',

                'data' =>
                    $data->load([
                        'jenisSurat',
                        'aparat'
                    ])
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();


            Log::error(
                'Gagal memperbarui persetujuan.',
                [
                    'desa_id' =>
                        $desaId,

                    'id' =>
                        $id,

                    'message' =>
                        $e->getMessage(),

                    'trace' =>
                        $e->getTraceAsString(),
                ]
            );


            return response()->json([
                'success' => false,

                'message' =>
                    'Gagal memperbarui data persetujuan.',

                'error' =>
                    $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Menghapus persetujuan.
     */
    public function destroy($id)
    {
        try {

            $desaId =
                $this->currentDesaId();


            /*
            |--------------------------------------------------------------------------
            | Hanya boleh menghapus data dari desa aktif
            |--------------------------------------------------------------------------
            */

            $data =
                Persetujuan::where(
                    'desa_id',
                    $desaId
                )
                    ->find($id);


            if (!$data) {

                return response()->json([
                    'success' => false,
                    'message' =>
                        'Data tidak ditemukan!'
                ], 404);
            }


            /*
            |--------------------------------------------------------------------------
            | Hapus file TTD
            |--------------------------------------------------------------------------
            */

            if (
                $data->file_ttd
                &&
                Storage::disk('public')
                    ->exists(
                        $data->file_ttd
                    )
            ) {

                Storage::disk('public')
                    ->delete(
                        $data->file_ttd
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Hapus data
            |--------------------------------------------------------------------------
            */

            $data->delete();


            Log::info(
                'Persetujuan berhasil dihapus.',
                [
                    'desa_id' =>
                        $desaId,

                    'persetujuan_id' =>
                        $id,
                ]
            );


            return response()->json([
                'success' =>
                    true,

                'message' =>
                    'Data berhasil dihapus!'
            ]);

        } catch (\Throwable $e) {

            Log::error(
                'Gagal menghapus persetujuan.',
                [
                    'desa_id' =>
                        auth()->user()?->desa_id,

                    'persetujuan_id' =>
                        $id,

                    'message' =>
                        $e->getMessage(),
                ]
            );


            return response()->json([
                'success' =>
                    false,

                'message' =>
                    'Data gagal dihapus.'
            ], 500);
        }
    }
}