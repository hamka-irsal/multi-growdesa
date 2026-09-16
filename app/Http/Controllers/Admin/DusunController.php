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
     * Menampilkan halaman data dusun
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        // Query data dusun
        $query = Dusun::query();

        // Pencarian berdasarkan nama dusun atau nama kepala dusun
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_dusun', 'like', "%{$search}%")
                    ->orWhere('nama_kepdus', 'like', "%{$search}%")
                    ->orWhere('no_wa', 'like', "%{$search}%");
            });
        }

        $dusun = $query->paginate($perPage);

        return view('admin.dusun.index', compact(
            'dusun',
            'perPage',
            'search'
        ));
    }

    /**
     * Pencarian data dusun
     */
    public function searchDusun(Request $request)
    {
        try {
            $query = $request->input('query');

            $dusun = Dusun::where(function ($q) use ($query) {
                $q->where('nama_dusun', 'like', '%' . $query . '%')
                    ->orWhere('nama_kepdus', 'like', '%' . $query . '%')
                    ->orWhere('no_wa', 'like', '%' . $query . '%');
            })->get();

            return response()->json([
                'success' => true,
                'data' => $dusun
            ]);

        } catch (\Exception $e) {

            Log::error('❌ Kesalahan saat pencarian dusun:', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pencarian!'
            ], 500);
        }
    }

    /**
     * Pagination data dusun
     */
    public function paginate(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Dusun::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_dusun', 'like', "%{$search}%")
                    ->orWhere('nama_kepdus', 'like', "%{$search}%")
                    ->orWhere('no_wa', 'like', "%{$search}%");
            });
        }

        $dusun = $query->paginate($perPage);

        return response()->json($dusun);
    }

    /**
     * Menyimpan data dusun
     */
    public function store(Request $request)
    {
        try {

            Log::info('📥 Data masuk ke store dusun:', $request->all());

            $validator = Validator::make($request->all(), [
                'nama_dusun' => 'required|string|max:255',
                'nama_kepdus' => 'required|string|max:255',
                'no_wa' => 'required|string|max:20',
            ]);

            if ($validator->fails()) {

                Log::error('❌ Validasi dusun gagal:', [
                    'errors' => $validator->errors()->toArray()
                ]);

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Cek apakah nama dusun sudah terdaftar
            $existingDusun = Dusun::where(
                'nama_dusun',
                $request->nama_dusun
            )->first();

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

            $dusun->nama_dusun = $request->nama_dusun;
            $dusun->nama_kepdus = $request->nama_kepdus;
            $dusun->no_wa = $request->no_wa;

            $dusun->save();

            DB::commit();

            Log::info('✅ Data dusun berhasil disimpan:', [
                'id' => $dusun->id,
                'nama_dusun' => $dusun->nama_dusun
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dusun berhasil ditambahkan!',
                'data' => $dusun
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('❌ Kesalahan saat menyimpan data dusun:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

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

            $dusun = Dusun::findOrFail($id);

            $data = [
                'id' => $dusun->id,
                'nama_dusun' => $dusun->nama_dusun,
                'nama_kepdus' => $dusun->nama_kepdus,
                'no_wa' => $dusun->no_wa,
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {

            Log::error('❌ Gagal mengambil data dusun untuk edit:', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Data dusun tidak ditemukan.'
            ], 404);
        }
    }

    /**
     * Update data dusun
     */
    public function update(Request $request, $id)
    {
        Log::info('📥 Request update dusun masuk:', [
            'id' => $id,
            'data' => $request->all()
        ]);

        $validator = Validator::make($request->all(), [
            'nama_dusun' => 'required|string|max:255',
            'nama_kepdus' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {

            Log::error('❌ Validasi gagal saat update dusun:', [
                'errors' => $validator->errors()->toArray()
            ]);

            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $dusun = Dusun::findOrFail($id);

            // Cek apakah nama dusun sudah digunakan dusun lain
            $existingDusun = Dusun::where('nama_dusun', $request->nama_dusun)
                ->where('id', '!=', $dusun->id)
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

            // Update data
            $dusun->nama_dusun = $request->nama_dusun;
            $dusun->nama_kepdus = $request->nama_kepdus;
            $dusun->no_wa = $request->no_wa;

            $dusun->save();

            Log::info('✅ Data dusun berhasil diperbarui:', [
                'id' => $dusun->id,
                'nama_dusun' => $dusun->nama_dusun
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data dusun berhasil diperbarui!',
                'data' => $dusun
            ]);

        } catch (\Exception $e) {

            Log::error('❌ Kesalahan saat update dusun:', [
                'id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

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
        $dusun = Dusun::find($id);

        if (!$dusun) {
            return response()->json([
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        $dusun->delete();

        return response()->json([
            'message' => 'Data dusun berhasil dihapus.'
        ]);
    }
}
