<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dusun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DusunController extends Controller
{
    /**
     * Mengambil desa_id dari akun yang sedang login.
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
     * Menampilkan halaman data dusun
     */
    public function index(Request $request)
    {
        $desaId = $this->currentDesaId();

        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        // Query hanya dusun milik desa yang sedang login
        $query = Dusun::where(
            'desa_id',
            $desaId
        );

        // Pencarian berdasarkan nama dusun,
        // nama kepala dusun, atau nomor WhatsApp
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where(
                    'nama_dusun',
                    'like',
                    "%{$search}%"
                )
                    ->orWhere(
                        'nama_kepdus',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'no_wa',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        $dusun = $query->paginate($perPage);

        return view(
            'admin.dusun.index',
            compact(
                'dusun',
                'perPage',
                'search'
            )
        );
    }


    /**
     * Pencarian data dusun
     */
    public function searchDusun(Request $request)
    {
        try {

            $desaId = $this->currentDesaId();

            $query = $request->input('query');

            $dusun = Dusun::where(
                'desa_id',
                $desaId
            )
                ->where(function ($q) use ($query) {

                    $q->where(
                        'nama_dusun',
                        'like',
                        '%' . $query . '%'
                    )
                        ->orWhere(
                            'nama_kepdus',
                            'like',
                            '%' . $query . '%'
                        )
                        ->orWhere(
                            'no_wa',
                            'like',
                            '%' . $query . '%'
                        );
                })
                ->get();

            return response()->json([
                'success' => true,
                'data' => $dusun
            ]);

        } catch (\Exception $e) {

            Log::error(
                '❌ Kesalahan saat pencarian dusun:',
                [
                    'desa_id' =>
                        auth()->user()?->desa_id,

                    'message' =>
                        $e->getMessage()
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
     * Pagination data dusun
     */
    public function paginate(Request $request)
    {
        $desaId = $this->currentDesaId();

        $perPage = $request->input(
            'perPage',
            10
        );

        $search = $request->input(
            'search'
        );

        // Hanya dusun dari desa yang login
        $query = Dusun::where(
            'desa_id',
            $desaId
        );

        if (!empty($search)) {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nama_dusun',
                    'like',
                    "%{$search}%"
                )
                    ->orWhere(
                        'nama_kepdus',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'no_wa',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        $dusun = $query->paginate(
            $perPage
        );

        return response()->json(
            $dusun
        );
    }


    /**
     * Menyimpan data dusun
     */
    public function store(Request $request)
    {
        $desaId = $this->currentDesaId();

        try {

            Log::info(
                '📥 Data masuk ke store dusun:',
                [
                    'desa_id' => $desaId,
                    'data' => $request->all()
                ]
            );

            $validator = Validator::make(
                $request->all(),
                [
                    'nama_dusun' =>
                        'required|string|max:255',

                    'nama_kepdus' =>
                        'required|string|max:255',

                    'no_wa' =>
                        'required|string|max:20',
                ]
            );

            if ($validator->fails()) {

                Log::error(
                    '❌ Validasi dusun gagal:',
                    [
                        'desa_id' => $desaId,
                        'errors' =>
                            $validator
                                ->errors()
                                ->toArray()
                    ]
                );

                return response()->json([
                    'success' => false,
                    'errors' =>
                        $validator->errors()
                ], 422);
            }

            /*
            |--------------------------------------------------------------------------
            | Cek nama dusun pada desa yang sedang login
            |--------------------------------------------------------------------------
            */
            $existingDusun = Dusun::where(
                'desa_id',
                $desaId
            )
                ->where(
                    'nama_dusun',
                    $request->nama_dusun
                )
                ->first();

            if ($existingDusun) {

                return response()->json([
                    'success' => false,
                    'errors' => [
                        'nama_dusun' => [
                            'Dusun tersebut sudah terdaftar.'
                        ]
                    ]
                ], 422);
            }

            DB::beginTransaction();

            $dusun = new Dusun();

            // desa_id diambil dari akun login
            $dusun->desa_id =
                $desaId;

            $dusun->nama_dusun =
                $request->nama_dusun;

            $dusun->nama_kepdus =
                $request->nama_kepdus;

            $dusun->no_wa =
                $request->no_wa;

            $dusun->save();

            DB::commit();

            Log::info(
                '✅ Data dusun berhasil disimpan:',
                [
                    'id' =>
                        $dusun->id,

                    'desa_id' =>
                        $dusun->desa_id,

                    'nama_dusun' =>
                        $dusun->nama_dusun
                ]
            );

            return response()->json([
                'success' => true,

                'message' =>
                    'Dusun berhasil ditambahkan!',

                'data' =>
                    $dusun
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error(
                '❌ Kesalahan saat menyimpan data dusun:',
                [
                    'desa_id' => $desaId,

                    'message' =>
                        $e->getMessage(),

                    'trace' =>
                        $e->getTraceAsString()
                ]
            );

            return response()->json([
                'success' => false,

                'errors' => [
                    'general' => [
                        'Terjadi kesalahan, coba lagi!'
                    ]
                ]
            ], 500);
        }
    }


    /**
     * Mengambil data dusun untuk edit
     */
    public function edit($id)
    {
        try {

            $desaId = $this->currentDesaId();

            /*
            |--------------------------------------------------------------------------
            | Hanya boleh mengambil dusun dari desa sendiri
            |--------------------------------------------------------------------------
            */
            $dusun = Dusun::where(
                'desa_id',
                $desaId
            )
                ->findOrFail(
                    $id
                );

            $data = [
                'id' =>
                    $dusun->id,

                'nama_dusun' =>
                    $dusun->nama_dusun,

                'nama_kepdus' =>
                    $dusun->nama_kepdus,

                'no_wa' =>
                    $dusun->no_wa,
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {

            Log::error(
                '❌ Gagal mengambil data dusun untuk edit:',
                [
                    'id' => $id,

                    'desa_id' =>
                        auth()->user()?->desa_id,

                    'message' =>
                        $e->getMessage(),
                ]
            );

            return response()->json([
                'success' => false,
                'message' =>
                    'Data dusun tidak ditemukan.'
            ], 404);
        }
    }


    /**
     * Update data dusun
     */
    public function update(
        Request $request,
        $id
    ) {

        $desaId = $this->currentDesaId();

        Log::info(
            '📥 Request update dusun masuk:',
            [
                'id' => $id,

                'desa_id' =>
                    $desaId,

                'data' =>
                    $request->all()
            ]
        );

        $validator = Validator::make(
            $request->all(),
            [
                'nama_dusun' =>
                    'required|string|max:255',

                'nama_kepdus' =>
                    'required|string|max:255',

                'no_wa' =>
                    'required|string|max:20',
            ]
        );

        if ($validator->fails()) {

            Log::error(
                '❌ Validasi gagal saat update dusun:',
                [
                    'desa_id' => $desaId,

                    'errors' =>
                        $validator
                            ->errors()
                            ->toArray()
                ]
            );

            return response()->json([
                'success' => false,
                'errors' =>
                    $validator->errors()
            ], 422);
        }

        try {

            /*
            |--------------------------------------------------------------------------
            | Ambil dusun hanya dari desa sendiri
            |--------------------------------------------------------------------------
            */
            $dusun = Dusun::where(
                'desa_id',
                $desaId
            )
                ->findOrFail(
                    $id
                );

            /*
            |--------------------------------------------------------------------------
            | Cek nama dusun hanya dalam desa yang sama
            |--------------------------------------------------------------------------
            */
            $existingDusun = Dusun::where(
                'desa_id',
                $desaId
            )
                ->where(
                    'nama_dusun',
                    $request->nama_dusun
                )
                ->where(
                    'id',
                    '!=',
                    $dusun->id
                )
                ->first();

            if ($existingDusun) {

                return response()->json([
                    'success' => false,

                    'errors' => [
                        'nama_dusun' => [
                            'Nama dusun tersebut sudah digunakan oleh data dusun lain.'
                        ]
                    ]
                ], 422);
            }

            /*
            |--------------------------------------------------------------------------
            | Update data
            |--------------------------------------------------------------------------
            */
            $dusun->desa_id =
                $desaId;

            $dusun->nama_dusun =
                $request->nama_dusun;

            $dusun->nama_kepdus =
                $request->nama_kepdus;

            $dusun->no_wa =
                $request->no_wa;

            $dusun->save();

            Log::info(
                '✅ Data dusun berhasil diperbarui:',
                [
                    'id' =>
                        $dusun->id,

                    'desa_id' =>
                        $dusun->desa_id,

                    'nama_dusun' =>
                        $dusun->nama_dusun
                ]
            );

            return response()->json([
                'success' => true,

                'message' =>
                    'Data dusun berhasil diperbarui!',

                'data' =>
                    $dusun
            ]);

        } catch (\Exception $e) {

            Log::error(
                '❌ Kesalahan saat update dusun:',
                [
                    'id' => $id,

                    'desa_id' =>
                        $desaId,

                    'message' =>
                        $e->getMessage(),

                    'trace' =>
                        $e->getTraceAsString()
                ]
            );

            return response()->json([
                'success' => false,

                'errors' => [
                    'general' => [
                        'Terjadi kesalahan, coba lagi!'
                    ]
                ]
            ], 500);
        }
    }


    /**
     * Menghapus data dusun
     */
    public function destroy($id)
    {
        try {

            $desaId = $this->currentDesaId();

            /*
            |--------------------------------------------------------------------------
            | Hanya boleh menghapus dusun dari desa sendiri
            |--------------------------------------------------------------------------
            */
            $dusun = Dusun::where(
                'desa_id',
                $desaId
            )
                ->find(
                    $id
                );

            if (!$dusun) {

                return response()->json([
                    'message' =>
                        'Data tidak ditemukan!'
                ], 404);
            }

            $dusun->delete();

            Log::info(
                '✅ Data dusun berhasil dihapus:',
                [
                    'id' =>
                        $id,

                    'desa_id' =>
                        $desaId
                ]
            );

            return response()->json([
                'message' =>
                    'Data dusun berhasil dihapus.'
            ]);

        } catch (\Exception $e) {

            Log::error(
                '❌ Kesalahan saat menghapus dusun:',
                [
                    'id' => $id,

                    'desa_id' =>
                        auth()->user()?->desa_id,

                    'message' =>
                        $e->getMessage()
                ]
            );

            return response()->json([
                'message' =>
                    'Terjadi kesalahan saat menghapus data dusun.'
            ], 500);
        }
    }
}