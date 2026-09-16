<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apbdes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApbdesController extends Controller
{
    /**
     * Menampilkan halaman data APBDes.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Apbdes::query();

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('tahun', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $apbdes = $query
            ->orderByDesc('tahun')
            ->paginate($perPage);

        return view(
            'admin.apbdes.index',
            compact(
                'apbdes',
                'perPage',
                'search'
            )
        );
    }


    /**
     * Pencarian APBDes.
     */
    public function search(Request $request)
    {
        try {
            $search = $request->input('query');

            $apbdes = Apbdes::query()
                ->where(function ($query) use ($search) {
                    $query->where('tahun', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                })
                ->orderByDesc('tahun')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $apbdes,
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal melakukan pencarian APBDes.', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pencarian APBDes!',
            ], 500);
        }
    }


    /**
     * Menampilkan data APBDes menggunakan AJAX pagination.
     */
    public function paginate(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Apbdes::query();

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('tahun', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $apbdes = $query
            ->orderByDesc('tahun')
            ->paginate($perPage);

        return response()->json($apbdes);
    }


    /**
     * Menambahkan APBDes baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'tahun' => [
                    'required',
                    'integer',
                    'digits:4',
                    'unique:apbdes,tahun',
                ],

                'total_pendapatan' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'realisasi_pendapatan' => [
                    'required',
                    'numeric',
                    'min:0',
                    'lte:total_pendapatan',
                ],

                'total_belanja' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'realisasi_belanja' => [
                    'required',
                    'numeric',
                    'min:0',
                    'lte:total_belanja',
                ],

                'total_pembiayaan' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'realisasi_pembiayaan' => [
                    'required',
                    'numeric',
                    'min:0',
                    'lte:total_pembiayaan',
                ],

                'silpa_tahun_lalu' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'pemerintahan' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'pembangunan' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'pemberdayaan' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'lainnya' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'status' => [
                    'required',
                    'in:draft,published,archived',
                ],
            ]
        );

        if ($validator->fails()) {
            Log::error('Validasi APBDes gagal.', [
                'errors' => $validator->errors()->toArray(),
            ]);

            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $apbdes = Apbdes::create([
                'tahun' => $request->tahun,
                'total_pendapatan' => $request->total_pendapatan,
                'realisasi_pendapatan' => $request->realisasi_pendapatan,
                'total_belanja' => $request->total_belanja,
                'realisasi_belanja' => $request->realisasi_belanja,
                'total_pembiayaan' => $request->total_pembiayaan,
                'realisasi_pembiayaan' => $request->realisasi_pembiayaan,
                'silpa_tahun_lalu' => $request->silpa_tahun_lalu,
                'pemerintahan' => $request->pemerintahan,
                'pembangunan' => $request->pembangunan,
                'pemberdayaan' => $request->pemberdayaan,
                'lainnya' => $request->lainnya,
                'status' => $request->status,
            ]);

            DB::commit();

            Log::info('APBDes berhasil ditambahkan.', [
                'id' => $apbdes->id,
                'tahun' => $apbdes->tahun,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'APBDes berhasil ditambahkan!',
                'data' => $apbdes,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Gagal menyimpan APBDes.', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan, APBDes gagal ditambahkan!',
            ], 500);
        }
    }


    /**
     * Mengambil data APBDes untuk modal edit.
     */
    public function edit($id)
    {
        try {
            $apbdes = Apbdes::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $apbdes,
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal memuat data edit APBDes.', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data APBDes.',
            ], 500);
        }
    }


    /**
     * Memperbarui data APBDes.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'tahun' => [
                    'required',
                    'integer',
                    'digits:4',
                    Rule::unique('apbdes', 'tahun')->ignore($id),
                ],

                'total_pendapatan' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'realisasi_pendapatan' => [
                    'required',
                    'numeric',
                    'min:0',
                    'lte:total_pendapatan',
                ],

                'total_belanja' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'realisasi_belanja' => [
                    'required',
                    'numeric',
                    'min:0',
                    'lte:total_belanja',
                ],

                'total_pembiayaan' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'realisasi_pembiayaan' => [
                    'required',
                    'numeric',
                    'min:0',
                    'lte:total_pembiayaan',
                ],

                'silpa_tahun_lalu' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'pemerintahan' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'pembangunan' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'pemberdayaan' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'lainnya' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'status' => [
                    'required',
                    'in:draft,published,archived',
                ],
            ]
        );

        if ($validator->fails()) {
            Log::error('Validasi update APBDes gagal.', [
                'id' => $id,
                'errors' => $validator->errors()->toArray(),
            ]);

            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $apbdes = Apbdes::findOrFail($id);

            $apbdes->update([
                'tahun' => $request->tahun,
                'total_pendapatan' => $request->total_pendapatan,
                'realisasi_pendapatan' => $request->realisasi_pendapatan,
                'total_belanja' => $request->total_belanja,
                'realisasi_belanja' => $request->realisasi_belanja,
                'total_pembiayaan' => $request->total_pembiayaan,
                'realisasi_pembiayaan' => $request->realisasi_pembiayaan,
                'silpa_tahun_lalu' => $request->silpa_tahun_lalu,
                'pemerintahan' => $request->pemerintahan,
                'pembangunan' => $request->pembangunan,
                'pemberdayaan' => $request->pemberdayaan,
                'lainnya' => $request->lainnya,
                'status' => $request->status,
            ]);

            DB::commit();

            Log::info('APBDes berhasil diperbarui.', [
                'id' => $apbdes->id,
                'tahun' => $apbdes->tahun,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'APBDes berhasil diperbarui!',
                'data' => $apbdes->fresh(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Gagal memperbarui APBDes.', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan, APBDes gagal diperbarui!',
            ], 500);
        }
    }


    /**
     * Menghapus APBDes.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $apbdes = Apbdes::find($id);

            if (!$apbdes) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data APBDes tidak ditemukan!',
                ], 404);
            }

            $tahun = $apbdes->tahun;

            $apbdes->delete();

            DB::commit();

            Log::info('APBDes berhasil dihapus.', [
                'id' => $id,
                'tahun' => $tahun,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'APBDes berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Gagal menghapus APBDes.', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus APBDes!',
            ], 500);
        }
    }
}
