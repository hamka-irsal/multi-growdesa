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
     * Menampilkan halaman data APBDes sesuai desa admin.
     */
    public function index(Request $request)
    {
        $desaId = $this->currentDesaId();

        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Apbdes::query()
            ->where('desa_id', $desaId);

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('tahun', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $apbdes = $query
            ->orderByDesc('tahun')
            ->paginate($perPage)
            ->withQueryString();

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
     * Pencarian APBDes berdasarkan desa admin.
     */
    public function search(Request $request)
    {
        try {
            $desaId = $this->currentDesaId();

            $search = $request->input('query', '');

            $apbdes = Apbdes::query()
                ->where('desa_id', $desaId)
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
     * Menampilkan data APBDes menggunakan AJAX pagination
     * sesuai desa admin.
     */
    public function paginate(Request $request)
    {
        $desaId = $this->currentDesaId();

        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Apbdes::query()
            ->where('desa_id', $desaId);

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
     * Menambahkan APBDes baru dengan desa_id otomatis.
     */
    public function store(Request $request)
    {
        $desaId = $this->currentDesaId();

        // DEBUG
        Log::info('DEBUG STORE APBDES', [
            'user_id' => auth()->id(),
            'user_desa_id' => auth()->user()?->desa_id,
            'desa_id' => $desaId,
            'request' => $request->all(),
        ]);

        $validator = Validator::make(
            $request->all(),
            [
                'tahun' => [
                    'required',
                    'integer',
                    'digits:4',
                    Rule::unique('apbdes', 'tahun')
                        ->where(function ($query) use ($desaId) {
                            return $query->where('desa_id', $desaId);
                        }),
                ],

                'total_pendapatan' => ['required', 'numeric', 'min:0'],
                'realisasi_pendapatan' => [
                    'required',
                    'numeric',
                    'min:0',
                    'lte:total_pendapatan',
                ],

                'total_belanja' => ['required', 'numeric', 'min:0'],
                'realisasi_belanja' => [
                    'required',
                    'numeric',
                    'min:0',
                    'lte:total_belanja',
                ],

                'total_pembiayaan' => ['required', 'numeric', 'min:0'],
                'realisasi_pembiayaan' => [
                    'required',
                    'numeric',
                    'min:0',
                    'lte:total_pembiayaan',
                ],

                'silpa_tahun_lalu' => ['required', 'numeric', 'min:0'],
                'pemerintahan' => ['required', 'numeric', 'min:0'],
                'pembangunan' => ['required', 'numeric', 'min:0'],
                'pemberdayaan' => ['required', 'numeric', 'min:0'],
                'lainnya' => ['required', 'numeric', 'min:0'],

                'status' => [
                    'required',
                    'in:draft,published,archived',
                ],
            ]
        );

        if ($validator->fails()) {
            Log::error('Validasi APBDes gagal.', [
                'desa_id' => $desaId,
                'errors' => $validator->errors()->toArray(),
            ]);

            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $data = [
                'desa_id' => $desaId,
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
            ];

            // DEBUG DATA SEBELUM INSERT
            Log::info('DATA APBDES SEBELUM CREATE', $data);

            $apbdes = Apbdes::create($data);

            // DEBUG HASIL CREATE
            Log::info('HASIL CREATE APBDES', [
                'id' => $apbdes->id,
                'desa_id' => $apbdes->desa_id,
                'tahun' => $apbdes->tahun,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'APBDes berhasil ditambahkan!',
                'data' => $apbdes,
            ], 201);
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Gagal menyimpan APBDes.', [
                'desa_id' => $desaId,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan, APBDes gagal ditambahkan!',
            ], 500);
        }
    }

    /**
     * Mengambil data APBDes untuk modal edit.
     * Hanya dari desa admin yang login.
     */
    public function edit($id)
    {
        try {
            $desaId = $this->currentDesaId();

            $apbdes = Apbdes::where('desa_id', $desaId)
                ->find($id);

            if (!$apbdes) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data APBDes tidak ditemukan.',
                ], 404);
            }

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
     * Memperbarui data APBDes sesuai desa admin.
     */
    public function update(Request $request, $id)
    {
        $desaId = $this->currentDesaId();

        // Pastikan APBDes berasal dari desa admin.
        $apbdes = Apbdes::where('desa_id', $desaId)
            ->find($id);

        if (!$apbdes) {
            return response()->json([
                'success' => false,
                'message' => 'Data APBDes tidak ditemukan.',
            ], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'tahun' => [
                    'required',
                    'integer',
                    'digits:4',
                    Rule::unique('apbdes', 'tahun')
                        ->where(function ($query) use ($desaId) {
                            return $query->where('desa_id', $desaId);
                        })
                        ->ignore($apbdes->id),
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
                'desa_id' => $desaId,
                'errors' => $validator->errors()->toArray(),
            ]);

            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $apbdes->update([
                // Tetap pertahankan desa_id dari akun login.
                'desa_id' => $desaId,

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
                'desa_id' => $desaId,
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
                'desa_id' => $desaId,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan, APBDes gagal diperbarui!',
            ], 500);
        }
    }

    /**
     * Menghapus APBDes hanya dari desa admin.
     */
    public function destroy($id)
    {
        try {
            $desaId = $this->currentDesaId();

            DB::beginTransaction();

            $apbdes = Apbdes::where('desa_id', $desaId)
                ->find($id);

            if (!$apbdes) {
                DB::rollBack();

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
                'desa_id' => $desaId,
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
                'desa_id' => $desaId ?? null,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus APBDes!',
            ], 500);
        }
    }
}
